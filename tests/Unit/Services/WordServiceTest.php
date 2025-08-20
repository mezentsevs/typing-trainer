<?php

namespace Tests\Unit\Services;

use App\Services\WordService;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use ReflectionClass;
use Tests\TestCase;
use Tests\Unit\Services\Providers\WordDataProvider;

class WordServiceTest extends TestCase
{
    protected WordService $service;

    protected ReflectionClass $reflection;

    protected const MAX_EXTRA_SPECIAL_CHARS_COUNT = 2;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new WordService();
        $this->reflection = new ReflectionClass($this->service);
    }

    public function testGetAllEnglishLetters(): void
    {
        $expectedAllEnglishLetterChars = array_merge(range('a', 'z'), range('A', 'Z'));

        $getAllEnglishLettersMethod = $this->reflection->getMethod('getAllEnglishLetters');
        $getAllEnglishLettersMethod->setAccessible(true);

        $allEnglishLetterChars = $getAllEnglishLettersMethod->invoke($this->service);

        $this->assertIsArray($allEnglishLetterChars);
        $this->assertEquals($expectedAllEnglishLetterChars, $allEnglishLetterChars);
    }

    public function testGetAllRussianLetters(): void
    {
        $expectedAllRussianLetterChars = array_merge(
            $this->reflection->getConstant('LETTERS_LC_RU'),
            $this->reflection->getConstant('LETTERS_UC_RU'),
        );

        $getAllRussianLettersMethod = $this->reflection->getMethod('getAllRussianLetters');
        $getAllRussianLettersMethod->setAccessible(true);

        $allRussianLetterChars = $getAllRussianLettersMethod->invoke($this->service);

        $this->assertIsArray($allRussianLetterChars);
        $this->assertEquals($expectedAllRussianLetterChars, $allRussianLetterChars);
    }

    public function testGetVowels(): void
    {
        $getVowelsMethod = $this->reflection->getMethod('getVowels');
        $getVowelsMethod->setAccessible(true);

        $vowelCharsEn = $getVowelsMethod->invoke($this->service, 'en');
        $this->assertIsArray($vowelCharsEn);
        $this->assertEquals($this->reflection->getConstant('VOWELS_EN'), $vowelCharsEn);

        $vowelCharsRu = $getVowelsMethod->invoke($this->service, 'ru');
        $this->assertIsArray($vowelCharsRu);
        $this->assertEquals($this->reflection->getConstant('VOWELS_RU'), $vowelCharsRu);
    }

    public function testGetConsonants(): void
    {
        $getConsonantsMethod = $this->reflection->getMethod('getConsonants');
        $getConsonantsMethod->setAccessible(true);

        $consonantCharsEn = $getConsonantsMethod->invoke($this->service, 'en');
        $this->assertIsArray($consonantCharsEn);

        $allEnglishLetterChars = array_merge(range('a', 'z'), range('A', 'Z'));
        $expectedConsonantCharsEn = array_diff($allEnglishLetterChars, $this->reflection->getConstant('VOWELS_EN'));
        $this->assertEquals($expectedConsonantCharsEn, $consonantCharsEn);

        $consonantCharsRu = $getConsonantsMethod->invoke($this->service, 'ru');
        $this->assertIsArray($consonantCharsRu);

        $allRussianLetterChars = array_merge(
            $this->reflection->getConstant('LETTERS_LC_RU'),
            $this->reflection->getConstant('LETTERS_UC_RU'),
        );
        $expectedConsonantCharsRu = array_diff($allRussianLetterChars, $this->reflection->getConstant('VOWELS_RU'));
        $this->assertEquals($expectedConsonantCharsRu, $consonantCharsRu);
    }

    public function testIsPunctuation(): void
    {
        $isPunctuationMethod = $this->reflection->getMethod('isPunctuation');
        $isPunctuationMethod->setAccessible(true);

        $punctuationChars = $this->reflection->getConstant('PUNCTUATION');

        $allChars = array_unique(array_merge(
            ['', ' ', "\n"],
            range('0', '9'),
            range('a', 'z'),
            range('A', 'Z'),
            $this->reflection->getConstant('LETTERS_LC_RU'),
            $this->reflection->getConstant('LETTERS_UC_RU'),
            $this->reflection->getConstant('SPECIALS_EN'),
            $this->reflection->getConstant('SPECIALS_RU'),
            array_keys($this->reflection->getConstant('PAIRED')),
            array_values($this->reflection->getConstant('PAIRED')),
        ));

        $nonPunctuationChars = array_diff($allChars, $punctuationChars);

        foreach ($punctuationChars as $char) {
            $this->assertTrue($isPunctuationMethod->invoke($this->service, $char));
        }

        foreach ($nonPunctuationChars as $char) {
            $this->assertFalse($isPunctuationMethod->invoke($this->service, $char));
        }
    }

    #[DataProviderExternal(WordDataProvider::class, 'provideWordGenerationData')]
    public function testGeneratedWordHasValidLength(array $data): void
    {
        $word = $this->service->generateWord($data['availableChars'], $data['newChars'], $data['language']);
        $wordLength = mb_strlen($word);

        $this->assertIsString($word);
        $this->assertNotEmpty($word);
        $this->assertGreaterThanOrEqual(
            $this->reflection->getConstant('MIN_LETTERS_PART_LENGTH'),
            $wordLength,
            "Word '{$word}' in language {$data['language']} is too short.",
        );
        $this->assertLessThanOrEqual(
            $this->reflection->getConstant('MAX_LETTERS_PART_LENGTH') + self::MAX_EXTRA_SPECIAL_CHARS_COUNT,
            $wordLength,
            "Word '{$word}' in language {$data['language']} is too long.",
        );
    }

    #[DataProviderExternal(WordDataProvider::class, 'provideWordGenerationData')]
    public function testGeneratedWordContainsOnlyAvailableChars(array $data): void
    {
        $word = $this->service->generateWord($data['availableChars'], $data['newChars'], $data['language']);

        $this->assertIsString($word);
        $this->assertNotEmpty($word);

        foreach (mb_str_split($word) as $char) {
            $this->assertContains(
                $char,
                $data['availableChars'],
                "Generated word contains invalid character '{$char}'. Available characters: " . implode(', ', $data['availableChars']) . '.',
            );
        }
    }
}
