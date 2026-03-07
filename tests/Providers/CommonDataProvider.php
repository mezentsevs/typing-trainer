<?php

namespace Tests\Providers;

use App\Enums\Language;

class CommonDataProvider
{
    public static function provideSupportedLanguages(): array
    {
        $languages = Language::supportedValues();

        return array_combine($languages, array_map(fn ($language) => [$language], $languages));
    }
}
