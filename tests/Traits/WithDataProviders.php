<?php

namespace Tests\Traits;

trait WithDataProviders
{
    private static ?array $providers = null;

    abstract protected static function getProviderClasses(): array;

    private static function getProviders(): array
    {
        if (self::$providers === null) {
            self::$providers = [];

            foreach (static::getProviderClasses() as $providerClass) {
                self::$providers[] = new $providerClass();
            }
        }

        return self::$providers;
    }
}
