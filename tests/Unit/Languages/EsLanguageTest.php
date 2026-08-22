<?php

namespace Tests\Unit\Languages;

use App\Languages\Contracts\Language;
use App\Languages\EsLanguage;
use Tests\Unit\Languages\Contracts\LanguageTestCase;

class EsLanguageTest extends LanguageTestCase
{
    protected function createLanguage(): Language
    {
        return new EsLanguage();
    }

    protected function getExpectedCode(): string
    {
        return EsLanguage::CODE;
    }
}
