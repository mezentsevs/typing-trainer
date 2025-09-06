<?php

namespace Tests\Unit\Services\WordGeneration;

use App\Enums\Language;
use App\Services\WordGeneration\WordCharDataProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Providers\CommonDataProvider;
use Tests\TestCase;

class WordCharDataProviderTest extends TestCase
{
    protected WordCharDataProvider $provider;

    private const int EXPECTED_SINGLE_CHAR_LENGTH = 1;

    private const int EXPECTED_MIN_LETTERS_PART_LENGTH = 3;
    private const int EXPECTED_MAX_LETTERS_PART_LENGTH = 8;
    private const int EXPECTED_RANDOM_MIN_VALUE = 0;
    private const int EXPECTED_RANDOM_MAX_VALUE = 99;
    private const int EXPECTED_DIGIT_USAGE_CHANCE = 30;
    private const int EXPECTED_NEW_CHAR_USAGE_CHANCE = 70;
    private const int EXPECTED_BINARY_CHOICE_MIN = 0;
    private const int EXPECTED_BINARY_CHOICE_MAX = 1;
    private const int EXPECTED_BINARY_CHOICE_DEFAULT = 0;

    private const string EXPECTED_CHAR_TYPE_VOWEL = 'V';
    private const string EXPECTED_CHAR_TYPE_CONSONANT = 'C';

