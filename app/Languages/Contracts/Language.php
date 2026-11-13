<?php

namespace App\Languages\Contracts;

abstract class Language
{
    public const string CODE = '';

    public function getCode(): string
    {
        return static::CODE;
    }

    abstract public function getIntroductionOrder(): array;

    abstract public function getAllLetters(): array;

    abstract public function getVowels(): array;

    abstract public function getSpecials(): array;

    public function getConsonants(): array
    {
        return array_values(array_diff($this->getAllLetters(), $this->getVowels()));
    }
}
