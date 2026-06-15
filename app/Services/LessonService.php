<?php

namespace App\Services;

use App\Dtos\LessonSaveResultDto;
use App\Models\LessonResult;
use App\Services\LessonGeneration\LessonGenerationOrchestrator;
use Random\RandomException;

class LessonService
{
    public function __construct(protected LessonGenerationOrchestrator $lessonGenerationOrchestrator)
    {
    }

    /**
     * @throws RandomException
     */
    public function generateLessons(string $language, int $lessonCount, int $userId): void
    {
        $this->lessonGenerationOrchestrator->generate($language, $lessonCount, $userId);
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
