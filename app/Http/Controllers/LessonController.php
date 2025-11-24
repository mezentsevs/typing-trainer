<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\LessonResult;
use App\Rules\LanguageSupported;
use App\Rules\MaxUnsignedInteger;
use App\Services\LessonService;
use App\Traits\Constants\WithLessonConstants;
use App\Traits\Constants\WithStatisticsConstants;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    use AuthorizesRequests, WithLessonConstants, WithStatisticsConstants;

    public function __construct(protected LessonService $lessonService)
    {
    }

    public function show(string $language, int $lessonNumber): JsonResponse
    {
        validator([
            'language' => $language,
            'lesson_number' => $lessonNumber,
        ], [
            'language' => [new LanguageSupported()],
            'lesson_number' => sprintf('integer|min:%d|max:%d', self::MIN_LESSON_COUNT, self::MAX_LESSON_COUNT),
        ])->validate();

        return response()->json([
            'lesson' => Lesson::where('user_id', auth()->id())
                ->where('language', $language)
                ->where('number', $lessonNumber)
                ->firstOrFail(),
        ]);
    }

    public function generate(Request $request): JsonResponse
    {
        $request->validate([
            'language' => ['required', 'bail', 'string', new LanguageSupported()],
            'lesson_count' => sprintf(
                'required|bail|integer:strict|min:%d|max:%d',
                self::MIN_LESSON_COUNT,
                self::MAX_LESSON_COUNT,
            ),
        ]);

        $this->lessonService->generateLessons($request->language, $request->lesson_count, auth()->id());

        return response()->json(['message' => 'Lessons generated']);
    }

    public function saveResult(Request $request): JsonResponse
    {
        $request->validate([
            'lesson_id' => 'required|integer:strict|exists:lessons,id',
            'language' => ['required', 'bail', 'string', new LanguageSupported()],
            'time_seconds' => ['required', 'bail', 'integer:strict', 'min:' . self::MIN_TIME_SECONDS, new MaxUnsignedInteger()],
            'speed_wpm' => ['required', 'bail', 'integer:strict', 'min:' . self::MIN_SPEED_WPM, new MaxUnsignedInteger()],
            'errors' => ['required', 'bail', 'integer:strict', 'min:' . self::MIN_ERRORS_COUNT, new MaxUnsignedInteger()],
        ]);

        $this->authorize('saveResult', Lesson::findOrFail($request->lesson_id));

        return response()->json(LessonResult::create([
            'user_id' => auth()->id(),
            'lesson_id' => $request->lesson_id,
            'language' => $request->language,
            'time_seconds' => $request->time_seconds,
            'speed_wpm' => $request->speed_wpm,
            'errors' => $request->errors,
        ]));
    }
}
