<?php

namespace App\Providers;

use App\Languages\Registry\LanguageRegistry;
use Illuminate\Support\ServiceProvider;

class LanguageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(LanguageRegistry::class, function () {
            return LanguageRegistry::createDefault();
        });
    }
}
