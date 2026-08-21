<?php

namespace Tests\Unit\Languages\Contracts;

use App\Languages\Contracts\Language;
use Tests\TestCase;
use Tests\Traits\Assertions\WithCharacterAssertions;

abstract class LanguageTestCase extends TestCase
{
    use WithCharacterAssertions;

    protected Language $language;

    abstract protected function createLanguage(): Language;

    abstract protected function getExpectedCode(): string;

    protected function setUp(): void
    {
        parent::setUp();

        $this->language = $this->createLanguage();
    }

    public function testGetCodeReturnsExpectedCode(): void
    {
        $expected = $this->getExpectedCode();
        $actual = $this->language->getCode();

        $this->assertEquals($expected, $actual);
    }

    public function testGetIntroductionOrderReturnsArrayOfSingleCharacterStrings(): void
    {
        $this->assertArrayOfSingleCharacterStrings($this->language->getIntroductionOrder());
    }

    public function testGetAllLettersReturnsArrayOfSingleCharacterStrings(): void
    {
        $this->assertArrayOfSingleCharacterStrings($this->language->getAllLetters());
    }

    public function testGetAllLettersReturnsUniqueCharacters(): void
    {
        $this->assertUniqueCharacters($this->language->getAllLetters());
    }

    public function testGetVowelsReturnsArrayOfSingleCharacterStrings(): void
    {
        $this->assertArrayOfSingleCharacterStrings($this->language->getVowels());
    }

    public function testGetVowelsReturnsUniqueCharacters(): void
    {
        $this->assertUniqueCharacters($this->language->getVowels());
    }

    public function testGetConsonantsReturnsArrayOfSingleCharacterStrings(): void
    {
        $this->assertArrayOfSingleCharacterStrings($this->language->getConsonants());
    }

    public function testGetConsonantsReturnsUniqueCharacters(): void
    {
        $this->assertUniqueCharacters($this->language->getConsonants());
    }

    public function testVowelsAndConsonantsDoNotIntersectAndFormAllLetters(): void
    {
        $vowels = $this->language->getVowels();
        $consonants = $this->language->getConsonants();
        $allLetters = $this->language->getAllLetters();

        $this->assertEmpty(
            array_intersect($vowels, $consonants),
            'Vowels and consonants should not have common characters.',
        );

        $expected = $allLetters;
        $actual = array_merge($vowels, $consonants);

        $this->assertEqualsCanonicalizing(
            $expected,
            $actual,
            'Merged vowels and consonants should form the complete alphabet.',
        );
    }

    public function testGetSpecialsReturnsArrayOfSingleCharacterStrings(): void
    {
        $this->assertArrayOfSingleCharacterStrings($this->language->getSpecials());
    }

    public function testGetSpecialsReturnsUniqueCharacters(): void
    {
        $this->assertUniqueCharacters($this->language->getSpecials());
    }

    public function testGetSpecialsContainNoAlphanumericCharacters(): void
    {
        $specials = $this->language->getSpecials();
        $allLetters = $this->language->getAllLetters();
        $digits = range('0', '9');
        $alphanumeric = array_merge($allLetters, $digits);

        foreach ($specials as $char) {
            $this->assertNotContains(
                $char,
                $alphanumeric,
                "Special character '{$char}' should not be alphanumeric.",
            );
        }
    }
}
