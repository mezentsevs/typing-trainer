<?php

namespace App\Services\WordGeneration;

class WordCharProbabilitySelector
{
    public function selectNumberChar(array $availableNumberChars, array $newNumberChars): string
    {
        if (!empty($newNumberChars) &&
            rand(
                WordCharDataProvider::RANDOM_MIN_VALUE,
                WordCharDataProvider::RANDOM_MAX_VALUE,
            ) < WordCharDataProvider::NEW_CHAR_USAGE_CHANCE) {
            return $newNumberChars[array_rand($newNumberChars)];
        }

        return $availableNumberChars[array_rand($availableNumberChars)];
    }

    public function selectLetterChar(array $currentCharSet, array $currentNewCharSet): string
    {
        if (!empty($currentNewCharSet) &&
            rand(
                WordCharDataProvider::RANDOM_MIN_VALUE,
                WordCharDataProvider::RANDOM_MAX_VALUE,
            ) < WordCharDataProvider::NEW_CHAR_USAGE_CHANCE) {
            return $currentNewCharSet[array_rand($currentNewCharSet)];
        }

        return $currentCharSet[array_rand($currentCharSet)];
    }
}
