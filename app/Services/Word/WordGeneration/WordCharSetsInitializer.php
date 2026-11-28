<?php

namespace App\Services\Word\WordGeneration;

class WordCharSetsInitializer
{
    public function __construct(private WordCharDataProvider $wordCharDataProvider)
    {
    }

    public function initialize(string $language, array $availableChars, array $newChars): array
    {
        $availableLetters = array_filter($availableChars, function ($char) {
            return preg_match('/[\p{L}\p{N}]/u', $char);
        });

        $newLetters = array_filter($newChars, function ($char) {
            return preg_match('/[\p{L}\p{N}]/u', $char);
        });

        $allVowels = $this->wordCharDataProvider->getVowels($language);
        $availableVowels = array_intersect($allVowels, $availableLetters);
        $newVowels = array_intersect($allVowels, $newLetters);

        $allConsonants = $this->wordCharDataProvider->getConsonants($language);
        $availableConsonants = array_intersect($allConsonants, $availableLetters);
        $newConsonants = array_intersect($allConsonants, $newLetters);

        $availableNumbers = array_filter($availableLetters, function ($char) {
            return preg_match('/\p{N}/u', $char);
        });

        $newNumbers = array_filter($newLetters, function ($char) {
            return preg_match('/\p{N}/u', $char);
        });

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
