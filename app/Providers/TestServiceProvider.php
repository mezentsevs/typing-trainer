<?php

namespace App\Providers;

use App\Services\TestGeneration\Strategies\TestTextGeneratingWithAiStrategy;
use App\Services\TestGeneration\Strategies\TestTextReadingFromFileStrategy;
use App\Services\TestGeneration\Strategies\TestTextRetrievingFromDatabaseStrategy;
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

        $this->app->tag([
            TestTextReadingFromFileStrategy::class,
            TestTextGeneratingWithAiStrategy::class,
            TestTextRetrievingFromDatabaseStrategy::class,
        ], 'testTextSupplyingStrategies');

        $this->app->bind(TestGenerationOrchestrator::class, function ($app) {
            return new TestGenerationOrchestrator(
                iterator_to_array($app->tagged('testTextSupplyingStrategies'), false),
            );
        });

        $this->app->bind(TestTextReadingFromFileStrategy::class);
        $this->app->bind(TestTextGeneratingWithAiStrategy::class);
        $this->app->bind(TestTextRetrievingFromDatabaseStrategy::class);
    }
}
