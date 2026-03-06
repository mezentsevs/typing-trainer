<?php

namespace Tests\Providers;

use App\Enums\Genre;

class TestDataProvider
{
    public static function provideSupportedGenres(): array
    {
        $genres = array_values(
            array_filter(
                array_map(fn ($case) => $case->value, Genre::cases()),
                fn ($v) => $v !== Genre::Unknown->value,
            ),
        );

        return array_combine($genres, array_map(fn ($genre) => [$genre], $genres));
    }
}