    protected function setUp(): void
    {
        parent::setUp();
        $this->provider = app(WordCharDataProvider::class);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLanguageConstantsHaveValidStructure(string $language): void
    {
        $constants = $this->getLanguageConstants($language);

        foreach ($constants as $constantName => $constantValue) {
            $this->assertIsArray($constantValue);
            $this->assertNotEmpty($constantValue);

            foreach ($constantValue as $char) {
                $this->assertIsString($char);
                $this->assertEquals(
                    self::EXPECTED_SINGLE_CHAR_LENGTH,
                    mb_strlen($char),
                    "Character '{$char}' in constant {$constantName} must be exactly one character long for {$language} language.",
                );
            }
        }
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLanguageConstantsHaveUniqueElements(string $language): void
    {
        $constants = $this->getLanguageConstants($language);

        foreach ($constants as $constantName => $constantValue) {
            $uniqueConstantValueElements = array_unique($constantValue);
            $this->assertEquals(
                count($uniqueConstantValueElements),
                count($constantValue),
                "Constant {$constantName} contains duplicate elements for {$language} language.",
            );
        }
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testSpecialsConstantsContainsNoAlphanumeric(string $language): void
    {
        $specialChars = $this->getSpecials($language);
        $allLetters = $this->provider->getAllLetters($language);
        $digitChars = range('0', '9');
        $forbiddenChars = array_merge($allLetters, $digitChars);

        foreach ($specialChars as $char) {
            $this->assertNotContains(
                $char,
                $forbiddenChars,
                "Special character '{$char}' should not be alphanumeric for {$language} language.",
            );
        }
    }

    public function testPairedConstantHasValidStructure(): void
    {
        $pairedChars = WordCharDataProvider::PAIRED;

        $this->assertIsArray($pairedChars);
        $this->assertNotEmpty($pairedChars);

        foreach ($pairedChars as $openingChar => $closingChar) {
            $this->assertIsString($openingChar);
            $this->assertIsString($closingChar);
            $this->assertEquals(
                self::EXPECTED_SINGLE_CHAR_LENGTH,
                mb_strlen($openingChar),
                "Opening character '{$openingChar}' must be exactly one character long.",
            );
            $this->assertEquals(
                self::EXPECTED_SINGLE_CHAR_LENGTH,
                mb_strlen($closingChar),
                "Closing character '{$closingChar}' must be exactly one character long.",
            );
        }
    }

    public function testPairedConstantHasUniqueValues(): void
    {
        $pairedChars = WordCharDataProvider::PAIRED;
        $pairedCharsValues = array_values($pairedChars);
        $uniquePairedCharsValues = array_unique($pairedCharsValues);

        $this->assertEquals(
            count($uniquePairedCharsValues),
            count($pairedCharsValues),
            'Constant PAIRED contains duplicate values.',
        );
    }

    public function testPunctuationConstantHasValidStructure(): void
    {
        $punctuationChars = WordCharDataProvider::PUNCTUATION;

        $this->assertIsArray($punctuationChars);
        $this->assertNotEmpty($punctuationChars);

        foreach ($punctuationChars as $char) {
            $this->assertIsString($char);
            $this->assertEquals(
                self::EXPECTED_SINGLE_CHAR_LENGTH,
                mb_strlen($char),
                "Punctuation character '{$char}' must be exactly one character long.",
            );
        }
    }

    public function testPunctuationConstantHasUniqueElements(): void
    {
        $punctuationChars = WordCharDataProvider::PUNCTUATION;
        $uniquePunctuationChars = array_unique($punctuationChars);

        $this->assertEquals(
            count($uniquePunctuationChars),
            count($punctuationChars),
            'Constant PUNCTUATION contains duplicate elements.',
        );
    }

    public function testScalarConstantsHaveExpectedValues(): void
    {
        $expectedConstants = [
            'MIN_LETTERS_PART_LENGTH' => self::EXPECTED_MIN_LETTERS_PART_LENGTH,
            'MAX_LETTERS_PART_LENGTH' => self::EXPECTED_MAX_LETTERS_PART_LENGTH,
            'RANDOM_MIN_VALUE' => self::EXPECTED_RANDOM_MIN_VALUE,
            'RANDOM_MAX_VALUE' => self::EXPECTED_RANDOM_MAX_VALUE,
            'DIGIT_USAGE_CHANCE' => self::EXPECTED_DIGIT_USAGE_CHANCE,
            'NEW_CHAR_USAGE_CHANCE' => self::EXPECTED_NEW_CHAR_USAGE_CHANCE,
            'BINARY_CHOICE_MIN' => self::EXPECTED_BINARY_CHOICE_MIN,
            'BINARY_CHOICE_MAX' => self::EXPECTED_BINARY_CHOICE_MAX,
            'BINARY_CHOICE_DEFAULT' => self::EXPECTED_BINARY_CHOICE_DEFAULT,

            'CHAR_TYPE_VOWEL' => self::EXPECTED_CHAR_TYPE_VOWEL,
            'CHAR_TYPE_CONSONANT' => self::EXPECTED_CHAR_TYPE_CONSONANT,
        ];

        foreach ($expectedConstants as $constantName => $expectedConstantValue) {
            $this->assertEquals(
                $expectedConstantValue,
                constant(WordCharDataProvider::class . "::{$constantName}"),
                "Constant {$constantName} has unexpected value.",
            );
        }
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
        $this->assertEquals([], $allLetterChars, 'Return value must be empty array for unknown language.');
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
        $this->assertEquals([], $vowelChars, 'Return value must be empty array for unknown language.');
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
        $this->assertEquals([], $consonantChars, 'Return value must be empty array for unknown language.');
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
                "Character '{$char}' should be recognized as punctuation for {$language} language.",
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

    private function getLanguageConstants(string $language): array
    {
        return match ($language) {
            Language::En->value => [
                'VOWELS_EN' => WordCharDataProvider::VOWELS_EN,
                'SPECIALS_EN' => WordCharDataProvider::SPECIALS_EN,
            ],
            Language::Ru->value => [
                'LETTERS_LC_RU' => WordCharDataProvider::LETTERS_LC_RU,
                'LETTERS_UC_RU' => WordCharDataProvider::LETTERS_UC_RU,
                'VOWELS_RU' => WordCharDataProvider::VOWELS_RU,
                'SPECIALS_RU' => WordCharDataProvider::SPECIALS_RU,
            ],
            default => $this->failUnsupportedLanguage($language),
        };
    }

    private function getAllLetters(string $language): array
    {
        return match ($language) {
            Language::En->value => array_merge(range('a', 'z'), range('A', 'Z')),
            Language::Ru->value => array_merge(
                WordCharDataProvider::LETTERS_LC_RU,
                WordCharDataProvider::LETTERS_UC_RU,
            ),
            default => $this->failUnsupportedLanguage($language),
        };
    }

    private function getVowels(string $language): array
    {
        return match ($language) {
            Language::En->value => WordCharDataProvider::VOWELS_EN,
            Language::Ru->value => WordCharDataProvider::VOWELS_RU,
            default => $this->failUnsupportedLanguage($language),
        };
    }

    private function getSpecials(string $language): array
    {
        return match ($language) {
            Language::En->value => WordCharDataProvider::SPECIALS_EN,
            Language::Ru->value => WordCharDataProvider::SPECIALS_RU,
            default => $this->failUnsupportedLanguage($language),
        };
    }

    private function failUnsupportedLanguage(string $language): never
    {
        $this->fail("Unsupported language provided: {$language}.");
    }
}
