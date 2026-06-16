<?php

namespace App\Dtos;

abstract class BaseSaveResultDto extends BaseDto
{
    public function __construct(
        public readonly int $userId,
        public readonly string $language,
        public readonly int $timeSeconds,
        public readonly int $speedWpm,
        public readonly int $errors,
    ) {
    }
}
