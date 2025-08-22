<?php

namespace App\Providers;

use App\Services\WordService;
use Illuminate\Support\ServiceProvider;

class WordServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(WordService::class, function () {
            return new WordService();
        });
    }
}
