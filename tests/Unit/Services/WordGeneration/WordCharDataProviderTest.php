<?php

namespace Tests\Unit\Services\WordGeneration;

use App\Enums\Language;
use App\Services\WordGeneration\WordCharDataProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\TestCase;
use Tests\Unit\Services\Providers\CommonDataProvider;

class WordCharDataProviderTest extends TestCase
{
    protected WordCharDataProvider $provider;

    protected const int SINGLE_CHAR_LENGTH = 1;

    protected function setUp(): void
    {
        parent::setUp();
        $this->provider = app(WordCharDataProvider::class);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testGetAllLetters(string $language): void
    {
        $expectedAllLetterChars = $this->getAllLetters($language);
        $allLetterChars = $this->provider->getAllLetters($language);

        $this->assertIsArray($allLetterChars);
        $this->assertEquals(
            $expectedAllLetterChars,
            $allLetterChars,
            "Returned all letters don't match expected set for {$language} language.",
        );
    }

    public function testGetAllLettersWithUnknownLanguage(): void
    {
        $allLetterChars = $this->provider->getAllLetters(Language::Unknown->value);
        $this->assertSame([], $allLetterChars, 'Return value must be empty array for unknown language.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testGetVowels(string $language): void
    {
        $expectedVowelChars = $this->getVowels($language);
        $vowelChars = $this->provider->getVowels($language);

        $this->assertIsArray($vowelChars);
        $this->assertEquals(
            $expectedVowelChars,
            $vowelChars,
            "Returned vowels don't match expected set for {$language} language.",
        );
    }

    public function testGetVowelsWithUnknownLanguage(): void
    {
        $vowelChars = $this->provider->getVowels(Language::Unknown->value);
        $this->assertSame([], $vowelChars, 'Return value must be empty array for unknown language.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testGetConsonants(string $language): void
    {
        $allLetterChars = $this->getAllLetters($language);
        $vowelChars = $this->getVowels($language);

        $expectedConsonantChars = array_diff($allLetterChars, $vowelChars);
        $consonantChars = $this->provider->getConsonants($language);

        $this->assertIsArray($consonantChars);
        $this->assertEquals(
            $expectedConsonantChars,
            $consonantChars,
            "Returned consonants don't match expected set for {$language} language.",
        );
    }

    public function testGetConsonantsWithUnknownLanguage(): void
    {
        $consonantChars = $this->provider->getConsonants(Language::Unknown->value);
        $this->assertSame([], $consonantChars, 'Return value must be empty array for unknown language.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testVowelsAndConsonantsDoNotIntersectAndFormAlphabet(string $language): void
    {
        $vowelChars = $this->provider->getVowels($language);
        $consonantChars = $this->provider->getConsonants($language);
        $allLetters = $this->provider->getAllLetters($language);

        $this->assertEmpty(
            array_intersect($vowelChars, $consonantChars),
            "Vowels and consonants should not have common characters for {$language} language.",
        );

        $this->assertEqualsCanonicalizing(
            $allLetters,
            array_merge($vowelChars, $consonantChars),
            "Merged vowels and consonants should form the complete alphabet without duplicates for {$language} language.",
        );
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testIsPunctuation(string $language): void
    {
        $punctuationChars = WordCharDataProvider::PUNCTUATION;

        foreach ($punctuationChars as $char) {
            $this->assertTrue(
                $this->provider->isPunctuation($char),
                "Character '{$char}' should be recognized as punctuation.",
            );
        }

        $allChars = array_unique(array_merge(
            $this->provider->getAllLetters($language),
            $this->getSpecials($language),
            array_keys(WordCharDataProvider::PAIRED),
            array_values(WordCharDataProvider::PAIRED),
            range('0', '9'),
            ['', ' ', "\n", "\t"],
        ));

        $nonPunctuationChars = array_diff($allChars, $punctuationChars);

        foreach ($nonPunctuationChars as $char) {
            $this->assertFalse(
                $this->provider->isPunctuation($char),
                "Character '{$char}' should not be recognized as punctuation for {$language} language.",
            );
        }
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testSpecialsContainsOnlyOneCharStringsAndNoAlphanumeric(string $language): void
    {
        $specialChars = $this->getSpecials($language);
        $allLetters = $this->provider->getAllLetters($language);
        $digitChars = range('0', '9');
        $forbiddenChars = array_merge($allLetters, $digitChars);

        foreach ($specialChars as $char) {
            $this->assertEquals(
                self::SINGLE_CHAR_LENGTH,
                mb_strlen($char),
                "Special character '{$char}' must be exactly one character long for {$language} language.",
            );
            $this->assertNotContains(
                $char,
                $forbiddenChars,
                "Special character '{$char}' should not be alphanumeric for {$language} language.",
            );
        }
    }

    public function testPairedHasValidStructure(): void
    {
        $pairedChars = WordCharDataProvider::PAIRED;

        $this->assertIsArray($pairedChars);
        $this->assertNotEmpty($pairedChars);

        foreach ($pairedChars as $openingChar => $closingChar) {
            $this->assertIsString($openingChar);
            $this->assertIsString($closingChar);
            $this->assertEquals(
                self::SINGLE_CHAR_LENGTH,
                mb_strlen($openingChar),
                "Opening character '{$openingChar}' must be exactly one character long.",
            );
            $this->assertEquals(
                self::SINGLE_CHAR_LENGTH,
                mb_strlen($closingChar),
                "Closing character '{$closingChar}' must be exactly one character long.",
            );
        }
    }

    private function getAllLetters(string $language): array
    {
        return match ($language) {
            Language::En->value => array_merge(range('a', 'z'), range('A', 'Z')),
            Language::Ru->value => array_merge(
                WordCharDataProvider::LETTERS_LC_RU,
                WordCharDataProvider::LETTERS_UC_RU,
            ),
            default => $this->fail("Unsupported language provided: {$language}."),
        };
    }

    private function getVowels(string $language): array
    {
        return match ($language) {
            Language::En->value => WordCharDataProvider::VOWELS_EN,
            Language::Ru->value => WordCharDataProvider::VOWELS_RU,
            default => $this->fail("Unsupported language provided: {$language}."),
        };
    }

    private function getSpecials(string $language): array
    {
        return match ($language) {
            Language::En->value => WordCharDataProvider::SPECIALS_EN,
            Language::Ru->value => WordCharDataProvider::SPECIALS_RU,
            default => $this->fail("Unsupported language provided: {$language}."),
        };
    }
}
