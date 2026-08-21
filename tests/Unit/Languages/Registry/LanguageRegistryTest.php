<?php

namespace Tests\Unit\Languages\Registry;

use App\Languages\Contracts\Language;
use App\Languages\EnLanguage;
use App\Languages\Registry\LanguageRegistry;
use Tests\TestCase;
use Tests\Traits\Constants\WithLanguageRegistryConstants;

class LanguageRegistryTest extends TestCase
{
    use WithLanguageRegistryConstants;

    protected LanguageRegistry $registry;

    protected function setUp(): void
    {
        parent::setUp();

        $this->registry = app(LanguageRegistry::class);
    }

    public function testGetReturnsLanguageForSupportedCode(): void
    {
        foreach ($this->registry->getAllLanguages() as $language) {
            $expected = $language;
            $actual = $this->registry->get($language->getCode());

            $this->assertSame($expected, $actual);
        }
    }

    public function testGetReturnsNullForUnknownCode(): void
    {
        $this->assertNull($this->registry->get(self::UNKNOWN_LANGUAGE));
    }

    public function testGetSupportedOrDefaultReturnsLanguageForSupportedCode(): void
    {
        foreach ($this->registry->getAllLanguages() as $language) {
            $expected = $language;
            $actual = $this->registry->getSupportedOrDefault($language->getCode());

            $this->assertSame($expected, $actual);
        }
    }

    public function testGetSupportedOrDefaultFallsBackToDefaultLanguageForUnknownCode(): void
    {
        $this->assertInstanceOf(
            EnLanguage::class,
            $this->registry->getSupportedOrDefault(self::UNKNOWN_LANGUAGE),
        );
    }

    public function testGetSupportedCodesReturnsCodesOfAllLanguages(): void
    {
        $expected = array_map(
            fn (Language $language): string => $language->getCode(),
            $this->registry->getAllLanguages(),
        );
        $actual = $this->registry->getSupportedCodes();

        $this->assertEqualsCanonicalizing($expected, $actual);
    }

    public function testGetAllLanguagesReturnsLanguageInstances(): void
    {
        $languages = $this->registry->getAllLanguages();

        $this->assertNotEmpty($languages);

        foreach ($languages as $language) {
            $this->assertInstanceOf(Language::class, $language);
        }
    }
}
