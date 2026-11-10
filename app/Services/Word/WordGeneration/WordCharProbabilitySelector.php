<?php

namespace App\Services\Word\WordGeneration;

class WordCharProbabilitySelector
{
    public function selectChar(array $availableChars, array $newChars): string
    {
        if (!empty($newChars) &&
            rand(
                WordCharDataProvider::RANDOM_MIN_VALUE,
                WordCharDataProvider::RANDOM_MAX_VALUE,
            ) < WordCharDataProvider::NEW_CHAR_USAGE_CHANCE) {
            return $newChars[array_rand($newChars)];
        }

        return $availableChars[array_rand($availableChars)];
    }
}
