<?php

namespace Tests\Unit\Languages;

use App\Languages\Contracts\Language;
use App\Languages\FrLanguage;
use Tests\Unit\Languages\Contracts\LanguageTestCase;

class FrLanguageTest extends LanguageTestCase
{
    protected function createLanguage(): Language
    {
        return new FrLanguage();
    }

    protected function getExpectedCode(): string
    {
        return FrLanguage::CODE;
    }
}
