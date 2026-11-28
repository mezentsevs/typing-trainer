<?php

namespace App\Services\Word\WordGeneration;

use App\Helpers\RandomHelper;

class WordLettersPartGenerator
{
    public function __construct(private WordCharSelector $wordCharSelector)
    {
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
                $availableChars = $charSets['availableLetters'];
                $newChars = $charSets['newLetters'];
            }

            $useNumber = !empty($charSets['availableNumbers']) && RandomHelper::rollChance(WordCharDataProvider::NUMBER_CHANCE);

            $result .= $useNumber
                ? $this->wordCharSelector->select(
                    $charSets['availableNumbers'],
                    $charSets['newNumbers'],
                )
                : $this->wordCharSelector->select(
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

        $hasVowels = !empty($charSets['availableVowels']);
        $hasConsonants = !empty($charSets['availableConsonants']);

        switch (true) {
            case $hasVowels && $hasConsonants:
                $isEvenVowel = RandomHelper::flipCoin();

                $types = ['Vowel', 'Consonant'];
                [$evenType, $oddType] = $isEvenVowel ? $types : array_reverse($types);

                $evenAvailable = $charSets["available{$evenType}s"];
                $evenNew = $charSets["new{$evenType}s"];
                $oddAvailable = $charSets["available{$oddType}s"];
                $oddNew = $charSets["new{$oddType}s"];
                break;

            case $hasVowels:
                $evenAvailable = $charSets['availableVowels'];
                $evenNew = $charSets['newVowels'];
                break;

            case $hasConsonants:
                $evenAvailable = $charSets['availableConsonants'];
                $evenNew = $charSets['newConsonants'];
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
