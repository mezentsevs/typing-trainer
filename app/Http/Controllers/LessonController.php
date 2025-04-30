<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Services\LessonService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function __construct(protected LessonService $lessonService) {}

    public function generate(Request $request): JsonResponse
    {
        $request->validate([
            'language' => 'required|string',
            'lesson_count' => 'required|integer|min:1',
        ]);

        $this->lessonService->generateLessons($request->language, $request->lesson_count, auth()->id());

        return response()->json(['message' => 'Lessons generated']);
    }

    public function index(string $language): JsonResponse
    {
        $lessons = Lesson::where('language', $language)->where('user_id', auth()->id())->get();

        return response()->json($lessons);
    }

    public function getText(string $language, int $lessonNumber): JsonResponse
    {
        $text = $this->lessonService->generateLessonText($language, $lessonNumber, auth()->id());

        return response()->json(['text' => $text]);
    }

    public function saveProgress(Request $request): JsonResponse
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'language' => 'required|string',
            'time_seconds' => 'required|integer',
            'speed_wpm' => 'required|integer',
            'errors' => 'required|integer',
        ]);

        $progress = LessonProgress::create([
            'user_id' => auth()->id(),
            'lesson_id' => $request->lesson_id,
            'language' => $request->language,
            'time_seconds' => $request->time_seconds,
            'speed_wpm' => $request->speed_wpm,
            'errors' => $request->errors,
        ]);

        return response()->json($progress);
    }
}
