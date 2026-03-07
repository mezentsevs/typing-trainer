<?php

namespace Tests\Providers;

use App\Enums\Language;

class CommonDataProvider
{
    public static function provideSupportedLanguages(): array
    {
        $result = [];

        foreach (Language::supportedValues() as $language) {
            $result[$language] = [$language];
        }

        return $result;
    }
}
