<?php

namespace Tests\Providers;

use App\Enums\Genre;

class TestDataProvider
{
    public static function provideSupportedGenres(): array
    {
        $genres = Genre::supportedValues();

        return array_combine($genres, array_map(fn ($genre) => [$genre], $genres));
    }
}
