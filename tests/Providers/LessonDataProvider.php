<?php

namespace Tests\Providers;

use Tests\Providers\Languages\Lesson\Contracts\LanguageLessonDataProvider;
use Tests\Providers\Languages\Lesson\DeLessonDataProvider;
use Tests\Providers\Languages\Lesson\EnLessonDataProvider;
use Tests\Providers\Languages\Lesson\EsLessonDataProvider;
use Tests\Providers\Languages\Lesson\FrLessonDataProvider;
use Tests\Providers\Languages\Lesson\IdLessonDataProvider;
use Tests\Providers\Languages\Lesson\ItLessonDataProvider;
use Tests\Providers\Languages\Lesson\PlLessonDataProvider;
use Tests\Providers\Languages\Lesson\PtLessonDataProvider;
use Tests\Providers\Languages\Lesson\RuLessonDataProvider;
use Tests\Providers\Languages\Lesson\TrLessonDataProvider;
use Tests\Traits\WithDataProviders;

class LessonDataProvider
{
    use WithDataProviders;

    protected static function getProviderClasses(): array
    {
        return [
            DeLessonDataProvider::class,
            EnLessonDataProvider::class,
            EsLessonDataProvider::class,
            FrLessonDataProvider::class,
            IdLessonDataProvider::class,
            ItLessonDataProvider::class,
            PlLessonDataProvider::class,
            PtLessonDataProvider::class,
            RuLessonDataProvider::class,
            TrLessonDataProvider::class,
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
