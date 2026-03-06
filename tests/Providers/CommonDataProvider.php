<?php

namespace Tests\Providers;

use App\Enums\Language;

class CommonDataProvider
{
    public static function provideSupportedLanguages(): array
    {
        $languages = array_values(
            array_filter(
                array_map(fn ($case) => $case->value, Language::cases()),
                fn ($v) => $v !== Language::Unknown->value,
            ),
        );

        return array_combine($languages, array_map(fn ($language) => [$language], $languages));
    }
}
