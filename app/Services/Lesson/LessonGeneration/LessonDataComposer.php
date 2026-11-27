<?php

namespace App\Services\Lesson\LessonGeneration;

use App\Services\Lesson\LessonGeneration\ValueObjects\LessonBlueprint;

class LessonDataComposer
{
    public function __construct(private LessonTextGenerator $lessonTextGenerator)
    {
    }

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
