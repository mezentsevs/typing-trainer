<?php

namespace App\Services\LessonGeneration;

use App\Services\LessonGeneration\ValueObjects\LessonBlueprint;
use Random\RandomException;

class LessonDataComposer
{
    public function __construct(protected LessonTextGenerator $lessonTextGenerator)
    {
    }

    /**
     * @throws RandomException
     */
    public function compose(LessonBlueprint $blueprint, int $userId): array
    {
        return [
            'user_id' => $userId,
            'number' => $blueprint->lessonNumber,
            'total' => $blueprint->totalLessons,
            'language' => $blueprint->language,
            'new_chars' => $blueprint->newChars,
            'text' => $this->lessonTextGenerator->generate($blueprint),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
