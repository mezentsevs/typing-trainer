<?php

namespace App\Services;

use App\Services\LessonGeneration\LessonDataComposer;
use App\Services\LessonGeneration\LessonGenerationOrchestrator;
use App\Services\LessonGeneration\LessonSequenceGenerator;
use App\Services\LessonGeneration\LessonTextGenerator;
use Random\RandomException;

class LessonService
{
    public function __construct(protected WordService $wordService)
    {
    }

    /**
     * @throws RandomException
     */
    public function generateLessons(string $language, int $lessonCount, int $userId): void
    {
        $lessonGenerationOrchestrator = new LessonGenerationOrchestrator(
            new LessonSequenceGenerator(),
            new LessonDataComposer(new LessonTextGenerator($this->wordService)),
        );

        $lessonGenerationOrchestrator->generate($language, $lessonCount, $userId);
    }
}
