<?php

namespace Tests\Unit\Languages;

use App\Languages\Contracts\Language;
use App\Languages\DeLanguage;
use Tests\Unit\Languages\Contracts\LanguageTestCase;

class DeLanguageTest extends LanguageTestCase
{
    protected function createLanguage(): Language
    {
        return new DeLanguage();
    }

    protected function getExpectedCode(): string
    {
        return DeLanguage::CODE;
    }
}
