<?php

namespace Tests\Providers;

use App\Languages\Contracts\Language;
use App\Languages\Registry\LanguageRegistry;

class CommonDataProvider
{
    public static function provideSupportedLanguages(): array
    {
        $result = [];

        foreach (self::getSupportedLanguageCodes() as $code) {
            $result[$code] = [$code];
        }

        return $result;
    }

    public static function getSupportedLanguageCodes(): array
    {
        $codes = [];

        foreach (LanguageRegistry::LANGUAGE_CLASSES as $languageClass) {
            /** @var Language $language */
            $language = new $languageClass();
            $codes[] = $language->getCode();
        }

        return $codes;
    }
}
