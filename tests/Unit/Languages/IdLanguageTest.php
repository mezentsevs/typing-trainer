<?php

namespace Tests\Unit\Languages;

use App\Languages\Contracts\Language;
use App\Languages\IdLanguage;
use Tests\Unit\Languages\Contracts\LanguageTestCase;

class IdLanguageTest extends LanguageTestCase
{
    protected function createLanguage(): Language
    {
        return new IdLanguage();
    }

    protected function getExpectedCode(): string
    {
        return IdLanguage::CODE;
    }
}
