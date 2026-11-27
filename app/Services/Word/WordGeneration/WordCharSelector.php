<?php

namespace App\Services\Word\WordGeneration;

use App\Helpers\RandomHelper;

class WordCharSelector
{
    public function select(array $availableChars, array $newChars): string
    {
        $useNewChar = !empty($newChars) && RandomHelper::rollChance(WordCharDataProvider::NEW_CHAR_CHANCE);

        return $useNewChar
            ? $newChars[array_rand($newChars)]
            : $availableChars[array_rand($availableChars)];
    }
}
