<?php

namespace App\Providers;

use Database\Seeders\Test\Languages\DeTestSeeder;
use Database\Seeders\Test\Languages\EnTestSeeder;
use Database\Seeders\Test\Languages\EsTestSeeder;
use Database\Seeders\Test\Languages\FrTestSeeder;
use Database\Seeders\Test\Languages\IdTestSeeder;
use Database\Seeders\Test\Languages\ItTestSeeder;
use Database\Seeders\Test\Languages\PlTestSeeder;
use Database\Seeders\Test\Languages\PtTestSeeder;
use Database\Seeders\Test\Languages\RuTestSeeder;
use Database\Seeders\Test\Languages\TrTestSeeder;
use Illuminate\Support\ServiceProvider;

class SeederServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag([
            DeTestSeeder::class,
            EnTestSeeder::class,
            EsTestSeeder::class,
            FrTestSeeder::class,
            IdTestSeeder::class,
            ItTestSeeder::class,
            PlTestSeeder::class,
            PtTestSeeder::class,
            RuTestSeeder::class,
            TrTestSeeder::class,
        ], 'languageTestSeeders');
    }
}
