<?php

namespace App\Dtos;

class LessonGenerateDto extends BaseDto
{
    public function __construct(
        public readonly int $userId,
        public readonly string $language,
        public readonly int $lessonCount,
    ) {
    }
}
