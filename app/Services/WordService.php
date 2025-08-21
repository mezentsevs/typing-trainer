<?php

namespace App\Services;

use Random\RandomException;

class WordService
{
    protected const array LETTERS_LC_RU = ['а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'];
    protected const array LETTERS_UC_RU = ['А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'];
    protected const array VOWELS_EN = ['a', 'e', 'i', 'o', 'u', 'y', 'A', 'E', 'I', 'O', 'U', 'Y'];
    protected const array VOWELS_RU = ['а', 'е', 'ё', 'и', 'о', 'у', 'ы', 'э', 'ю', 'я', 'А', 'Е', 'Ё', 'И', 'О', 'У', 'Ы', 'Э', 'Ю', 'Я'];
    protected const array SPECIALS_EN = ['!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '-', '_', '=', '+', '[', ']', '{', '}', '|', '/', '\\', ':', '"', '\'', '<', '>', '?', '~', '`', ',', '.', ';'];
    protected const array SPECIALS_RU = ['!', '"', '№', ';', '%', ':', '?', '*', '(', ')', '-', '_', '=', '+', '/', '\\', ',', '.'];
    protected const array PAIRED = ['(' => ')', '[' => ']', '{' => '}', '<' => '>', '"' => '"', "'" => "'", '`' => '`'];
    protected const array PUNCTUATION = [',', '.', ';', ':', '!', '?'];

    protected const int MIN_LETTERS_PART_LENGTH = 3;
    protected const int MAX_LETTERS_PART_LENGTH = 8;
    protected const int RANDOM_MIN_VALUE = 0;
    protected const int RANDOM_MAX_VALUE = 99;
    protected const int DIGIT_USAGE_CHANCE = 30;
    protected const int NEW_CHAR_USAGE_CHANCE = 70;
    protected const int BINARY_CHOICE_MIN = 0;
    protected const int BINARY_CHOICE_MAX = 1;
    protected const int BINARY_CHOICE_DEFAULT = 0;
    protected const string CHAR_TYPE_VOWEL = 'V';
    protected const string CHAR_TYPE_CONSONANT = 'C';

    /**
     * @throws RandomException
     */
    public function generateWord(array $availableChars, array $newChars, string $language): string
    {
        $charSets = $this->initializeCharSets($availableChars, $newChars, $language);

        if (empty($charSets['availableVowelChars']) && empty($charSets['availableConsonantChars'])) {
            return '';
        }

        $lettersPartLength = random_int(self::MIN_LETTERS_PART_LENGTH, self::MAX_LETTERS_PART_LENGTH);
        $lettersPart = $this->buildLettersPart($charSets, $lettersPartLength);

        return $this->addSpecialChars($lettersPart, $availableChars, $language);
    }

    private function initializeCharSets(array $availableChars, array $newChars, string $language): array
    {
        $availableLetterChars = array_filter($availableChars, function ($char) {
            return preg_match('/[a-zA-ZА-яёЁ0-9]/u', $char);
        });

        $newLetterChars = array_filter($newChars, function ($char) {
            return preg_match('/[a-zA-ZА-яёЁ0-9]/u', $char);
        });

        $allVowelChars = $this->getVowels($language);
        $availableVowelChars = array_intersect($allVowelChars, $availableLetterChars);
        $newVowelChars = array_intersect($allVowelChars, $newLetterChars);

        $allConsonantChars = $this->getConsonants($language);
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

    private function buildLettersPart(array $charSets, int $lettersPartLength): string
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
                        rand(self::RANDOM_MIN_VALUE, self::RANDOM_MAX_VALUE) < self::DIGIT_USAGE_CHANCE;

            if ($useNumber) {
                $lettersPart .= $this->selectNumberChar($charSets['availableNumberChars'], $charSets['newNumberChars']);
            } else {
                $lettersPart .= $this->selectLetterChar($currentCharSet, $currentNewCharSet);
            }
        }

        return $lettersPart;
    }

