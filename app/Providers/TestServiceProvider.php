<?php

namespace App\Providers;

use App\Services\TestGeneration\Strategies\TestRetrieveAiCloudStrategy;
use App\Services\TestGeneration\Strategies\TestRetrieveAiLocalStrategy;
use App\Services\TestGeneration\Strategies\TestRetrieveDatabaseStrategy;
use App\Services\TestGeneration\Strategies\TestRetrieveFileStrategy;
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
            TestRetrieveAiLocalStrategy::class,
            TestRetrieveAiCloudStrategy::class,
            TestRetrieveFileStrategy::class,
            TestRetrieveDatabaseStrategy::class,
        ], 'testRetrieveStrategies');

        $this->app->bind(TestGenerationOrchestrator::class, function ($app) {
            return new TestGenerationOrchestrator(
                iterator_to_array($app->tagged('testRetrieveStrategies'), false),
            );
        });

        $this->app->bind(TestRetrieveAiLocalStrategy::class);
        $this->app->bind(TestRetrieveAiCloudStrategy::class);
        $this->app->bind(TestRetrieveFileStrategy::class);
        $this->app->bind(TestRetrieveDatabaseStrategy::class);
    }
}
