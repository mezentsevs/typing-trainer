<?php

namespace App\Languages;

use App\Languages\Contracts\Language;

class ItLanguage extends Language
{
    public const string CODE = 'it';

    public function getCode(): string
    {
        return self::CODE;
    }

    public function getIntroductionOrder(): array
    {
        return [
            'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'ò', 'à', 'ù',
            'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', 'è', '+', '\\',
            'z', 'x', 'c', 'v', 'b', 'n', 'm', ',', '.', '-',
            'é', 'ì',
            'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'À', 'Ò', 'Ù',
            'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P', 'È',
            'Z', 'X', 'C', 'V', 'B', 'N', 'M', ';', ':', '_',
            'É', 'Ì',
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
            '!', '"', '£', '$', '%', '&', '/', '(', ')', '=',
            '?', '*', '|', '@', '€', '[', ']', '#', '~',
            'ç', '°', '§',
        ];
    }

    public function getAllLetters(): array
    {
        return array_merge(
            range('a', 'z'),
            ['à', 'è', 'é', 'ì', 'ò', 'ù'],
            range('A', 'Z'),
            ['À', 'È', 'É', 'Ì', 'Ò', 'Ù'],
        );
    }

    public function getVowels(): array
    {
        return [
            'a', 'e', 'i', 'o', 'u',
            'à', 'è', 'é', 'ì', 'ò', 'ù',
            'A', 'E', 'I', 'O', 'U',
            'À', 'È', 'É', 'Ì', 'Ò', 'Ù',
        ];
    }

    public function getSpecials(): array
    {
        return [
            '!', '"', '£', '$', '%', '&', '/', '(', ')', '=',
            '?', '*', '|', '@', '€', '[', ']', '#', '~',
            'ç', '°', '§', ';', ':', '_', '+', '-', '\\', ',', '.', '\'',
        ];
    }
}
