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
            $key = Genre::getDataKeyForValue($genre);
            $result[$key] = [$genre];
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
                $key = $language . '_' . Genre::getDataKeyForValue($genre);
                $result[$key] = [[
                    'language' => $language,
                    'genre' => $genre,
                ]];
            }
        }

        return $result;
    }
}
