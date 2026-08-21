<?php

namespace Tests\Providers;

use Tests\Providers\Languages\Contracts\LanguageWordDataProvider;
use Tests\Providers\Languages\EnWordDataProvider;
use Tests\Providers\Languages\RuWordDataProvider;
use Tests\Traits\WithDataProviders;

class WordDataProvider
{
    use WithDataProviders;

    protected static function getProviderClasses(): array
    {
        return [
            EnWordDataProvider::class,
            RuWordDataProvider::class,
        ];
    }

    public static function provideWordGenerationData(): array
    {
        $result = [];

        foreach (self::getProviders() as $provider) {
            /** @var LanguageWordDataProvider $provider */
            $result += $provider->provideWordGenerationData();
        }

        return $result;
    }

    public static function providePairedCharsData(): array
    {
        $result = [];

        foreach (self::getProviders() as $provider) {
            /** @var LanguageWordDataProvider $provider */
            $result += $provider->providePairedCharsData();
        }

        return $result;
    }
}
