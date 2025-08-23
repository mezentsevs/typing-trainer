<?php

namespace App\Services\TestGeneration\Strategies;

use App\Models\TestText;
use App\Services\TestGeneration\Strategies\Contracts\TestTextSupplyingStrategy;
use Illuminate\Database\Eloquent\Builder;

class TestTextRetrievingFromDatabaseStrategy implements TestTextSupplyingStrategy
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
