<?php

namespace App\Languages;

use App\Languages\Contracts\Language;

class EsLanguage extends Language
{
    public const string CODE = 'es';

    public function getCode(): string
    {
        return self::CODE;
    }

    public function getIntroductionOrder(): array
    {
        return [
            'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'ñ',
            'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p',
            'z', 'x', 'c', 'v', 'b', 'n', 'm', ',', '.', '-',
            'á', 'é', 'í', 'ó', 'ú', 'ü',
            'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Ñ',
            'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P',
            'Z', 'X', 'C', 'V', 'B', 'N', 'M', ';', ':', '_',
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
            '!', '"', '·', '$', '%', '&', '/', '(', ')', '=',
            '?', '¿', '¡', 'º', 'ª', '\\', '|', '@', '#', '~',
            '€', '¬', '{', '[', ']', '}', '`', '^', '*', "'",
        ];
    }

    public function getAllLetters(): array
    {
        return array_merge(
            range('a', 'z'),
            ['ñ', 'á', 'é', 'í', 'ó', 'ú', 'ü'],
            range('A', 'Z'),
            ['Ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ü'],
        );
    }

    public function getVowels(): array
    {
        return [
            'a', 'e', 'i', 'o', 'u', 'á', 'é', 'í', 'ó', 'ú', 'ü',
            'A', 'E', 'I', 'O', 'U', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ü',
        ];
    }

    public function getSpecials(): array
    {
        return [
            '!', '"', '·', '$', '%', '&', '/', '(', ')', '=', '?', '¿', '¡',
            'º', 'ª', '|', '@', '#', '~', '€', '¬', '{', '[', ']', '}', '\\',
            '`', '^', '*', '_', ';', ':', ',', '.', '-', "'",
        ];
    }
}
