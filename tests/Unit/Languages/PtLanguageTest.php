<?php

namespace Tests\Unit\Languages;

use App\Languages\Contracts\Language;
use App\Languages\PtLanguage;
use Tests\Unit\Languages\Contracts\LanguageTestCase;

class PtLanguageTest extends LanguageTestCase
{
    protected function createLanguage(): Language
    {
        return new PtLanguage();
    }

    protected function getExpectedCode(): string
    {
        return PtLanguage::CODE;
    }
}
