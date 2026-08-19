<?php

namespace App\Languages\Contracts;

abstract class Language
{
    abstract public function getCode(): string;

    abstract public function getIntroductionOrder(): array;

    abstract public function getAllLetters(): array;

    abstract public function getVowels(): array;

    abstract public function getSpecials(): array;

    public function getConsonants(): array
    {
        return array_values(array_diff($this->getAllLetters(), $this->getVowels()));
    }
}
