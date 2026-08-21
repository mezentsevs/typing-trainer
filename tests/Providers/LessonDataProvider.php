<?php

namespace Tests\Providers;

use Tests\Providers\Languages\Contracts\LanguageLessonDataProvider;
use Tests\Providers\Languages\EnLessonDataProvider;
use Tests\Providers\Languages\RuLessonDataProvider;
use Tests\Traits\WithDataProviders;

class LessonDataProvider
{
    use WithDataProviders;

    protected static function getProviderClasses(): array
    {
        return [
            EnLessonDataProvider::class,
            RuLessonDataProvider::class,
        ];
    }

    public static function provideLessonsSequenceData(): array
    {
        $result = [];

        foreach (self::getProviders() as $provider) {
            /** @var LanguageLessonDataProvider $provider */
            $result += $provider->provideData();
        }

        return $result;
    }
}
