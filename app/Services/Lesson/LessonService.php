<?php

namespace App\Services\Lesson;

use App\Dtos\Lesson\LessonGenerateDto;
use App\Dtos\Lesson\LessonSaveResultDto;
use App\Dtos\Lesson\LessonShowDto;
use App\Models\Lesson;
use App\Models\LessonResult;
use App\Services\Lesson\LessonGeneration\LessonGenerationOrchestrator;
use App\Traits\HasSaveResultMapping;
use Random\RandomException;

class LessonService
{
    use HasSaveResultMapping;

    public function __construct(protected LessonGenerationOrchestrator $lessonGenerationOrchestrator)
    {
    }

    public function show(LessonShowDto $dto): Lesson
    {
        return Lesson::where('user_id', $dto->userId)
            ->where('language', $dto->language)
            ->where('number', $dto->lessonNumber)
            ->firstOrFail();
    }

    /**
     * @throws RandomException
     */
    public function generate(LessonGenerateDto $dto): void
    {
        $this->lessonGenerationOrchestrator->generate(
            $dto->userId,
            $dto->language,
            $dto->lessonCount,
        );
    }

    public function saveResult(LessonSaveResultDto $dto): LessonResult
    {
        return LessonResult::create(static::mapSaveResult($dto, ['lesson_id' => $dto->lessonId]));
    }
}
