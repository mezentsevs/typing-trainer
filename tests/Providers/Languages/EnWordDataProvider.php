<?php

namespace Tests\Providers\Languages;

use App\Languages\EnLanguage;
use Tests\Providers\Languages\Contracts\LanguageWordDataProvider;

class EnWordDataProvider extends LanguageWordDataProvider
{
    protected const string LANGUAGE_CODE = EnLanguage::CODE;

    protected const array AVAILABLE_CHARS = ['a', 'b', 'c', 'd', 'e', '1', '2', '!', '@'];

    protected const array NEW_CHARS = ['a', 'b', 'c'];

    protected const string PAIRED_BASE_CHAR = 'a';

    protected function getSpecials(): array
    {
        return new EnLanguage()->getSpecials();
    }
}
