<?php

namespace App\Enums;

use App\Traits\HasSupportedValues;

enum Language: string
{
    use HasSupportedValues;

    case En = 'en';
    case Ru = 'ru';
    case Unknown = 'unknown';

    protected static function excludedValues(): array
    {
        return [self::Unknown->value];
    }
}
