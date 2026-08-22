<?php

namespace App\Languages;

use App\Languages\Contracts\Language;

class DeLanguage extends Language
{
    public const string CODE = 'de';

    public function getCode(): string
    {
        return self::CODE;
    }

    public function getIntroductionOrder(): array
    {
        return [
            'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'ö', 'ä', '#',
            'q', 'w', 'e', 'r', 't', 'z', 'u', 'i', 'o', 'p', 'ü', '+', '\\',
            'y', 'x', 'c', 'v', 'b', 'n', 'm', ',', '.', '-',
            'ß',
            'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Ö', 'Ä',
            'Q', 'W', 'E', 'R', 'T', 'Z', 'U', 'I', 'O', 'P', 'Ü',
            'Y', 'X', 'C', 'V', 'B', 'N', 'M', ';', ':', '_',
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
            '!', '"', '§', '$', '%', '&', '/', '(', ')', '=', '?', '`', '°',
            '²', '³', '{', '[', ']', '}', '~', '|', '@', '€', 'µ', "'",
        ];
    }

    public function getAllLetters(): array
    {
        return array_merge(
            range('a', 'z'),
            ['ä', 'ö', 'ü', 'ß'],
            range('A', 'Z'),
            ['Ä', 'Ö', 'Ü', 'ẞ'],
        );
    }

    public function getVowels(): array
    {
        return [
            'a', 'e', 'i', 'o', 'u', 'ä', 'ö', 'ü',
            'A', 'E', 'I', 'O', 'U', 'Ä', 'Ö', 'Ü',
        ];
    }

    public function getSpecials(): array
    {
        return [
            '!', '"', '§', '$', '%', '&', '/', '(', ')', '=', '?', '`', '°',
            '²', '³', '{', '[', ']', '}', '\\', '~', '|', '@', '€', 'µ',
            '#', '\'', ',', '.', ';', ':', '_', '-', '+', '*',
        ];
    }
}
