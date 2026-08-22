<?php

namespace Tests\Providers;

use Tests\Providers\Languages\Word\Contracts\LanguageWordDataProvider;
use Tests\Providers\Languages\Word\DeWordDataProvider;
use Tests\Providers\Languages\Word\EnWordDataProvider;
use Tests\Providers\Languages\Word\EsWordDataProvider;
use Tests\Providers\Languages\Word\FrWordDataProvider;
use Tests\Providers\Languages\Word\IdWordDataProvider;
use Tests\Providers\Languages\Word\ItWordDataProvider;
use Tests\Providers\Languages\Word\PlWordDataProvider;
use Tests\Providers\Languages\Word\PtWordDataProvider;
use Tests\Providers\Languages\Word\RuWordDataProvider;
use Tests\Providers\Languages\Word\TrWordDataProvider;
use Tests\Traits\WithDataProviders;

class WordDataProvider
{
    use WithDataProviders;

    protected static function getProviderClasses(): array
    {
        return [
            DeWordDataProvider::class,
            EnWordDataProvider::class,
            EsWordDataProvider::class,
            FrWordDataProvider::class,
            IdWordDataProvider::class,
            ItWordDataProvider::class,
            PlWordDataProvider::class,
            PtWordDataProvider::class,
            RuWordDataProvider::class,
            TrWordDataProvider::class,
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
