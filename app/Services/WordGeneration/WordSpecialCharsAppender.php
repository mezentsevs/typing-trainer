<?php

namespace App\Services\WordGeneration;

class WordSpecialCharsAppender
{
    public function __construct(protected WordCharDataProvider $wordCharDataProvider)
    {
    }

    public function addSpecialChars(string $lettersPart, array $availableChars, string $language): string
    {
        if (empty($lettersPart)) {
            return '';
        }

        $availableSpecialChars = $this->filterSpecialChars($availableChars, $language);
        $specialCharType = $this->determineSpecialCharType($availableSpecialChars);

        if ($specialCharType === 'none') {
            return $lettersPart;
        }

        if ($specialCharType === 'single') {
            return $this->addSingleSpecialChar($lettersPart, $availableSpecialChars);
        }

        return $this->addPairedSpecialChars($lettersPart, $availableSpecialChars);
    }

    protected function filterSpecialChars(array $availableChars, string $language): array
    {
        $allowedSpecialChars = match ($language) {
            'en' => WordCharDataProvider::SPECIALS_EN,
            'ru' => WordCharDataProvider::SPECIALS_RU,
            default => [],
        };

        return array_filter($availableChars, function ($char) use ($allowedSpecialChars) {
            return in_array($char, $allowedSpecialChars, true);
        });
    }

    protected function determineSpecialCharType(array $availableSpecialChars): string
    {
        $singleSpecialChars = $this->getSingleSpecialChars($availableSpecialChars);
        $availableOpeningPairedChars = $this->getAvailableOpeningPairedChars($availableSpecialChars);

        $totalOptions = ['none'];

        if (!empty($singleSpecialChars)) {
            $totalOptions[] = 'single';
        }

        if (!empty($availableOpeningPairedChars)) {
            $totalOptions[] = 'paired';
        }

        return $totalOptions[array_rand($totalOptions)];
    }

    protected function getSingleSpecialChars(array $availableSpecialChars): array
    {
        $pairedSymbolChars = array_merge(
            array_keys(WordCharDataProvider::PAIRED),
            array_values(WordCharDataProvider::PAIRED),
        );

        return array_diff($availableSpecialChars, $pairedSymbolChars);
    }

    protected function getAvailableOpeningPairedChars(array $availableSpecialChars): array
    {
        $availableOpeningPairedChars = array_intersect(
            array_keys(WordCharDataProvider::PAIRED),
            $availableSpecialChars,
        );

        return array_filter($availableOpeningPairedChars, function ($openingChar) use ($availableSpecialChars) {
            return in_array(WordCharDataProvider::PAIRED[$openingChar], $availableSpecialChars, true);
        });
    }

    protected function addSingleSpecialChar(string $lettersPart, array $availableSpecialChars): string
    {
        $singleSpecialChars = $this->getSingleSpecialChars($availableSpecialChars);
        $specialChar = $singleSpecialChars[array_rand($singleSpecialChars)];

        if ($this->wordCharDataProvider->isPunctuation($specialChar)) {
            return $lettersPart . $specialChar;
        }

        $position = rand(
            WordCharDataProvider::BINARY_CHOICE_MIN,
            WordCharDataProvider::BINARY_CHOICE_MAX,
        ) === WordCharDataProvider::BINARY_CHOICE_DEFAULT ? 'start' : 'end';

        return $position === 'start' ? $specialChar . $lettersPart : $lettersPart . $specialChar;
    }

    protected function addPairedSpecialChars(string $lettersPart, array $availableSpecialChars): string
    {
        $availableOpeningPairedChars = $this->getAvailableOpeningPairedChars($availableSpecialChars);
        $openingChar = $availableOpeningPairedChars[array_rand($availableOpeningPairedChars)];
        $closingChar = WordCharDataProvider::PAIRED[$openingChar];

        return $openingChar . $lettersPart . $closingChar;
    }
}
