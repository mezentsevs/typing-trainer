<?php

namespace App\Providers;

use App\Languages\EnLanguage;
use App\Languages\Registry\LanguageRegistry;
use App\Languages\RuLanguage;
use Illuminate\Support\ServiceProvider;

class LanguageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(LanguageRegistry::class, function () {
            return new LanguageRegistry([
                new EnLanguage(),
                new RuLanguage(),
            ]);
        });
    }
}
