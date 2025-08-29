<?php

namespace App\Services\WordGeneration;

use App\Enums\Language;

class WordCharDataProvider
{
    public const array LETTERS_LC_RU = ['а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'];
    public const array LETTERS_UC_RU = ['А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'];
    public const array VOWELS_EN = ['a', 'e', 'i', 'o', 'u', 'y', 'A', 'E', 'I', 'O', 'U', 'Y'];
    public const array VOWELS_RU = ['а', 'е', 'ё', 'и', 'о', 'у', 'ы', 'э', 'ю', 'я', 'А', 'Е', 'Ё', 'И', 'О', 'У', 'Ы', 'Э', 'Ю', 'Я'];
    public const array SPECIALS_EN = ['!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '-', '=', '+', '[', ']', '{', '}', '|', '\\', ':', '"', '\'', '<', '>', '?', '~', '`', ',', '.', ';'];
    public const array SPECIALS_RU = ['!', '"', '№', ';', '%', ':', '?', '*', '(', ')', '-', '=', '+', '/', '\\', ',', '.'];
    public const array PAIRED = ['(' => ')', '[' => ']', '{' => '}', '<' => '>', '"' => '"', "'" => "'", '`' => '`'];
    public const array PUNCTUATION = [',', '.', ';', ':', '!', '?'];

    public const int MIN_LETTERS_PART_LENGTH = 3;
    public const int MAX_LETTERS_PART_LENGTH = 8;
    public const int RANDOM_MIN_VALUE = 0;
    public const int RANDOM_MAX_VALUE = 99;
    public const int DIGIT_USAGE_CHANCE = 30;
    public const int NEW_CHAR_USAGE_CHANCE = 70;
    public const int BINARY_CHOICE_MIN = 0;
    public const int BINARY_CHOICE_MAX = 1;
    public const int BINARY_CHOICE_DEFAULT = 0;
    public const string CHAR_TYPE_VOWEL = 'V';
    public const string CHAR_TYPE_CONSONANT = 'C';

    public function getAllLetters(string $language): array
    {
        return match ($language) {
            Language::En->value => array_merge(range('a', 'z'), range('A', 'Z')),
            Language::Ru->value => array_merge(self::LETTERS_LC_RU, self::LETTERS_UC_RU),
            default => [],
        };
    }

    public function getVowels(string $language): array
    {
        return match ($language) {
            Language::En->value => self::VOWELS_EN,
            Language::Ru->value => self::VOWELS_RU,
            default => [],
        };
    }

    public function getConsonants(string $language): array
    {
        return match ($language) {
            Language::En->value => array_diff($this->getAllLetters(Language::En->value), $this->getVowels(Language::En->value)),
            Language::Ru->value => array_diff($this->getAllLetters(Language::Ru->value), $this->getVowels(Language::Ru->value)),
            default => [],
        };
    }

    public function isPunctuation(string $char): bool
    {
        return in_array($char, self::PUNCTUATION, true);
    }
}
