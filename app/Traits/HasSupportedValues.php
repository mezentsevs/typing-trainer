<?php

namespace App\Traits;

trait HasSupportedValues
{
    public static function supportedValues(): array
    {
        $cases = static::cases();
        $excluded = static::excludedValues();

        return array_values(
            array_filter(
                array_map(fn ($case) => $case->value, $cases),
                fn ($value) => !in_array($value, $excluded, true),
            ),
        );
    }

    protected static function excludedValues(): array
    {
        return [];
    }
}
