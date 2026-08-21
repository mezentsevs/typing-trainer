<?php

namespace Tests\Unit\Languages;

use App\Languages\Contracts\Language;
use App\Languages\EnLanguage;
use Tests\Unit\Languages\Contracts\LanguageTestCase;

class EnLanguageTest extends LanguageTestCase
{
    protected function createLanguage(): Language
    {
        return new EnLanguage();
    }

    protected function getExpectedCode(): string
    {
        return EnLanguage::CODE;
    }
}
