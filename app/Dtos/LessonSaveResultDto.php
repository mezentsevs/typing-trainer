<?php

namespace App\Dtos;

class LessonSaveResultDto extends BaseSaveResultDto
{
    public readonly int $lessonId;

    public function __construct(
        int $userId,
        int $lessonId,
        string $language,
        int $timeSeconds,
        int $speedWpm,
        int $errors,
    ) {
        parent::__construct($userId, $language, $timeSeconds, $speedWpm, $errors);
        $this->lessonId = $lessonId;
    }
}
