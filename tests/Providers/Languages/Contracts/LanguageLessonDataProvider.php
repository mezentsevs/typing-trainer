<?php

namespace Tests\Providers\Languages\Contracts;

abstract class LanguageLessonDataProvider
{
    protected const string LANGUAGE_CODE = '';
    protected const string CHARS = '';
    protected const array NEW_CHARS_SEQUENCE = [];

    protected function getLanguageCode(): string
    {
        return static::LANGUAGE_CODE;
    }

    protected function getChars(): string
    {
        return static::CHARS;
    }

    protected function getNewCharsSequence(): array
    {
        return static::NEW_CHARS_SEQUENCE;
    }

    public function provideData(): array
    {
        $data = [];
        $availableChars = '';
        $languageCode = $this->getLanguageCode();
        $chars = $this->getChars();
        $newCharsSequence = $this->getNewCharsSequence();
        $newCharsSequenceCount = count($newCharsSequence);

        foreach ($newCharsSequence as $number => $newChars) {
            if ($availableChars !== $chars) {
                $availableChars .= $newChars;
            }

            $data["{$languageCode}_{$number}"] = [[
                'language' => $languageCode,
                'lessonCount' => $newCharsSequenceCount,
                'lessonNumber' => $number,
                'expectedNewChars' => $newChars,
                'expectedAvailableChars' => $availableChars,
            ]];
        }

        return $data;
    }
}
