<?php

namespace Tests\Providers\Languages\Contracts;

use App\Services\Word\WordGeneration\WordCharDataProvider;

abstract class LanguageWordDataProvider
{
    protected const string LANGUAGE_CODE = '';
    protected const array AVAILABLE_CHARS = [];
    protected const array NEW_CHARS = [];
    protected const string PAIRED_BASE_CHAR = '';

    abstract protected function getSpecials(): array;

    protected function getLanguageCode(): string
    {
        return static::LANGUAGE_CODE;
    }

    protected function getAvailableChars(): array
    {
        return static::AVAILABLE_CHARS;
    }

    protected function getNewChars(): array
    {
        return static::NEW_CHARS;
    }

    protected function getPairedBaseChar(): string
    {
        return static::PAIRED_BASE_CHAR;
    }

    public function provideWordGenerationData(): array
    {
        $languageCode = $this->getLanguageCode();

        return [
            $languageCode => [[
                'availableChars' => $this->getAvailableChars(),
                'newChars' => $this->getNewChars(),
                'language' => $languageCode,
            ]],
        ];
    }

    public function providePairedCharsData(): array
    {
        $data = [];
        $languageCode = $this->getLanguageCode();
        $specials = $this->getSpecials();
        $pairedBaseChar = $this->getPairedBaseChar();

        foreach (WordCharDataProvider::PAIRED as $openingChar => $closingChar) {
            if (in_array($openingChar, $specials, true) &&
                in_array($closingChar, $specials, true)) {
                $chars = [$pairedBaseChar, $openingChar, $closingChar];

                $data["{$languageCode} {$openingChar}{$closingChar}"] = [[
                    'availableChars' => $chars,
                    'newChars' => $chars,
                    'language' => $languageCode,
                    'openingChar' => $openingChar,
                    'closingChar' => $closingChar,
                ]];
            }
        }

        return $data;
    }
}
