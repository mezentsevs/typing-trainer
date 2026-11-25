<?php

namespace App\Services\Word\WordGeneration;

use App\Helpers\RandomHelper;

class WordLettersPartGenerator
{
    public function __construct(
        protected WordCharProbabilitySelector $wordCharProbabilitySelector,
        protected WordCharDataProvider $wordCharDataProvider,
    ) {
    }

    public function generate(array $charSets, int $lettersPartLength): string
    {
        $letterAlternationSets = $this->getLetterAlternationSets($charSets);
        $result = '';

        for ($i = 0; $i < $lettersPartLength; $i++) {
            $position = $i % 2 ? 'odd' : 'even';
            $availableChars = $letterAlternationSets[$position]['available'];
            $newChars = $letterAlternationSets[$position]['new'];

            if (empty($availableChars)) {
                $availableChars = $charSets['availableLetterChars'];
                $newChars = $charSets['newLetterChars'];
            }

            $useNumber = $charSets['availableNumberChars'] && RandomHelper::rollChance(WordCharDataProvider::NUMBER_CHANCE);

            $result .= $useNumber
                ? $this->wordCharProbabilitySelector->selectChar(
                    $charSets['availableNumberChars'],
                    $charSets['newNumberChars'],
                )
                : $this->wordCharProbabilitySelector->selectChar(
                    $availableChars,
                    $newChars,
                );
        }

        return $result;
    }

    private function getLetterAlternationSets(array $charSets): array
    {
        $evenAvailable = [];
        $evenNew = [];
        $oddAvailable = [];
        $oddNew = [];

        $hasVowelChars = !empty($charSets['availableVowelChars']);
        $hasConsonantChars = !empty($charSets['availableConsonantChars']);

        switch (true) {
            case $hasVowelChars && $hasConsonantChars:
                $isEvenVowel = RandomHelper::flipCoin();

                $types = ['Vowel', 'Consonant'];
                [$evenType, $oddType] = $isEvenVowel ? $types : array_reverse($types);

                $evenAvailable = $charSets["available{$evenType}Chars"];
                $evenNew = $charSets["new{$evenType}Chars"];
                $oddAvailable = $charSets["available{$oddType}Chars"];
                $oddNew = $charSets["new{$oddType}Chars"];
                break;

            case $hasVowelChars:
                $evenAvailable = $charSets['availableVowelChars'];
                $evenNew = $charSets['newVowelChars'];
                break;

            case $hasConsonantChars:
                $evenAvailable = $charSets['availableConsonantChars'];
                $evenNew = $charSets['newConsonantChars'];
                break;

            default:
                break;
        }

        return [
            'even' => [
                'available' => $evenAvailable,
                'new' => $evenNew,
            ],
            'odd' => [
                'available' => $oddAvailable,
                'new' => $oddNew,
            ],
        ];
    }
}
