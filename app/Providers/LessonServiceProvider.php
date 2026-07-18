<?php

namespace App\Providers;

use App\Services\Lesson\LessonGeneration\LessonDataComposer;
use App\Services\Lesson\LessonGeneration\LessonGenerationOrchestrator;
use App\Services\Lesson\LessonGeneration\LessonSequenceGenerator;
use App\Services\Lesson\LessonGeneration\LessonTextGenerator;
use App\Services\Lesson\LessonService;
use App\Services\Word\WordService;
use Illuminate\Support\ServiceProvider;

class LessonServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LessonService::class, function ($app) {
            return new LessonService($app->make(LessonGenerationOrchestrator::class));
        });

        $this->app->bind(LessonGenerationOrchestrator::class, function ($app) {
            return new LessonGenerationOrchestrator(
                $app->make(LessonSequenceGenerator::class),
                $app->make(LessonDataComposer::class),
            );
        });

        $this->app->bind(LessonDataComposer::class, function ($app) {
            return new LessonDataComposer($app->make(LessonTextGenerator::class));
        });

        $this->app->bind(LessonTextGenerator::class, function ($app) {
            return new LessonTextGenerator($app->make(WordService::class));
        });

        $this->app->bind(LessonSequenceGenerator::class);
    }
}
