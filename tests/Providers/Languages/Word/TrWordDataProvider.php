<?php

namespace Tests\Providers\Languages\Word;

use App\Languages\TrLanguage;
use Tests\Providers\Languages\Word\Contracts\LanguageWordDataProvider;

class TrWordDataProvider extends LanguageWordDataProvider
{
    protected const string LANGUAGE_CODE = TrLanguage::CODE;

    protected const array AVAILABLE_CHARS = ['a', 'b', 'c', 'ç', 'd', 'e', 'ğ', 'ı', '1', '2', '!', '?'];

    protected const array NEW_CHARS = ['a', 'b', 'ç'];

    protected const string PAIRED_BASE_CHAR = 'a';

    protected function getSpecials(): array
    {
        return new TrLanguage()->getSpecials();
    }
}
