<?php

namespace App\Services\Word\WordGeneration;

use App\Languages\Registry\LanguageRegistry;

class WordCharDataProvider
{
    public const array PAIRED = ['(' => ')', '[' => ']', '{' => '}', '<' => '>', '"' => '"', "'" => "'", '`' => '`'];
    public const array PUNCTUATION = [',', '.', ';', ':', '!', '?'];

    public const int MAX_LETTERS_PART_LENGTH = 8;
    public const int MIN_LETTERS_PART_LENGTH = 3;

    public const int NEW_CHAR_CHANCE = 70;
    public const int NUMBER_CHANCE = 30;

    public function __construct(private LanguageRegistry $languageRegistry)
    {
    }

    public function getAllLetters(string $language): array
    {
        return $this->languageRegistry->getSupportedOrDefault($language)->getAllLetters();
    }

    public function getVowels(string $language): array
    {
        return $this->languageRegistry->getSupportedOrDefault($language)->getVowels();
    }

    public function getConsonants(string $language): array
    {
        return $this->languageRegistry->getSupportedOrDefault($language)->getConsonants();
    }

    public function isPunctuation(string $char): bool
    {
        return in_array($char, self::PUNCTUATION, true);
    }
}
