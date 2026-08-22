<?php

namespace App\Languages\Registry;

use App\Languages\Contracts\Language;
use App\Languages\DeLanguage;
use App\Languages\EnLanguage;
use App\Languages\EsLanguage;
use App\Languages\FrLanguage;
use App\Languages\IdLanguage;
use App\Languages\ItLanguage;
use App\Languages\PlLanguage;
use App\Languages\PtLanguage;
use App\Languages\RuLanguage;
use App\Languages\TrLanguage;

class LanguageRegistry
{
    public const array LANGUAGE_CLASSES = [
        DeLanguage::class,
        EnLanguage::class,
        EsLanguage::class,
        FrLanguage::class,
        IdLanguage::class,
        ItLanguage::class,
        PlLanguage::class,
        PtLanguage::class,
        RuLanguage::class,
        TrLanguage::class,
    ];

    /** @var array<string, Language> */
    private array $languages = [];

    public function __construct(array $languages)
    {
        foreach ($languages as $language) {
            $this->languages[$language->getCode()] = $language;
        }
    }

    public static function createDefault(): self
    {
        $languages = [];

        foreach (self::LANGUAGE_CLASSES as $languageClass) {
            $languages[] = new $languageClass();
        }

        return new self($languages);
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
