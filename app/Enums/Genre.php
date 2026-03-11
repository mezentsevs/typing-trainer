<?php

namespace App\Enums;

use App\Traits\HasSupportedValues;

enum Genre: string
{
    use HasSupportedValues;

    case None = '';
    case Fiction = 'fiction';
    case NonFiction = 'non-fiction';
    case Poetry = 'poetry';
    case Unknown = 'unknown';

    protected static function excludedValues(): array
    {
        return [self::Unknown->value];
    }

    public static function getDataKeyForValue(string $value): string
    {
        $case = self::tryFrom($value);

        return $case === self::None ? strtolower(self::None->name) : $case->value;
    }
}
