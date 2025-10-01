<?php

namespace App\Providers;

use App\Services\TestGeneration\Strategies\TestTextGeneratingCloudAiStrategy;
use App\Services\TestGeneration\Strategies\TestTextGeneratingLocalAiStrategy;
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
            TestTextGeneratingLocalAiStrategy::class,
            TestTextGeneratingCloudAiStrategy::class,
            TestTextReadingFromFileStrategy::class,
            TestTextRetrievingFromDatabaseStrategy::class,
        ], 'testTextSupplyingStrategies');

        $this->app->bind(TestGenerationOrchestrator::class, function ($app) {
            return new TestGenerationOrchestrator(
                iterator_to_array($app->tagged('testTextSupplyingStrategies'), false),
            );
        });

        $this->app->bind(TestTextGeneratingLocalAiStrategy::class);
        $this->app->bind(TestTextGeneratingCloudAiStrategy::class);
        $this->app->bind(TestTextReadingFromFileStrategy::class);
        $this->app->bind(TestTextRetrievingFromDatabaseStrategy::class);
    }
}
