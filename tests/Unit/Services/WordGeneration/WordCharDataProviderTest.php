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
        $expectedAllLetterChars = match ($language) {
            Language::En->value => array_merge(range('a', 'z'), range('A', 'Z')),
            Language::Ru->value => array_merge(
                WordCharDataProvider::LETTERS_LC_RU,
                WordCharDataProvider::LETTERS_UC_RU,
            ),
            default => $this->fail("Unsupported language provided: {$language}."),
        };

        $allLetterChars = $this->provider->getAllLetters($language);

        $this->assertIsArray($allLetterChars);
        $this->assertEquals(
            $expectedAllLetterChars,
            $allLetterChars,
            "Returned all letters don't match expected set for {$language} language.",
        );
    }

    public function testGetVowels(): void
    {
        $vowelCharsEn = $this->provider->getVowels(Language::En->value);
        $this->assertIsArray($vowelCharsEn);
        $this->assertEquals(WordCharDataProvider::VOWELS_EN, $vowelCharsEn);

        $vowelCharsRu = $this->provider->getVowels(Language::Ru->value);
        $this->assertIsArray($vowelCharsRu);
        $this->assertEquals(WordCharDataProvider::VOWELS_RU, $vowelCharsRu);
    }

    public function testGetVowelsWithUnknownLanguage(): void
    {
        $vowelChars = $this->provider->getVowels(Language::Unknown->value);
        $this->assertSame([], $vowelChars, 'Return value must be empty array for unknown language.');
    }

    public function testGetConsonants(): void
    {
        $consonantCharsEn = $this->provider->getConsonants(Language::En->value);
        $this->assertIsArray($consonantCharsEn);

        $allEnglishLetterChars = array_merge(range('a', 'z'), range('A', 'Z'));
        $expectedConsonantCharsEn = array_diff($allEnglishLetterChars, WordCharDataProvider::VOWELS_EN);
        $this->assertEquals($expectedConsonantCharsEn, $consonantCharsEn);

        $consonantCharsRu = $this->provider->getConsonants(Language::Ru->value);
        $this->assertIsArray($consonantCharsRu);

        $allRussianLetterChars = array_merge(
            WordCharDataProvider::LETTERS_LC_RU,
            WordCharDataProvider::LETTERS_UC_RU,
        );
        $expectedConsonantCharsRu = array_diff($allRussianLetterChars, WordCharDataProvider::VOWELS_RU);
        $this->assertEquals($expectedConsonantCharsRu, $consonantCharsRu);
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

    public function testIsPunctuation(): void
    {
        $punctuationChars = WordCharDataProvider::PUNCTUATION;

        $allChars = array_unique(array_merge(
            ['', ' ', "\n"],
            range('0', '9'),
            range('a', 'z'),
            range('A', 'Z'),
            WordCharDataProvider::LETTERS_LC_RU,
            WordCharDataProvider::LETTERS_UC_RU,
            WordCharDataProvider::SPECIALS_EN,
            WordCharDataProvider::SPECIALS_RU,
            array_keys(WordCharDataProvider::PAIRED),
            array_values(WordCharDataProvider::PAIRED),
        ));

        $nonPunctuationChars = array_diff($allChars, $punctuationChars);

        foreach ($punctuationChars as $char) {
            $this->assertTrue($this->provider->isPunctuation($char));
        }

        foreach ($nonPunctuationChars as $char) {
            $this->assertFalse($this->provider->isPunctuation($char));
        }
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testSpecialsContainsOnlyOneCharStringsAndNoAlphanumeric(string $language): void
    {
        $specialChars = match ($language) {
            Language::En->value => WordCharDataProvider::SPECIALS_EN,
            Language::Ru->value => WordCharDataProvider::SPECIALS_RU,
            default => $this->fail("Unsupported language provided: {$language}."),
        };

        $allLetters = $this->provider->getAllLetters($language);
        $digitChars = range('0', '9');
        $forbiddenChars = array_merge($allLetters, $digitChars);

        foreach ($specialChars as $char) {
            $this->assertEquals(
                self::SINGLE_CHAR_LENGTH,
                mb_strlen($char),
                "Special character {$char} must be exactly one character long for {$language} language.",
            );
            $this->assertNotContains(
                $char,
                $forbiddenChars,
                "Special character {$char} should not be alphanumeric for {$language} language.",
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
                'Opening character must be exactly one character long.',
            );
            $this->assertEquals(
                self::SINGLE_CHAR_LENGTH,
                mb_strlen($closingChar),
                'Closing character must be exactly one character long.',
            );
        }
    }
}
