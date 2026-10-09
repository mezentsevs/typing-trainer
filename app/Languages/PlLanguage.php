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
            'a', 'ą', 's', 'ś', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'ł', ';', '\'',
            'w', 'e', 'ę', 'r', 't', 'y', 'u', 'i', 'o', 'ó', 'p', '[', ']', '\\',
            '<', 'z', 'ż', 'ź', 'c', 'ć', 'b', 'n', 'ń', 'm', ',', '.', '/',
            'A', 'Ą', 'S', 'Ś', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Ł',
            'W', 'E', 'Ę', 'R', 'T', 'Y', 'U', 'I', 'O', 'Ó', 'P',
            '>', 'Z', 'Ż', 'Ź', 'C', 'Ć', 'B', 'N', 'Ń', 'M',
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '-', '=',
            '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+',
            '`', '~', ':', '"', '{', '}', '|', '?', '€',
            'q', 'v', 'x',
            'Q', 'V', 'X',
        ];
    }

    public function getAllLetters(): array
    {
        return [
            'a', 'ą', 'b', 'c', 'ć', 'd', 'e', 'ę', 'f', 'g',
            'h', 'i', 'j', 'k', 'l', 'ł', 'm', 'n', 'ń', 'o',
            'ó', 'p', 'r', 's', 'ś', 't', 'u', 'w', 'y', 'z',
            'ź', 'ż',
            'q', 'v', 'x',
            'A', 'Ą', 'B', 'C', 'Ć', 'D', 'E', 'Ę', 'F', 'G',
            'H', 'I', 'J', 'K', 'L', 'Ł', 'M', 'N', 'Ń', 'O',
            'Ó', 'P', 'R', 'S', 'Ś', 'T', 'U', 'W', 'Y', 'Z',
            'Ź', 'Ż',
            'Q', 'V', 'X',
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
            ';', '\'', '[', ']', '\\', '<', ',', '.', '/', '>',
            '-', '=',
            '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+',
            '`', '~', ':', '"', '{', '}', '|', '?', '€',
        ];
    }
}
