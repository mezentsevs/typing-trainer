<?php

namespace Tests\Providers;

use App\Enums\Genre;
use App\Enums\Language;

class TestDataProvider
{
    public static function provideSupportedGenres(): array
    {
        $genres = Genre::supportedValues();
        $result = [];

        foreach ($genres as $genre) {
            $result[$genre] = [$genre];
        }

        return $result;
    }

    public static function provideTestTextRequestData(): array
    {
        $languages = Language::supportedValues();
        $genres = Genre::supportedValues();
        $result = [];

        foreach ($languages as $language) {
            foreach ($genres as $genre) {
                $keySuffix = $genre === '' ? 'none' : $genre;
                $key = "{$language}_{$keySuffix}";
                $result[$key] = [[
                    'language' => $language,
                    'genre' => $genre,
                ]];
            }
        }

        return $result;
    }
}
