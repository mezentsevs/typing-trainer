<?php

namespace App\Services\WordGeneration;

use Random\RandomException;

class WordLettersPartGenerator
{
    public function __construct(
        protected WordCharProbabilitySelector $wordCharProbabilitySelector,
        protected WordCharDataProvider $wordCharDataProvider,
    ) {
    }

    /**
     * @throws RandomException
     */
    public function generate(array $charSets, int $lettersPartLength): string
    {
        $letterAlternationSets = $this->getLetterAlternationSets($charSets);
        $lettersPart = '';

        for ($i = 0; $i < $lettersPartLength; $i++) {
            $currentCharSet = ($i % 2 === 0) ? $letterAlternationSets['startCharSet'] : $letterAlternationSets['otherCharSet'];
            $currentNewCharSet = ($i % 2 === 0) ? $letterAlternationSets['startNewCharSet'] : $letterAlternationSets['otherNewCharSet'];

            if (empty($currentCharSet)) {
                $currentCharSet = $charSets['availableLetterChars'];
                $currentNewCharSet = $charSets['newLetterChars'];
            }

            $useNumber = !empty($charSets['availableNumberChars']) &&
                        rand(
                            WordCharDataProvider::RANDOM_MIN_VALUE,
                            WordCharDataProvider::RANDOM_MAX_VALUE,
                        ) < WordCharDataProvider::DIGIT_USAGE_CHANCE;

            if ($useNumber) {
                $lettersPart .= $this->wordCharProbabilitySelector->selectNumberChar(
                    $charSets['availableNumberChars'],
                    $charSets['newNumberChars'],
                );
            } else {
                $lettersPart .= $this->wordCharProbabilitySelector->selectLetterChar(
                    $currentCharSet,
                    $currentNewCharSet,
                );
            }
        }

        return $lettersPart;
    }

    protected function getLetterAlternationSets(array $charSets): array
    {
        $startCharSet = [];
        $startNewCharSet = [];
        $otherCharSet = [];
        $otherNewCharSet = [];

        $hasVowelChars = !empty($charSets['availableVowelChars']);
        $hasConsonantChars = !empty($charSets['availableConsonantChars']);

        switch (true) {
            case $hasVowelChars && $hasConsonantChars:
                $startType = rand(
                    WordCharDataProvider::BINARY_CHOICE_MIN,
                    WordCharDataProvider::BINARY_CHOICE_MAX,
                ) === WordCharDataProvider::BINARY_CHOICE_DEFAULT
                    ? WordCharDataProvider::CHAR_TYPE_VOWEL
                    : WordCharDataProvider::CHAR_TYPE_CONSONANT;

                $startCharSet = $startType === WordCharDataProvider::CHAR_TYPE_VOWEL
                    ? $charSets['availableVowelChars']
                    : $charSets['availableConsonantChars'];

                $startNewCharSet = $startType === WordCharDataProvider::CHAR_TYPE_VOWEL
                    ? $charSets['newVowelChars']
                    : $charSets['newConsonantChars'];

                $otherCharSet = $startType === WordCharDataProvider::CHAR_TYPE_VOWEL
                    ? $charSets['availableConsonantChars']
                    : $charSets['availableVowelChars'];

                $otherNewCharSet = $startType === WordCharDataProvider::CHAR_TYPE_VOWEL
                    ? $charSets['newConsonantChars']
                    : $charSets['newVowelChars'];
                break;

            case $hasVowelChars:
                $startCharSet = $charSets['availableVowelChars'];
                $startNewCharSet = $charSets['newVowelChars'];
                break;

            case $hasConsonantChars:
                $startCharSet = $charSets['availableConsonantChars'];
                $startNewCharSet = $charSets['newConsonantChars'];
                break;

            default:
                break;
        }

        return [
            'startCharSet' => $startCharSet,
            'startNewCharSet' => $startNewCharSet,
            'otherCharSet' => $otherCharSet,
            'otherNewCharSet' => $otherNewCharSet,
        ];
    }
}
