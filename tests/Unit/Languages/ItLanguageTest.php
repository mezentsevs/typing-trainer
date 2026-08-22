<?php

namespace Tests\Unit\Languages;

use App\Languages\Contracts\Language;
use App\Languages\ItLanguage;
use Tests\Unit\Languages\Contracts\LanguageTestCase;

class ItLanguageTest extends LanguageTestCase
{
    protected function createLanguage(): Language
    {
        return new ItLanguage();
    }

    protected function getExpectedCode(): string
    {
        return ItLanguage::CODE;
    }
}
