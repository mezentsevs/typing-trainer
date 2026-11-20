<?php

namespace App\Traits;

use App\Dtos\BaseDto;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait HasDtoMapping
{
    public static function mapDtoToAttributes(BaseDto $dto): array
    {
        return Arr::mapWithKeys(get_object_vars($dto), fn ($value, $key) => [Str::snake($key) => $value]);
    }
}
