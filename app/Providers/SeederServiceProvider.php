<?php

namespace App\Providers;

use Database\Seeders\Test\Languages\EnTestSeeder;
use Database\Seeders\Test\Languages\RuTestSeeder;
use Illuminate\Support\ServiceProvider;

class SeederServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag([
            EnTestSeeder::class,
            RuTestSeeder::class,
        ], 'languageTestSeeders');
    }
}
