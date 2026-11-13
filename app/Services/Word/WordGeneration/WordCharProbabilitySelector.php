<?php

namespace App\Services\Word\WordGeneration;

use Random\RandomException;

class WordCharProbabilitySelector
{
    /**
     * @throws RandomException
     */
    public function selectChar(array $availableChars, array $newChars): string
    {
        if (!empty($newChars) &&
            random_int(
                WordCharDataProvider::RANDOM_MIN_VALUE,
                WordCharDataProvider::RANDOM_MAX_VALUE,
            ) < WordCharDataProvider::NEW_CHAR_USAGE_CHANCE) {
            return $newChars[array_rand($newChars)];
        }

        return $availableChars[array_rand($availableChars)];
    }
}
