<?php

namespace App\Http\Controllers;

use App\Dtos\Lesson\LessonGenerateDto;
use App\Dtos\Lesson\LessonSaveResultDto;
use App\Dtos\Lesson\LessonShowDto;
use App\Http\Requests\Lesson\LessonGenerateRequest;
use App\Http\Requests\Lesson\LessonSaveResultRequest;
use App\Http\Requests\Lesson\LessonShowRequest;
use App\Models\Lesson;
use App\Models\LessonResult;
use App\Services\Lesson\LessonService;
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
        $dto = LessonShowDto::fromArray([
            'userId' => $request->user()->id,
            'language' => $language,
            'lessonNumber' => $lessonNumber,
        ]);

        return response()->json(['lesson' => $this->lessonService->show($dto)]);
    }

    public function generate(LessonGenerateRequest $request): JsonResponse
    {
        $dto = LessonGenerateDto::fromRequest($request);

        $this->lessonService->generate($dto);

        return response()->json(['message' => 'Lessons generated']);
    }

    public function saveResult(LessonSaveResultRequest $request): JsonResponse
    {
        $this->authorize('create', [LessonResult::class, Lesson::findOrFail($request->lesson_id)]);

        $dto = LessonSaveResultDto::fromRequest($request);

        return response()->json($this->lessonService->saveResult($dto));
    }
}
