<?php

namespace App\Dtos\Lesson;

use App\Dtos\BaseSaveResultDto;

class LessonSaveResultDto extends BaseSaveResultDto
{
    public function __construct(
        int $userId,
        public readonly int $lessonId,
        string $language,
        int $timeSeconds,
        int $speedWpm,
        int $errors,
        bool $success,
    ) {
        parent::__construct($userId, $language, $timeSeconds, $speedWpm, $errors, $success);
    }
}
