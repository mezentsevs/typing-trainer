<?php

namespace App\Traits;

trait HasSupportedValues
{
    public static function supportedValues(): array
    {
        $cases = static::cases();
        $excluded = static::excludedCaseValues();

        return array_values(
            array_filter(
                array_map(fn ($case) => $case->value, $cases),
                fn ($value) => !in_array($value, $excluded, true),
            ),
        );
    }

    protected static function excludedCaseValues(): array
    {
        return [];
    }
}
