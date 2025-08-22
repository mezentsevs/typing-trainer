<?php

namespace App\Services\LessonGeneration\ValueObjects;

class LessonBlueprint
{
    public function __construct(
        public readonly string $language,
        public readonly int $lessonNumber,
        public readonly int $totalLessons,
        public readonly string $availableChars,
        public readonly string $newChars,
        public readonly int $length,
    ) {
    }
}
