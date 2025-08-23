<?php

namespace App\Services\WordGeneration;

class WordCharSetsInitializer
{
    public function __construct(protected WordCharDataProvider $wordCharDataProvider)
    {
    }

    public function initialize(string $language, array $availableChars, array $newChars): array
    {
        $availableLetterChars = array_filter($availableChars, function ($char) {
            return preg_match('/[a-zA-ZА-яёЁ0-9]/u', $char);
        });

        $newLetterChars = array_filter($newChars, function ($char) {
            return preg_match('/[a-zA-ZА-яёЁ0-9]/u', $char);
        });

        $allVowelChars = $this->wordCharDataProvider->getVowels($language);
        $availableVowelChars = array_intersect($allVowelChars, $availableLetterChars);
        $newVowelChars = array_intersect($allVowelChars, $newLetterChars);

        $allConsonantChars = $this->wordCharDataProvider->getConsonants($language);
        $availableConsonantChars = array_intersect($allConsonantChars, $availableLetterChars);
        $newConsonantChars = array_intersect($allConsonantChars, $newLetterChars);

        $availableNumberChars = array_filter($availableLetterChars, function ($char) {
            return preg_match('/[0-9]/u', $char);
        });

        $newNumberChars = array_filter($newLetterChars, function ($char) {
            return preg_match('/[0-9]/u', $char);
        });

        return [
            'availableVowelChars' => $availableVowelChars,
            'newVowelChars' => $newVowelChars,
            'availableConsonantChars' => $availableConsonantChars,
            'newConsonantChars' => $newConsonantChars,
            'availableNumberChars' => $availableNumberChars,
            'newNumberChars' => $newNumberChars,
            'availableLetterChars' => $availableLetterChars,
            'newLetterChars' => $newLetterChars,
        ];
    }
}
