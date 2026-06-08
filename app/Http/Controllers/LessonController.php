<?php

namespace App\Http\Controllers;

use App\Http\Requests\Lesson\LessonGenerateRequest;
use App\Http\Requests\Lesson\LessonSaveResultRequest;
use App\Http\Requests\Lesson\LessonShowRequest;
use App\Models\Lesson;
use App\Models\LessonResult;
use App\Services\LessonService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class LessonController extends Controller
{
    use AuthorizesRequests;

    public function __construct(protected LessonService $lessonService)
    {
    }

    public function show(LessonShowRequest $request, string $language, int $lessonNumber): JsonResponse
    {
        return response()->json([
            'lesson' => Lesson::where('user_id', auth()->id())
                ->where('language', $language)
                ->where('number', $lessonNumber)
                ->firstOrFail(),
        ]);
    }

    public function generate(LessonGenerateRequest $request): JsonResponse
    {
        $this->lessonService->generateLessons($request->language, $request->lesson_count, auth()->id());

        return response()->json(['message' => 'Lessons generated']);
    }

    public function saveResult(LessonSaveResultRequest $request): JsonResponse
    {
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
