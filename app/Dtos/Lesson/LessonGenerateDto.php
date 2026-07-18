<?php

namespace App\Dtos\Lesson;

use App\Dtos\BaseDto;

class LessonGenerateDto extends BaseDto
{
    public function __construct(
        public readonly int $userId,
        public readonly string $language,
        public readonly int $lessonCount,
    ) {
    }
}
