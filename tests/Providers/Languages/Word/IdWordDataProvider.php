<?php

namespace Tests\Providers\Languages\Word;

use App\Languages\IdLanguage;
use Tests\Providers\Languages\Word\Contracts\LanguageWordDataProvider;

class IdWordDataProvider extends LanguageWordDataProvider
{
    protected const string LANGUAGE_CODE = IdLanguage::CODE;

    protected const array AVAILABLE_CHARS = ['a', 'b', 'c', 'd', 'e', '1', '2', '!', '@'];

    protected const array NEW_CHARS = ['a', 'b', 'c'];

    protected const string PAIRED_BASE_CHAR = 'a';

    protected function getSpecials(): array
    {
        return new IdLanguage()->getSpecials();
    }
}
