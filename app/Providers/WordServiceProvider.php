<?php

namespace App\Providers;

use App\Services\WordGeneration\WordCharDataProvider;
use App\Services\WordGeneration\WordCharProbabilitySelector;
use App\Services\WordGeneration\WordCharSetsInitializer;
use App\Services\WordGeneration\WordGenerationOrchestrator;
use App\Services\WordGeneration\WordLettersPartGenerator;
use App\Services\WordGeneration\WordSpecialCharsAppender;
use App\Services\WordService;
use Illuminate\Support\ServiceProvider;

class WordServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(WordService::class, function ($app) {
            return new WordService($app->make(WordGenerationOrchestrator::class));
        });

        $this->app->bind(WordGenerationOrchestrator::class, function ($app) {
            return new WordGenerationOrchestrator(
                $app->make(WordCharSetsInitializer::class),
                $app->make(WordLettersPartGenerator::class),
                $app->make(WordSpecialCharsAppender::class),
            );
        });

        $this->app->bind(WordCharSetsInitializer::class, function ($app) {
            return new WordCharSetsInitializer($app->make(WordCharDataProvider::class));
        });

        $this->app->bind(WordLettersPartGenerator::class, function ($app) {
            return new WordLettersPartGenerator(
                $app->make(WordCharProbabilitySelector::class),
                $app->make(WordCharDataProvider::class),
            );
        });

        $this->app->bind(WordSpecialCharsAppender::class, function ($app) {
            return new WordSpecialCharsAppender($app->make(WordCharDataProvider::class));
        });

        $this->app->bind(WordCharProbabilitySelector::class, function () {
            return new WordCharProbabilitySelector();
        });

        $this->app->bind(WordCharDataProvider::class, function () {
            return new WordCharDataProvider();
        });
    }
}
