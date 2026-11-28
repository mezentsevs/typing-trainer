<?php

namespace App\Services\Word\WordGeneration;

use App\Helpers\CharHelper;

class WordCharSetsInitializer
{
    public function __construct(private WordCharDataProvider $wordCharDataProvider)
    {
    }

    public function initialize(string $language, array $availableChars, array $newChars): array
    {
        $availableLetters = array_filter($availableChars, [CharHelper::class, 'isAlphanumeric']);
        $newLetters = array_filter($newChars, [CharHelper::class, 'isAlphanumeric']);

        $allVowels = $this->wordCharDataProvider->getVowels($language);
        $availableVowels = array_intersect($allVowels, $availableLetters);
        $newVowels = array_intersect($allVowels, $newLetters);

        $allConsonants = $this->wordCharDataProvider->getConsonants($language);
        $availableConsonants = array_intersect($allConsonants, $availableLetters);
        $newConsonants = array_intersect($allConsonants, $newLetters);

        $availableNumbers = array_filter($availableLetters, [CharHelper::class, 'isNumeric']);
        $newNumbers = array_filter($newLetters, [CharHelper::class, 'isNumeric']);

        return [
            'availableVowels' => $availableVowels,
            'newVowels' => $newVowels,
            'availableConsonants' => $availableConsonants,
            'newConsonants' => $newConsonants,
            'availableNumbers' => $availableNumbers,
            'newNumbers' => $newNumbers,
            'availableLetters' => $availableLetters,
            'newLetters' => $newLetters,
        ];
    }
}
