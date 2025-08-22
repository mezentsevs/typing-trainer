<?php

namespace App\Services\WordGeneration;

use Random\RandomException;

class WordGenerationOrchestrator
{
    public function __construct(
        protected WordCharSetsInitializer $wordCharSetsInitializer,
        protected WordLettersPartGenerator $wordLettersPartGenerator,
        protected WordSpecialCharsAppender $wordSpecialCharsAppender,
    ) {
    }

    /**
     * @throws RandomException
     */
    public function generate(array $availableChars, array $newChars, string $language): string
    {
        $charSets = $this->wordCharSetsInitializer->initialize($availableChars, $newChars, $language);

        if (empty($charSets['availableVowelChars']) && empty($charSets['availableConsonantChars'])) {
            return '';
        }

        $lettersPartLength = random_int(
            WordCharDataProvider::MIN_LETTERS_PART_LENGTH,
            WordCharDataProvider::MAX_LETTERS_PART_LENGTH,
        );

        $lettersPart = $this->wordLettersPartGenerator->generate($charSets, $lettersPartLength);

        return $this->wordSpecialCharsAppender->addSpecialChars($lettersPart, $availableChars, $language);
    }
}
