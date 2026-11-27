<?php

namespace Tests\Unit\Languages;

use App\Languages\IdLanguage;
use Tests\Unit\Languages\Contracts\LanguageTestCase;

class IdLanguageTest extends LanguageTestCase
{
    protected const string LANGUAGE_CLASS = IdLanguage::class;
}
