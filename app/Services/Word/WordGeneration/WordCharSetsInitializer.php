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
        $availableAlphanumerics = array_filter($availableChars, [CharHelper::class, 'isAlphanumeric']);
        $newAlphanumerics = array_filter($newChars, [CharHelper::class, 'isAlphanumeric']);

        $allVowels = $this->wordCharDataProvider->getVowels($language);
        $availableVowels = array_intersect($allVowels, $availableAlphanumerics);
        $newVowels = array_intersect($allVowels, $newAlphanumerics);

        $allConsonants = $this->wordCharDataProvider->getConsonants($language);
        $availableConsonants = array_intersect($allConsonants, $availableAlphanumerics);
        $newConsonants = array_intersect($allConsonants, $newAlphanumerics);

        $availableNumbers = array_filter($availableAlphanumerics, [CharHelper::class, 'isNumeric']);
        $newNumbers = array_filter($newAlphanumerics, [CharHelper::class, 'isNumeric']);

        return [
            'availableAlphanumerics' => $availableAlphanumerics,
            'newAlphanumerics' => $newAlphanumerics,
            'availableVowels' => $availableVowels,
            'newVowels' => $newVowels,
            'availableConsonants' => $availableConsonants,
            'newConsonants' => $newConsonants,
            'availableNumbers' => $availableNumbers,
            'newNumbers' => $newNumbers,
        ];
    }
}
