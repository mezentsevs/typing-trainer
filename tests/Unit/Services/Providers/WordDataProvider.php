<?php

namespace Tests\Unit\Services\Providers;

use App\Services\WordService;
use ReflectionClass;

class WordDataProvider
{
    public static function provideWordGenerationData(): array
    {
        return [
            'en' => [[
                'availableChars' => ['a', 'b', 'c', 'd', 'e', '1', '2', '!', '@'],
                'newChars' => ['a', 'b', 'c'],
                'language' => 'en',
            ]],
            'ru' => [[
                'availableChars' => ['а', 'б', 'в', 'г', 'д', '1', '2', '!', '@'],
                'newChars' => ['а', 'б', 'в'],
                'language' => 'ru',
            ]],
        ];
    }

    public static function providePairedCharsData(): array
    {
        $wordServiceReflection = new ReflectionClass(WordService::class);
        $pairedChars = $wordServiceReflection->getConstant('PAIRED');
        $specialCharsEn = $wordServiceReflection->getConstant('SPECIALS_EN');
        $specialCharsRu = $wordServiceReflection->getConstant('SPECIALS_RU');

        $data = [];

        foreach ($pairedChars as $openingChar => $closingChar) {
            if (in_array($openingChar, $specialCharsEn, true) && in_array($closingChar, $specialCharsEn, true)) {
                $data["en {$openingChar}{$closingChar}"] = [[
                    'availableChars' => ['a', $openingChar, $closingChar],
                    'newChars' => ['a', $openingChar, $closingChar],
                    'language' => 'en',
                    'openingChar' => $openingChar,
                    'closingChar' => $closingChar,
                ]];
            }

            if (in_array($openingChar, $specialCharsRu, true) && in_array($closingChar, $specialCharsRu, true)) {
                $data["ru {$openingChar}{$closingChar}"] = [[
                    'availableChars' => ['а', $openingChar, $closingChar],
                    'newChars' => ['а', $openingChar, $closingChar],
                    'language' => 'ru',
                    'openingChar' => $openingChar,
                    'closingChar' => $closingChar,
                ]];
            }
        }

        return $data;
    }
}
