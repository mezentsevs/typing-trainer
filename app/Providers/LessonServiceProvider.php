<?php

namespace App\Providers;

use App\Services\LessonGeneration\LessonDataComposer;
use App\Services\LessonGeneration\LessonGenerationOrchestrator;
use App\Services\LessonGeneration\LessonSequenceGenerator;
use App\Services\LessonGeneration\LessonTextGenerator;
use App\Services\LessonService;
use App\Services\WordService;
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
