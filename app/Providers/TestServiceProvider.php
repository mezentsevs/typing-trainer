<?php

namespace App\Providers;

use App\Services\TestGeneration\Strategies\TestGeneratingCloudAiStrategy;
use App\Services\TestGeneration\Strategies\TestGeneratingLocalAiStrategy;
use App\Services\TestGeneration\Strategies\TestReadingFromFileStrategy;
use App\Services\TestGeneration\Strategies\TestRetrievingFromDatabaseStrategy;
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
            TestGeneratingLocalAiStrategy::class,
            TestGeneratingCloudAiStrategy::class,
            TestReadingFromFileStrategy::class,
            TestRetrievingFromDatabaseStrategy::class,
        ], 'testRetrieveStrategies');

        $this->app->bind(TestGenerationOrchestrator::class, function ($app) {
            return new TestGenerationOrchestrator(
                iterator_to_array($app->tagged('testRetrieveStrategies'), false),
            );
        });

        $this->app->bind(TestGeneratingLocalAiStrategy::class);
        $this->app->bind(TestGeneratingCloudAiStrategy::class);
        $this->app->bind(TestReadingFromFileStrategy::class);
        $this->app->bind(TestRetrievingFromDatabaseStrategy::class);
    }
}
