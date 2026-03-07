<?php

namespace App\Traits;

trait HasSupportedValues
{
    public static function supportedValues(): array
    {
        $result = [];

        foreach (static::cases() as $case) {
            if (!in_array($case->value, static::excludedValues(), true)) {
                $result[] = $case->value;
            }
        }

        return $result;
    }

    protected static function excludedValues(): array
    {
        return [];
    }
}
