<?php

namespace App\Services\Word\WordGeneration;

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
            $isStart = $i % 2 === 0;

            $currentCharSet = $isStart ? $letterAlternationSets['startCharSet'] : $letterAlternationSets['endCharSet'];
            $currentNewCharSet = $isStart ? $letterAlternationSets['startNewCharSet'] : $letterAlternationSets['endNewCharSet'];

            if (empty($currentCharSet)) {
                $currentCharSet = $charSets['availableLetterChars'];
                $currentNewCharSet = $charSets['newLetterChars'];
            }

            $useNumber = !empty($charSets['availableNumberChars']) &&
                        random_int(
                            WordCharDataProvider::RANDOM_MIN_VALUE,
                            WordCharDataProvider::RANDOM_MAX_VALUE,
                        ) < WordCharDataProvider::DIGIT_USAGE_CHANCE;

            if ($useNumber) {
                $lettersPart .= $this->wordCharProbabilitySelector->selectChar(
                    $charSets['availableNumberChars'],
                    $charSets['newNumberChars'],
                );
            } else {
                $lettersPart .= $this->wordCharProbabilitySelector->selectChar(
                    $currentCharSet,
                    $currentNewCharSet,
                );
            }
        }

        return $lettersPart;
    }

    /**
     * @throws RandomException
     */
    protected function getLetterAlternationSets(array $charSets): array
    {
        $startCharSet = [];
        $startNewCharSet = [];
        $endCharSet = [];
        $endNewCharSet = [];

        $hasVowelChars = !empty($charSets['availableVowelChars']);
        $hasConsonantChars = !empty($charSets['availableConsonantChars']);

        switch (true) {
            case $hasVowelChars && $hasConsonantChars:
                $isVowelFirst = random_int(
                    WordCharDataProvider::BINARY_CHOICE_MIN,
                    WordCharDataProvider::BINARY_CHOICE_MAX,
                ) === WordCharDataProvider::BINARY_CHOICE_DEFAULT;

                $startCharSet = $isVowelFirst ? $charSets['availableVowelChars'] : $charSets['availableConsonantChars'];
                $startNewCharSet = $isVowelFirst ? $charSets['newVowelChars'] : $charSets['newConsonantChars'];
                $endCharSet = $isVowelFirst ? $charSets['availableConsonantChars'] : $charSets['availableVowelChars'];
                $endNewCharSet = $isVowelFirst ? $charSets['newConsonantChars'] : $charSets['newVowelChars'];
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
            'endCharSet' => $endCharSet,
            'endNewCharSet' => $endNewCharSet,
        ];
    }
}
