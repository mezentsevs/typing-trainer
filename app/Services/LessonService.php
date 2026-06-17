<?php

namespace App\Services;

use App\Dtos\LessonGenerateDto;
use App\Dtos\LessonSaveResultDto;
use App\Dtos\LessonShowDto;
use App\Models\Lesson;
use App\Models\LessonResult;
use App\Services\LessonGeneration\LessonGenerationOrchestrator;
use Random\RandomException;

class LessonService
{
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
        return LessonResult::create([
            'user_id' => $dto->userId,
            'lesson_id' => $dto->lessonId,
            'language' => $dto->language,
            'time_seconds' => $dto->timeSeconds,
            'speed_wpm' => $dto->speedWpm,
            'errors' => $dto->errors,
        ]);
    }
}
