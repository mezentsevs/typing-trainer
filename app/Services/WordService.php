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

    /**
     * @throws RandomException
     */
    public function generateWord(array $availableChars, array $newChars, string $language): string
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

        $lettersPartLength = random_int(self::MIN_LETTERS_PART_LENGTH, self::MAX_LETTERS_PART_LENGTH);
        $lettersPart = '';

        if (!empty($availableVowelChars) && !empty($availableConsonantChars)) {
            $startType = rand(self::BINARY_CHOICE_MIN, self::BINARY_CHOICE_MAX) === self::BINARY_CHOICE_DEFAULT ? 'V' : 'C';
            $startCharSet = $startType === 'V' ? $availableVowelChars : $availableConsonantChars;
            $startNewCharSet = $startType === 'V' ? $newVowelChars : $newConsonantChars;
            $otherCharSet = $startType === 'V' ? $availableConsonantChars : $availableVowelChars;
            $otherNewCharSet = $startType === 'V' ? $newConsonantChars : $newVowelChars;
        } elseif (!empty($availableVowelChars)) {
            $startCharSet = $availableVowelChars;
            $startNewCharSet = $newVowelChars;
            $otherCharSet = [];
            $otherNewCharSet = [];
        } elseif (!empty($availableConsonantChars)) {
            $startCharSet = $availableConsonantChars;
            $startNewCharSet = $newConsonantChars;
            $otherCharSet = [];
            $otherNewCharSet = [];
        } else {
            return '';
        }

        for ($i = 0; $i < $lettersPartLength; $i++) {
            $currentCharSet = ($i % 2 === 0) ? $startCharSet : $otherCharSet;
            $currentNewCharSet = ($i % 2 === 0) ? $startNewCharSet : $otherNewCharSet;

            if (empty($currentCharSet)) {
                $currentCharSet = $availableLetterChars;
                $currentNewCharSet = $newLetterChars;
            }

            $useNumber = !empty($availableNumberChars) && rand(self::RANDOM_MIN_VALUE, self::RANDOM_MAX_VALUE) < self::DIGIT_USAGE_CHANCE;

            if ($useNumber) {
                if (!empty($newNumberChars) && rand(self::RANDOM_MIN_VALUE, self::RANDOM_MAX_VALUE) < self::NEW_CHAR_USAGE_CHANCE) {
                    $lettersPart .= $newNumberChars[array_rand($newNumberChars)];
                } else {
                    $lettersPart .= $availableNumberChars[array_rand($availableNumberChars)];
                }
            } else {
                if (!empty($currentNewCharSet) && rand(self::RANDOM_MIN_VALUE, self::RANDOM_MAX_VALUE) < self::NEW_CHAR_USAGE_CHANCE) {
                    $lettersPart .= $currentNewCharSet[array_rand($currentNewCharSet)];
                } else {
                    $lettersPart .= $currentCharSet[array_rand($currentCharSet)];
                }
            }
        }

        $availableSpecialChars = array_filter($availableChars, function ($char) use ($language) {
            $validSpecialChars = match ($language) {
                'en' => self::SPECIALS_EN,
                'ru' => self::SPECIALS_RU,
                default => [],
            };

            return in_array($char, $validSpecialChars, true);
        });

        $pairedSymbolChars = array_merge(array_keys(self::PAIRED), array_values(self::PAIRED));
        $singleSpecialChars = array_diff($availableSpecialChars, $pairedSymbolChars);

        $possiblePairedOpeningChars = array_keys(self::PAIRED);
        $availablePairedOpeningChars = array_intersect($possiblePairedOpeningChars, $availableSpecialChars);
        $availablePairedChars = [];

        foreach ($availablePairedOpeningChars as $openingChar) {
            if (in_array(self::PAIRED[$openingChar], $availableSpecialChars, true)) {
                $availablePairedChars[] = $openingChar;
            }
        }

        $totalOptions = ['none'];

        if (!empty($singleSpecialChars)) {
            $totalOptions[] = 'single';
        }

        if (!empty($availablePairedChars)) {
            $totalOptions[] = 'paired';
        }

        $type = $totalOptions[array_rand($totalOptions)];

        if ($type === 'none') {
            return $lettersPart;
        } elseif ($type === 'single') {
            $specialChar = $singleSpecialChars[array_rand($singleSpecialChars)];

            if ($this->isPunctuation($specialChar)) {
                return $lettersPart . $specialChar;
            }

            $position = rand(self::BINARY_CHOICE_MIN, self::BINARY_CHOICE_MAX) === self::BINARY_CHOICE_DEFAULT ? 'start' : 'end';

            return $position === 'start' ? $specialChar . $lettersPart : $lettersPart . $specialChar;
        } else {
            $openingChar = $availablePairedChars[array_rand($availablePairedChars)];
            $closingChar = self::PAIRED[$openingChar];

            return $openingChar . $lettersPart . $closingChar;
        }
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
