<?php

namespace App\Providers;

use App\Services\TestGeneration\Strategies\TestTextAiGeneratingStrategy;
use App\Services\TestGeneration\Strategies\TestTextDatabaseRetrievingStrategy;
use App\Services\TestGeneration\Strategies\TestTextFileReadingStrategy;
use App\Services\TestGeneration\TestGenerationOrchestrator;
use App\Services\TestService;
use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TestService::class, function ($app) {
            return new TestService($app->make(TestGenerationOrchestrator::class));
        });

        $this->app->bind(TestGenerationOrchestrator::class, function ($app) {
            return new TestGenerationOrchestrator(
                $app->make(TestTextFileReadingStrategy::class),
                $app->make(TestTextAiGeneratingStrategy::class),
                $app->make(TestTextDatabaseRetrievingStrategy::class),
            );
        });

        $this->app->bind(TestTextFileReadingStrategy::class, function () {
            return new TestTextFileReadingStrategy();
        });

        $this->app->bind(TestTextAiGeneratingStrategy::class, function () {
            return new TestTextAiGeneratingStrategy();
        });

        $this->app->bind(TestTextDatabaseRetrievingStrategy::class, function () {
            return new TestTextDatabaseRetrievingStrategy();
        });
    }
}
