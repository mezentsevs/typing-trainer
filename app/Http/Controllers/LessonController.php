<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Services\LessonService;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    protected $lessonService;

    public function __construct(LessonService $lessonService)
    {
        $this->lessonService = $lessonService;
    }

    public function generate(Request $request)
    {
        $request->validate([
            'language' => 'required|string',
            'lesson_count' => 'required|integer|min:1',
        ]);

        $this->lessonService->generateLessons($request->language, $request->lesson_count);

        return response()->json(['message' => 'Lessons generated']);
    }

    public function index(string $language)
    {
        $lessons = Lesson::where('language', $language)->get();
        return response()->json($lessons);
    }

    public function getText(string $language, int $lessonNumber)
    {
        $text = $this->lessonService->generateLessonText($language, $lessonNumber);
        return response()->json(['text' => $text]);
    }

    public function saveProgress(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'time_seconds' => 'required|integer',
            'speed_wpm' => 'required|integer',
            'errors' => 'required|integer',
        ]);

        $progress = LessonProgress::create([
            'user_id' => auth()->id(),
            'lesson_id' => $request->lesson_id,
            'time_seconds' => $request->time_seconds,
            'speed_wpm' => $request->speed_wpm,
            'errors' => $request->errors,
        ]);

        return response()->json($progress);
    }
}
