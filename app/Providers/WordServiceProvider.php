<?php

namespace App\Providers;

use App\Languages\Registry\LanguageRegistry;
use App\Services\Word\WordGeneration\WordCharDataProvider;
use App\Services\Word\WordGeneration\WordCharProbabilitySelector;
use App\Services\Word\WordGeneration\WordCharSetsInitializer;
use App\Services\Word\WordGeneration\WordGenerationOrchestrator;
use App\Services\Word\WordGeneration\WordLettersPartGenerator;
use App\Services\Word\WordGeneration\WordSpecialCharsAppender;
use App\Services\Word\WordService;
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
            return new WordSpecialCharsAppender(
                $app->make(WordCharDataProvider::class),
                $app->make(LanguageRegistry::class),
            );
        });

        $this->app->bind(WordCharProbabilitySelector::class);
        $this->app->bind(WordCharDataProvider::class);
    }
}
