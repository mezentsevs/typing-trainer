<?php

namespace Tests\Unit\Services\Providers;

use App\Enums\Language;

class CommonDataProvider
{
    public static function provideSupportedLanguages(): array
    {
        return [
            Language::En->value => [Language::En->value],
            Language::Ru->value => [Language::Ru->value],
        ];
    }
}
