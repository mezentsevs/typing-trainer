<?php

namespace App\Http\Controllers;

use App\Dtos\LessonGenerateDto;
use App\Dtos\LessonSaveResultDto;
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
        $dto = LessonGenerateDto::fromArray([
            'userId' => auth()->id(),
            'language' => $request->language,
            'lessonCount' => $request->lesson_count,
        ]);

        $this->lessonService->generate($dto);

        return response()->json(['message' => 'Lessons generated']);
    }

    public function saveResult(LessonSaveResultRequest $request): JsonResponse
    {
        $this->authorize('create', [LessonResult::class, Lesson::findOrFail($request->lesson_id)]);

        $dto = LessonSaveResultDto::fromArray([
            'userId' => auth()->id(),
            'lessonId' => $request->lesson_id,
            'language' => $request->language,
            'timeSeconds' => $request->time_seconds,
            'speedWpm' => $request->speed_wpm,
            'errors' => $request->errors,
        ]);

        return response()->json($this->lessonService->saveResult($dto));
    }
}