    private function getLetterAlternationSets(array $charSets): array
    {
        $startCharSet = [];
        $startNewCharSet = [];
        $otherCharSet = [];
        $otherNewCharSet = [];

        $hasVowelChars = !empty($charSets['availableVowelChars']);
        $hasConsonantChars = !empty($charSets['availableConsonantChars']);

        switch (true) {
            case $hasVowelChars && $hasConsonantChars:
                $startType = rand(self::BINARY_CHOICE_MIN, self::BINARY_CHOICE_MAX) === self::BINARY_CHOICE_DEFAULT ? self::CHAR_TYPE_VOWEL : self::CHAR_TYPE_CONSONANT;
                $startCharSet = $startType === self::CHAR_TYPE_VOWEL ? $charSets['availableVowelChars'] : $charSets['availableConsonantChars'];
                $startNewCharSet = $startType === self::CHAR_TYPE_VOWEL ? $charSets['newVowelChars'] : $charSets['newConsonantChars'];
                $otherCharSet = $startType === self::CHAR_TYPE_VOWEL ? $charSets['availableConsonantChars'] : $charSets['availableVowelChars'];
                $otherNewCharSet = $startType === self::CHAR_TYPE_VOWEL ? $charSets['newConsonantChars'] : $charSets['newVowelChars'];
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

    private function selectNumberChar(array $availableNumberChars, array $newNumberChars): string
    {
        if (!empty($newNumberChars) &&
            rand(self::RANDOM_MIN_VALUE, self::RANDOM_MAX_VALUE) < self::NEW_CHAR_USAGE_CHANCE) {
            return $newNumberChars[array_rand($newNumberChars)];
        }

        return $availableNumberChars[array_rand($availableNumberChars)];
    }

    private function selectLetterChar(array $currentCharSet, array $currentNewCharSet): string
    {
        if (!empty($currentNewCharSet) &&
            rand(self::RANDOM_MIN_VALUE, self::RANDOM_MAX_VALUE) < self::NEW_CHAR_USAGE_CHANCE) {
            return $currentNewCharSet[array_rand($currentNewCharSet)];
        }

        return $currentCharSet[array_rand($currentCharSet)];
    }

    private function addSpecialChars(string $lettersPart, array $availableChars, string $language): string
    {
        if (empty($lettersPart)) {
            return '';
        }

        $availableSpecialChars = $this->filterSpecialChars($availableChars, $language);
        $specialCharType = $this->determineSpecialCharType($availableSpecialChars);

        if ($specialCharType === 'none') {
            return $lettersPart;
        }

        if ($specialCharType === 'single') {
            return $this->addSingleSpecialChar($lettersPart, $availableSpecialChars);
        }

        return $this->addPairedSpecialChars($lettersPart, $availableSpecialChars);
    }

    private function filterSpecialChars(array $availableChars, string $language): array
    {
        $allowedSpecialChars = match ($language) {
            'en' => self::SPECIALS_EN,
            'ru' => self::SPECIALS_RU,
            default => [],
        };

        return array_filter($availableChars, function ($char) use ($allowedSpecialChars) {
            return in_array($char, $allowedSpecialChars, true);
        });
    }

    private function determineSpecialCharType(array $availableSpecialChars): string
    {
        $singleSpecialChars = $this->getSingleSpecialChars($availableSpecialChars);
        $availableOpeningPairedChars = $this->getAvailableOpeningPairedChars($availableSpecialChars);

        $totalOptions = ['none'];

        if (!empty($singleSpecialChars)) {
            $totalOptions[] = 'single';
        }

        if (!empty($availableOpeningPairedChars)) {
            $totalOptions[] = 'paired';
        }

        return $totalOptions[array_rand($totalOptions)];
    }

    private function getSingleSpecialChars(array $availableSpecialChars): array
    {
        $pairedSymbolChars = array_merge(array_keys(self::PAIRED), array_values(self::PAIRED));
        return array_diff($availableSpecialChars, $pairedSymbolChars);
    }

    private function getAvailableOpeningPairedChars(array $availableSpecialChars): array
    {
        $availableOpeningPairedChars = array_intersect(array_keys(self::PAIRED), $availableSpecialChars);

        return array_filter($availableOpeningPairedChars, function ($openingChar) use ($availableSpecialChars) {
            return in_array(self::PAIRED[$openingChar], $availableSpecialChars, true);
        });
    }

    private function addSingleSpecialChar(string $lettersPart, array $availableSpecialChars): string
    {
        $singleSpecialChars = $this->getSingleSpecialChars($availableSpecialChars);
        $specialChar = $singleSpecialChars[array_rand($singleSpecialChars)];

        if ($this->isPunctuation($specialChar)) {
            return $lettersPart . $specialChar;
        }

        $position = rand(self::BINARY_CHOICE_MIN, self::BINARY_CHOICE_MAX) === self::BINARY_CHOICE_DEFAULT ? 'start' : 'end';

        return $position === 'start' ? $specialChar . $lettersPart : $lettersPart . $specialChar;
    }

    private function addPairedSpecialChars(string $lettersPart, array $availableSpecialChars): string
    {
        $availableOpeningPairedChars = $this->getAvailableOpeningPairedChars($availableSpecialChars);
        $openingChar = $availableOpeningPairedChars[array_rand($availableOpeningPairedChars)];
        $closingChar = self::PAIRED[$openingChar];

        return $openingChar . $lettersPart . $closingChar;
    }

    private function getAllEnglishLetters(): array
    {
        return array_merge(range('a', 'z'), range('A', 'Z'));
    }

    private function getAllRussianLetters(): array
    {
        return array_merge(self::LETTERS_LC_RU, self::LETTERS_UC_RU);
    }

    private function getVowels(string $language): array
    {
        return match ($language) {
            'en' => self::VOWELS_EN,
            'ru' => self::VOWELS_RU,
            default => [],
        };
    }

    private function getConsonants(string $language): array
    {
        return match ($language) {
            'en' => array_diff($this->getAllEnglishLetters(), $this->getVowels('en')),
            'ru' => array_diff($this->getAllRussianLetters(), $this->getVowels('ru')),
            default => [],
        };
    }

    private function isPunctuation(string $char): bool
    {
        return in_array($char, self::PUNCTUATION, true);
    }
}
