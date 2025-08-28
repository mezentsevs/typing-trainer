<?php

namespace Tests\Unit\Services\Providers;

use App\Enums\Language;
use App\Services\WordGeneration\WordCharDataProvider;

class WordDataProvider
{
    public static function provideWordGenerationData(): array
    {
        return [
            Language::En->value => [[
                'availableChars' => ['a', 'b', 'c', 'd', 'e', '1', '2', '!', '@'],
                'newChars' => ['a', 'b', 'c'],
                'language' => Language::En->value,
            ]],
            Language::Ru->value => [[
                'availableChars' => ['а', 'б', 'в', 'г', 'д', '1', '2', '!', '@'],
                'newChars' => ['а', 'б', 'в'],
                'language' => Language::Ru->value,
            ]],
        ];
    }

    public static function providePairedCharsData(): array
    {
        $data = [];

        foreach (WordCharDataProvider::PAIRED as $openingChar => $closingChar) {
            if (in_array($openingChar, WordCharDataProvider::SPECIALS_EN, true) &&
                in_array($closingChar, WordCharDataProvider::SPECIALS_EN, true)) {
                $data["en {$openingChar}{$closingChar}"] = [[
                    'availableChars' => ['a', $openingChar, $closingChar],
                    'newChars' => ['a', $openingChar, $closingChar],
                    'language' => Language::En->value,
                    'openingChar' => $openingChar,
                    'closingChar' => $closingChar,
                ]];
            }

            if (in_array($openingChar, WordCharDataProvider::SPECIALS_RU, true) &&
                in_array($closingChar, WordCharDataProvider::SPECIALS_RU, true)) {
                $data["ru {$openingChar}{$closingChar}"] = [[
                    'availableChars' => ['а', $openingChar, $closingChar],
                    'newChars' => ['а', $openingChar, $closingChar],
                    'language' => Language::Ru->value,
                    'openingChar' => $openingChar,
                    'closingChar' => $closingChar,
                ]];
            }
        }

        return $data;
    }
}
