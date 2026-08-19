<?php

namespace App\Languages\Registry;

use App\Languages\Contracts\Language;
use App\Languages\EnLanguage;

class LanguageRegistry
{
    /** @var array<string, Language> */
    private array $languages = [];

    public function __construct(array $languages)
    {
        foreach ($languages as $language) {
            $this->languages[$language->getCode()] = $language;
        }
    }

    public function get(string $code): ?Language
    {
        return $this->languages[$code] ?? null;
    }

    public function getSupportedOrDefault(string $code): Language
    {
        return $this->languages[$code] ?? $this->languages[EnLanguage::CODE];
    }

    public function getSupportedCodes(): array
    {
        return array_keys($this->languages);
    }

    public function getAllLanguages(): array
    {
        return array_values($this->languages);
    }
}
