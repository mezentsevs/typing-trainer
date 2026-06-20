<?php

namespace App\Services\TestGeneration\Strategies;

use App\Models\Test;
use App\Services\TestGeneration\Strategies\Contracts\TestRetrieveStrategy;
use Illuminate\Database\Eloquent\Builder;

class TestRetrieveDatabaseStrategy implements TestRetrieveStrategy
{
    public function retrieve(int $userId, string $language, ?string $genre): ?string
    {
        $test = Test::where('language', $language)
            ->when($genre, function (Builder $query, string $genre) {
                $query->where('genre', $genre);
            })
            ->inRandomOrder()
            ->first();

        return $test ? $test->text : null;
    }
}
