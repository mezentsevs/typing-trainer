<?php

namespace App\Services;

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
}
