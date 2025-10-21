<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\LessonResult;
use App\Rules\LanguageSupported;
use App\Services\LessonService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function __construct(protected LessonService $lessonService)
    {
    }

    public function show(string $language, int $lessonNumber): JsonResponse
    {
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
            'language' => ['required', 'string', new LanguageSupported()],
            'lesson_count' => 'required|integer|min:1',
        ]);

        $this->lessonService->generateLessons($request->language, $request->lesson_count, auth()->id());

        return response()->json(['message' => 'Lessons generated']);
    }

    public function saveResult(Request $request): JsonResponse
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'language' => ['required', 'string', new LanguageSupported()],
            'time_seconds' => 'required|integer|min:0',
            'speed_wpm' => 'required|integer|min:0',
            'errors' => 'required|integer|min:0',
        ]);

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
