<?php

namespace App\Traits;

use App\Dtos\BaseSaveResultDto;

trait HasSaveResultDtoMapping
{
    public static function mapSaveResultDtoToAttributes(BaseSaveResultDto $dto, array $additional = []): array
    {
        return array_merge([
            'user_id' => $dto->userId,
            'language' => $dto->language,
            'time_seconds' => $dto->timeSeconds,
            'speed_wpm' => $dto->speedWpm,
            'errors' => $dto->errors,
            'success' => $dto->success,
        ], $additional);
    }
}
