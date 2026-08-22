<?php

namespace App\Languages;

use App\Languages\Contracts\Language;

class IdLanguage extends Language
{
    public const string CODE = 'id';

    public function getCode(): string
    {
        return self::CODE;
    }

    public function getIntroductionOrder(): array
    {
        return [
            'a', 's', 'd', 'f', 'j', 'k', 'l', ';',
            'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p',
            'h', 'g', 'z', 'x', 'c', 'v', 'b', 'n', 'm', ',', '.', '/',
            'A', 'S', 'D', 'F', 'J', 'K', 'L', ';',
            'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P',
            'H', 'G', 'Z', 'X', 'C', 'V', 'B', 'N', 'M', ',', '.', '/',
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '-', '=',
            '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '[', ']', '{', '}', '|', '\\', ':', '"', '\'', '<', '>', '?', '~', '`',
        ];
    }

    public function getAllLetters(): array
    {
        return array_merge(range('a', 'z'), range('A', 'Z'));
    }

    public function getVowels(): array
    {
        return [
            'a', 'e', 'i', 'o', 'u',
            'A', 'E', 'I', 'O', 'U',
        ];
    }

    public function getSpecials(): array
    {
        return ['!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '-', '=', '+', '[', ']', '{', '}', '|', '\\', ':', '"', '\'', '<', '>', '?', '~', '`', ',', '.', ';'];
    }
}
