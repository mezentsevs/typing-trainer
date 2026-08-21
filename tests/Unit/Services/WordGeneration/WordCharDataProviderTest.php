<?php

namespace Tests\Unit\Services\WordGeneration;

use App\Languages\Registry\LanguageRegistry;
use App\Services\Word\WordGeneration\WordCharDataProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Providers\CommonDataProvider;
use Tests\TestCase;
use Tests\Traits\Assertions\WithCharacterAssertions;
use Tests\Traits\Constants\WithLanguageRegistryConstants;
use Tests\Traits\Constants\WithWordCharDataProviderConstants;
use Tests\Traits\WithCharacter;

class WordCharDataProviderTest extends TestCase
{
    use WithCharacter,
        WithCharacterAssertions,
        WithLanguageRegistryConstants,
        WithWordCharDataProviderConstants;

    protected WordCharDataProvider $provider;
    protected LanguageRegistry $languageRegistry;

    protected function setUp(): void
    {
        parent::setUp();

        $this->provider = app(WordCharDataProvider::class);
        $this->languageRegistry = app(LanguageRegistry::class);
    }

    public function testPairedConstantHasValidStructure(): void
    {
        $paired = WordCharDataProvider::PAIRED;

        $this->assertIsArray($paired);
        $this->assertNotEmpty($paired);

        foreach ($paired as $opening => $closing) {
            $this->assertSingleCharacterString($opening);
            $this->assertSingleCharacterString($closing);
        }
    }

    public function testPairedConstantHasUniqueValues(): void
    {
        $this->assertUniqueCharacters(
            array_values(WordCharDataProvider::PAIRED),
            'Constant PAIRED should be unique.',
        );
    }

    public function testPunctuationConstantHasValidStructure(): void
    {
        $this->assertArrayOfSingleCharacterStrings(WordCharDataProvider::PUNCTUATION);
    }

    public function testPunctuationConstantHasUniqueValues(): void
    {
        $this->assertUniqueCharacters(
            WordCharDataProvider::PUNCTUATION,
            'Constant PUNCTUATION should be unique.',
        );
    }

    public function testScalarConstantsHaveExpectedValues(): void
    {
        $constants = [
            'MAX_LETTERS_PART_LENGTH' => self::EXPECTED_MAX_LETTERS_PART_LENGTH,
            'MIN_LETTERS_PART_LENGTH' => self::EXPECTED_MIN_LETTERS_PART_LENGTH,

            'RANDOM_MAX_VALUE' => self::EXPECTED_RANDOM_MAX_VALUE,
            'RANDOM_MIN_VALUE' => self::EXPECTED_RANDOM_MIN_VALUE,

            'DIGIT_USAGE_CHANCE' => self::EXPECTED_DIGIT_USAGE_CHANCE,
            'NEW_CHAR_USAGE_CHANCE' => self::EXPECTED_NEW_CHAR_USAGE_CHANCE,

            'BINARY_CHOICE_DEFAULT' => self::EXPECTED_BINARY_CHOICE_DEFAULT,
            'BINARY_CHOICE_MAX' => self::EXPECTED_BINARY_CHOICE_MAX,
            'BINARY_CHOICE_MIN' => self::EXPECTED_BINARY_CHOICE_MIN,

            'CHAR_TYPE_CONSONANT' => self::EXPECTED_CHAR_TYPE_CONSONANT,
            'CHAR_TYPE_VOWEL' => self::EXPECTED_CHAR_TYPE_VOWEL,
        ];

        foreach ($constants as $name => $expectedValue) {
            $actualValue = constant(WordCharDataProvider::class . "::{$name}");

            $this->assertEquals(
                $expectedValue,
                $actualValue,
                "Constant {$name} should match expected value.",
            );
        }
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testGetAllLetters(string $language): void
    {
        $expected = $this->languageRegistry
            ->getSupportedOrDefault($language)
            ->getAllLetters();
        $actual = $this->provider->getAllLetters($language);

        $this->assertIsArray($actual);
        $this->assertEquals(
            $expected,
            $actual,
            "Returned all letters don't match expected set for {$language} language.",
        );
    }

    public function testGetAllLettersWithUnknownLanguage(): void
    {
        $expected = $this->languageRegistry
            ->getSupportedOrDefault(self::UNKNOWN_LANGUAGE)
            ->getAllLetters();
        $actual = $this->provider->getAllLetters(self::UNKNOWN_LANGUAGE);

        $this->assertEquals(
            $expected,
            $actual,
            'Return value must fall back to default language for unknown language.',
        );
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testGetVowels(string $language): void
    {
        $expected = $this->languageRegistry
            ->getSupportedOrDefault($language)
            ->getVowels();
        $actual = $this->provider->getVowels($language);

        $this->assertIsArray($actual);
        $this->assertEquals(
            $expected,
            $actual,
            "Returned vowels don't match expected set for {$language} language.",
        );
    }

    public function testGetVowelsWithUnknownLanguage(): void
    {
        $expected = $this->languageRegistry
            ->getSupportedOrDefault(self::UNKNOWN_LANGUAGE)
            ->getVowels();
        $actual = $this->provider->getVowels(self::UNKNOWN_LANGUAGE);

        $this->assertEquals(
            $expected,
            $actual,
            'Return value must fall back to default language for unknown language.',
        );
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testGetConsonants(string $language): void
    {
        $expected = $this->languageRegistry
            ->getSupportedOrDefault($language)
            ->getConsonants();
        $actual = $this->provider->getConsonants($language);

        $this->assertIsArray($actual);
        $this->assertEquals(
            $expected,
            $actual,
            "Returned consonants don't match expected set for {$language} language.",
        );
    }

    public function testGetConsonantsWithUnknownLanguage(): void
    {
        $expected = $this->languageRegistry
            ->getSupportedOrDefault(self::UNKNOWN_LANGUAGE)
            ->getConsonants();
        $actual = $this->provider->getConsonants(self::UNKNOWN_LANGUAGE);

        $this->assertEquals(
            $expected,
            $actual,
            'Return value must fall back to default language for unknown language.',
        );
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testVowelsAndConsonantsDoNotIntersectAndFormAlphabet(string $language): void
    {
        $vowels = $this->provider->getVowels($language);
        $consonants = $this->provider->getConsonants($language);
        $allLetters = $this->provider->getAllLetters($language);

        $this->assertEmpty(
            array_intersect($vowels, $consonants),
            "Vowels and consonants should not have common characters for {$language} language.",
        );

        $this->assertEqualsCanonicalizing(
            $allLetters,
            array_merge($vowels, $consonants),
            "Merged vowels and consonants should form the complete alphabet without duplicates for {$language} language.",
        );
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testIsPunctuation(string $language): void
    {
        $punctuation = WordCharDataProvider::PUNCTUATION;

        foreach ($punctuation as $char) {
            $this->assertTrue(
                $this->provider->isPunctuation($char),
                "Character '{$char}' should be recognized as punctuation for {$language} language.",
            );
        }

        $nonPunctuation = $this->getNonPunctuation($language);

        foreach ($nonPunctuation as $char) {
            $this->assertFalse(
                $this->provider->isPunctuation($char),
                "Character '{$char}' should not be recognized as punctuation for {$language} language.",
            );
        }
    }
}
