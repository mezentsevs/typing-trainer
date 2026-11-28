<?php

namespace App\Services\Word\WordGeneration;

use App\Helpers\RandomHelper;

class WordGenerationOrchestrator
{
    public function __construct(
        private WordCharSetsInitializer $wordCharSetsInitializer,
        private WordLettersPartGenerator $wordLettersPartGenerator,
        private WordSpecialCharsAppender $wordSpecialCharsAppender,
    ) {
    }

    public function generate(string $language, array $availableChars, array $newChars): string
    {
        $charSets = $this->wordCharSetsInitializer->initialize($language, $availableChars, $newChars);

        if (empty($charSets['availableVowels']) && empty($charSets['availableConsonants'])) {
            return '';
        }

        $lettersPartLength = RandomHelper::rollRange(
            WordCharDataProvider::MIN_LETTERS_PART_LENGTH,
            WordCharDataProvider::MAX_LETTERS_PART_LENGTH,
        );

        $lettersPart = $this->wordLettersPartGenerator->generate($charSets, $lettersPartLength);

        return $this->wordSpecialCharsAppender->addSpecialChars($lettersPart, $availableChars, $language);
    }
}
