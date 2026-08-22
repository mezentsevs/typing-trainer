<?php

namespace Tests\Unit\Languages;

use App\Languages\Contracts\Language;
use App\Languages\PlLanguage;
use Tests\Unit\Languages\Contracts\LanguageTestCase;

class PlLanguageTest extends LanguageTestCase
{
    protected function createLanguage(): Language
    {
        return new PlLanguage();
    }

    protected function getExpectedCode(): string
    {
        return PlLanguage::CODE;
    }
}
