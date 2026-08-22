<?php

namespace Tests\Unit\Languages;

use App\Languages\Contracts\Language;
use App\Languages\TrLanguage;
use Tests\Unit\Languages\Contracts\LanguageTestCase;

class TrLanguageTest extends LanguageTestCase
{
    protected function createLanguage(): Language
    {
        return new TrLanguage();
    }

    protected function getExpectedCode(): string
    {
        return TrLanguage::CODE;
    }
}
