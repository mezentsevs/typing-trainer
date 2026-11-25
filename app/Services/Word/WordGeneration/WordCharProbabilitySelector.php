<?php

namespace App\Services\Word\WordGeneration;

use App\Helpers\RandomHelper;

class WordCharProbabilitySelector
{
    public function selectChar(array $availableChars, array $newChars): string
    {
        $useNewChar = $newChars && RandomHelper::rollChance(WordCharDataProvider::NEW_CHAR_CHANCE);

        return $useNewChar
            ? $newChars[array_rand($newChars)]
            : $availableChars[array_rand($availableChars)];
    }
}
