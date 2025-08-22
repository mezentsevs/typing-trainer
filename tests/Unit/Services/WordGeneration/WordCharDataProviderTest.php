<?php

namespace Tests\Unit\Services\WordGeneration;

use App\Services\WordGeneration\WordCharDataProvider;
use Tests\TestCase;

class WordCharDataProviderTest extends TestCase
{
    protected WordCharDataProvider $provider;

    protected function setUp(): void
    {
        parent::setUp();
        $this->provider = app(WordCharDataProvider::class);
    }

    public function testGetAllEnglishLetters(): void
    {
        $expectedAllEnglishLetterChars = array_merge(range('a', 'z'), range('A', 'Z'));

        $allEnglishLetterChars = $this->provider->getAllEnglishLetters();

        $this->assertIsArray($allEnglishLetterChars);
        $this->assertEquals($expectedAllEnglishLetterChars, $allEnglishLetterChars);
    }

    public function testGetAllRussianLetters(): void
    {
        $expectedAllRussianLetterChars = array_merge(
            WordCharDataProvider::LETTERS_LC_RU,
            WordCharDataProvider::LETTERS_UC_RU,
        );

        $allRussianLetterChars = $this->provider->getAllRussianLetters();

        $this->assertIsArray($allRussianLetterChars);
        $this->assertEquals($expectedAllRussianLetterChars, $allRussianLetterChars);
    }

    public function testGetVowels(): void
    {
        $vowelCharsEn = $this->provider->getVowels('en');
        $this->assertIsArray($vowelCharsEn);
        $this->assertEquals(WordCharDataProvider::VOWELS_EN, $vowelCharsEn);

        $vowelCharsRu = $this->provider->getVowels('ru');
        $this->assertIsArray($vowelCharsRu);
        $this->assertEquals(WordCharDataProvider::VOWELS_RU, $vowelCharsRu);
    }

    public function testGetConsonants(): void
    {
        $consonantCharsEn = $this->provider->getConsonants('en');
        $this->assertIsArray($consonantCharsEn);

        $allEnglishLetterChars = array_merge(range('a', 'z'), range('A', 'Z'));
        $expectedConsonantCharsEn = array_diff($allEnglishLetterChars, WordCharDataProvider::VOWELS_EN);
        $this->assertEquals($expectedConsonantCharsEn, $consonantCharsEn);

        $consonantCharsRu = $this->provider->getConsonants('ru');
        $this->assertIsArray($consonantCharsRu);

        $allRussianLetterChars = array_merge(
            WordCharDataProvider::LETTERS_LC_RU,
            WordCharDataProvider::LETTERS_UC_RU,
        );
        $expectedConsonantCharsRu = array_diff($allRussianLetterChars, WordCharDataProvider::VOWELS_RU);
        $this->assertEquals($expectedConsonantCharsRu, $consonantCharsRu);
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

    public function testPairedConstantStructure(): void
    {
        $pairedChars = WordCharDataProvider::PAIRED;

        $this->assertIsArray($pairedChars);
        $this->assertNotEmpty($pairedChars);

        foreach ($pairedChars as $openingChar => $closingChar) {
            $this->assertIsString($openingChar);
            $this->assertIsString($closingChar);
            $this->assertEquals(
                WordCharDataProvider::SINGLE_CHAR_LENGTH,
                mb_strlen($openingChar),
                'Opening character must be exactly one character long.',
            );
            $this->assertEquals(
                WordCharDataProvider::SINGLE_CHAR_LENGTH,
                mb_strlen($closingChar),
                'Closing character must be exactly one character long.',
            );
        }
    }
}
