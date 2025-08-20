<?php

namespace Tests\Unit\Services\Providers;

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
}
