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
            $key = self::getGenreKey($genre);
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
                $key = "{$language}_" . self::getGenreKey($genre);
                $result[$key] = [[
                    'language' => $language,
                    'genre' => $genre,
                ]];
            }
        }

        return $result;
    }

    private static function getGenreKey(string $genre): string
    {
        return $genre === Genre::None->value ? strtolower(Genre::None->name) : $genre;
    }
}
