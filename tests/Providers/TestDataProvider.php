<?php

namespace Tests\Providers;

use App\Enums\Genre;

class TestDataProvider
{
    public static function provideSupportedGenres(): array
    {
        $result = [];

        foreach (Genre::supportedValues() as $genre) {
            $result[$genre] = [$genre];
        }

        return $result;
    }
}
