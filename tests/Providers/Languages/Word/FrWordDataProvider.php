<?php

namespace Tests\Providers\Languages\Word;

use App\Languages\FrLanguage;
use Tests\Providers\Languages\Word\Contracts\LanguageWordDataProvider;

class FrWordDataProvider extends LanguageWordDataProvider
{
    protected const string LANGUAGE_CODE = FrLanguage::CODE;

    protected const array AVAILABLE_CHARS = ['a', 'b', 'c', 'd', 'e', 'é', 'è', 'ç', '1', '2', '!', '?'];

    protected const array NEW_CHARS = ['a', 'b', 'é'];

    protected const string PAIRED_BASE_CHAR = 'a';

    protected function getSpecials(): array
    {
        return new FrLanguage()->getSpecials();
    }
}
