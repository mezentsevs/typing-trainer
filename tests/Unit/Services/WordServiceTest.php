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
        $expectedAllEnglishLetters = array_merge(range('a', 'z'), range('A', 'Z'));

        $getAllEnglishLettersMethod = $this->reflection->getMethod('getAllEnglishLetters');
        $getAllEnglishLettersMethod->setAccessible(true);

        $allEnglishLetters = $getAllEnglishLettersMethod->invoke($this->service);

        $this->assertIsArray($allEnglishLetters);
        $this->assertEquals($expectedAllEnglishLetters, $allEnglishLetters);
    }

    public function testGetAllRussianLetters(): void
    {
        $expectedAllRussianLetters = array_merge(
            $this->reflection->getConstant('LETTERS_LC_RU'),
            $this->reflection->getConstant('LETTERS_UC_RU'),
        );

        $getAllRussianLettersMethod = $this->reflection->getMethod('getAllRussianLetters');
        $getAllRussianLettersMethod->setAccessible(true);

        $allRussianLetters = $getAllRussianLettersMethod->invoke($this->service);

        $this->assertIsArray($allRussianLetters);
        $this->assertEquals($expectedAllRussianLetters, $allRussianLetters);
    }

    public function testGetVowels(): void
    {
        $getVowelsMethod = $this->reflection->getMethod('getVowels');
        $getVowelsMethod->setAccessible(true);

        $vowelsEn = $getVowelsMethod->invoke($this->service, 'en');
        $this->assertIsArray($vowelsEn);
        $this->assertEquals($this->reflection->getConstant('VOWELS_EN'), $vowelsEn);

        $vowelsRu = $getVowelsMethod->invoke($this->service, 'ru');
        $this->assertIsArray($vowelsRu);
        $this->assertEquals($this->reflection->getConstant('VOWELS_RU'), $vowelsRu);
    }

    public function testGetConsonants(): void
    {
        $getConsonantsMethod = $this->reflection->getMethod('getConsonants');
        $getConsonantsMethod->setAccessible(true);

        $consonantsEn = $getConsonantsMethod->invoke($this->service, 'en');
        $this->assertIsArray($consonantsEn);

        $allEnglishLetters = array_merge(range('a', 'z'), range('A', 'Z'));
        $expectedConsonantsEn = array_diff($allEnglishLetters, $this->reflection->getConstant('VOWELS_EN'));
        $this->assertEquals($expectedConsonantsEn, $consonantsEn);

        $consonantsRu = $getConsonantsMethod->invoke($this->service, 'ru');
        $this->assertIsArray($consonantsRu);

        $allRussianLetters = array_merge(
            $this->reflection->getConstant('LETTERS_LC_RU'),
            $this->reflection->getConstant('LETTERS_UC_RU'),
        );
        $expectedConsonantsRu = array_diff($allRussianLetters, $this->reflection->getConstant('VOWELS_RU'));
        $this->assertEquals($expectedConsonantsRu, $consonantsRu);
    }

    public function testIsPunctuation(): void
    {
        $isPunctuationMethod = $this->reflection->getMethod('isPunctuation');
        $isPunctuationMethod->setAccessible(true);

        $punctuation = $this->reflection->getConstant('PUNCTUATION');

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

        $nonPunctuation = array_diff($allChars, $punctuation);

        foreach ($punctuation as $char) {
            $this->assertTrue($isPunctuationMethod->invoke($this->service, $char));
        }

        foreach ($nonPunctuation as $char) {
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
