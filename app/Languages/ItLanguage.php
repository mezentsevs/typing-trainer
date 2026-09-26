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
            'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', 'è', '+',
            '<', 'z', 'x', 'c', 'v', 'b', 'n', 'm', ',', '.', '-',
            'ì', 'é',
            'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Ò', 'À', 'Ù',
            'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P', 'È',
            '>', 'Z', 'X', 'C', 'V', 'B', 'N', 'M',
            'Ì',
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
            '!', '"', '£', '$', '%', '&', '/', '(', ')', '=', '?', '^',
            '*', '°', '§', ';', ':', '_',
            '\\', '|', '\'',
            '@', '#', '[', ']', '{', '}', '€',
            'ç',
        ];
    }

    public function getAllLetters(): array
    {
        return array_merge(
            range('a', 'z'),
            ['à', 'è', 'ì', 'ò', 'ù'],
            ['é'],
            ['ç'],
            range('A', 'Z'),
            ['À', 'È', 'Ì', 'Ò', 'Ù'],
        );
    }

    public function getVowels(): array
    {
        return [
            'a', 'e', 'i', 'o', 'u',
            'à', 'è', 'ì', 'ò', 'ù',
            'é',
            'A', 'E', 'I', 'O', 'U',
            'À', 'È', 'Ì', 'Ò', 'Ù',
        ];
    }

    public function getSpecials(): array
    {
        return [
            '!', '"', '£', '$', '%', '&', '/', '(', ')', '=', '?', '^',
            '*', '°', '§', ';', ':', '_', '\\', '|', '\'',
            '+', '<', '>', ',', '.', '-',
            '@', '#', '[', ']', '{', '}', '€',
        ];
    }
}
