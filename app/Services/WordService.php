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
    public function generateWord(array $availableCharsArray, array $newCharsArray, string $language): string
    {
        $availableLetters = array_filter($availableCharsArray, function ($char) {
            return preg_match('/[a-zA-ZА-яёЁ0-9]/u', $char);
        });

        $newLetters = array_filter($newCharsArray, function ($char) {
            return preg_match('/[a-zA-ZА-яёЁ0-9]/u', $char);
        });

        $allVowels = $this->getVowels($language);
        $availableVowels = array_intersect($allVowels, $availableLetters);
        $newVowels = array_intersect($allVowels, $newLetters);

        $allConsonants = $this->getConsonants($language);
        $availableConsonants = array_intersect($allConsonants, $availableLetters);
        $newConsonants = array_intersect($allConsonants, $newLetters);

        $availableNumbers = array_filter($availableLetters, function ($char) {
            return preg_match('/[0-9]/u', $char);
        });

        $newNumbers = array_filter($newLetters, function ($char) {
            return preg_match('/[0-9]/u', $char);
        });

        $lettersPartLength = random_int(self::MIN_LETTERS_PART_LENGTH, self::MAX_LETTERS_PART_LENGTH);
        $lettersPart = '';

        if (!empty($availableVowels) && !empty($availableConsonants)) {
            $startType = rand(self::BINARY_CHOICE_MIN, self::BINARY_CHOICE_MAX) === self::BINARY_CHOICE_DEFAULT ? 'V' : 'C';
            $startSet = $startType === 'V' ? $availableVowels : $availableConsonants;
            $startSetNew = $startType === 'V' ? $newVowels : $newConsonants;
            $otherSet = $startType === 'V' ? $availableConsonants : $availableVowels;
            $otherSetNew = $startType === 'V' ? $newConsonants : $newVowels;
        } elseif (!empty($availableVowels)) {
            $startSet = $availableVowels;
            $startSetNew = $newVowels;
            $otherSet = [];
            $otherSetNew = [];
        } elseif (!empty($availableConsonants)) {
            $startSet = $availableConsonants;
            $startSetNew = $newConsonants;
            $otherSet = [];
            $otherSetNew = [];
        } else {
            return '';
        }

        for ($i = 0; $i < $lettersPartLength; $i++) {
            $set = ($i % 2 === 0) ? $startSet : $otherSet;
            $setNew = ($i % 2 === 0) ? $startSetNew : $otherSetNew;

            if (empty($set)) {
                $set = $availableLetters;
                $setNew = $newLetters;
            }

            $useNumber = !empty($availableNumbers) && rand(self::RANDOM_MIN_VALUE, self::RANDOM_MAX_VALUE) < self::DIGIT_USAGE_CHANCE;

            if ($useNumber) {
                if (!empty($newNumbers) && rand(self::RANDOM_MIN_VALUE, self::RANDOM_MAX_VALUE) < self::NEW_CHAR_USAGE_CHANCE) {
                    $lettersPart .= $newNumbers[array_rand($newNumbers)];
                } else {
                    $lettersPart .= $availableNumbers[array_rand($availableNumbers)];
                }
            } else {
                if (!empty($setNew) && rand(self::RANDOM_MIN_VALUE, self::RANDOM_MAX_VALUE) < self::NEW_CHAR_USAGE_CHANCE) {
                    $lettersPart .= $setNew[array_rand($setNew)];
                } else {
                    $lettersPart .= $set[array_rand($set)];
                }
            }
        }

        $availableSpecials = array_filter($availableCharsArray, function ($char) use ($language) {
            $validSpecials = match ($language) {
                'en' => self::SPECIALS_EN,
                'ru' => self::SPECIALS_RU,
                default => [],
            };

            return in_array($char, $validSpecials, true);
        });

        $pairedSymbols = array_merge(array_keys(self::PAIRED), array_values(self::PAIRED));
        $singleSpecials = array_diff($availableSpecials, $pairedSymbols);

        $possiblePairedOpenings = array_keys(self::PAIRED);
        $availablePairedOpenings = array_intersect($possiblePairedOpenings, $availableSpecials);
        $availablePaired = [];

        foreach ($availablePairedOpenings as $opening) {
            if (in_array(self::PAIRED[$opening], $availableSpecials, true)) {
                $availablePaired[] = $opening;
            }
        }

        $totalOptions = ['none'];

        if (!empty($singleSpecials)) {
            $totalOptions[] = 'single';
        }

        if (!empty($availablePaired)) {
            $totalOptions[] = 'paired';
        }

        $type = $totalOptions[array_rand($totalOptions)];

        if ($type === 'none') {
            return $lettersPart;
        } elseif ($type === 'single') {
            $special = $singleSpecials[array_rand($singleSpecials)];

            if ($this->isPunctuation($special)) {
                return $lettersPart . $special;
            }

            $position = rand(self::BINARY_CHOICE_MIN, self::BINARY_CHOICE_MAX) === self::BINARY_CHOICE_DEFAULT ? 'start' : 'end';

            return $position === 'start' ? $special . $lettersPart : $lettersPart . $special;
        } else {
            $opening = $availablePaired[array_rand($availablePaired)];
            $closing = self::PAIRED[$opening];

            return $opening . $lettersPart . $closing;
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
