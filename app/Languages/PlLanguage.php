<?php

namespace App\Languages;

use App\Languages\Contracts\Language;

class PlLanguage extends Language
{
    public const string CODE = 'pl';

    public function getCode(): string
    {
        return self::CODE;
    }

    public function getIntroductionOrder(): array
    {
        return [
            'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', ';',
            'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p',
            'z', 'x', 'c', 'v', 'b', 'n', 'm', ',', '.', '/',
            'ą', 'ę', 'ó', 'ś', 'ł', 'ż', 'ź', 'ć', 'ń',
            'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', ':',
            'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P',
            'Z', 'X', 'C', 'V', 'B', 'N', 'M', '<', '>', '?',
            'Ą', 'Ę', 'Ó', 'Ś', 'Ł', 'Ż', 'Ź', 'Ć', 'Ń',
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
            '!', '@', '#', '$', '%', '^', '&', '*', '(', ')',
            '-', '=', '+', '[', ']', '{', '}', '|', '\\',
            '"', '\'', '~', '`', '_', '€',
        ];
    }

    public function getAllLetters(): array
    {
        return [
            'a', 'ą', 'b', 'c', 'ć', 'd', 'e', 'ę', 'f', 'g',
            'h', 'i', 'j', 'k', 'l', 'ł', 'm', 'n', 'ń', 'o',
            'ó', 'p', 'r', 's', 'ś', 't', 'u', 'w', 'y', 'z',
            'ź', 'ż',
            'A', 'Ą', 'B', 'C', 'Ć', 'D', 'E', 'Ę', 'F', 'G',
            'H', 'I', 'J', 'K', 'L', 'Ł', 'M', 'N', 'Ń', 'O',
            'Ó', 'P', 'R', 'S', 'Ś', 'T', 'U', 'W', 'Y', 'Z',
            'Ź', 'Ż',
        ];
    }

    public function getVowels(): array
    {
        return [
            'a', 'ą', 'e', 'ę', 'i', 'o', 'ó', 'u', 'y',
            'A', 'Ą', 'E', 'Ę', 'I', 'O', 'Ó', 'U', 'Y',
        ];
    }

    public function getSpecials(): array
    {
        return [
            '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '-', '=', '+',
            '[', ']', '{', '}', '|', '\\', ':', '"', '\'', '<', '>', '?',
            '~', '`', ',', '.', ';', '€',
        ];
    }
}
