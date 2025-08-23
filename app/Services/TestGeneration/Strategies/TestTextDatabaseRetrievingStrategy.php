<?php

namespace App\Services\TestGeneration\Strategies;

use App\Models\TestText;
use Illuminate\Database\Eloquent\Builder;

class TestTextDatabaseRetrievingStrategy
{
    public function getText(string $language, int $userId, ?string $genre): ?string
    {
        $testText = TestText::where('language', $language)
            ->when($genre, function (Builder $query, string $genre) {
                $query->where('genre', $genre);
            })
            ->inRandomOrder()
            ->first();

        return $testText ? $testText->text : null;
    }
}
