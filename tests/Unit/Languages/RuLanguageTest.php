<?php

namespace Tests\Unit\Languages;

use App\Languages\Contracts\Language;
use App\Languages\RuLanguage;
use Tests\Unit\Languages\Contracts\LanguageTestCase;

class RuLanguageTest extends LanguageTestCase
{
    protected function createLanguage(): Language
    {
        return new RuLanguage();
    }

    protected function getExpectedCode(): string
    {
        return RuLanguage::CODE;
    }
}
