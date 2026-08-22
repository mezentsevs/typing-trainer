<?php

namespace Tests\Providers\Languages\Word;

use App\Languages\EsLanguage;
use Tests\Providers\Languages\Word\Contracts\LanguageWordDataProvider;

class EsWordDataProvider extends LanguageWordDataProvider
{
    protected const string LANGUAGE_CODE = EsLanguage::CODE;

    protected const array AVAILABLE_CHARS = ['a', 'b', 'c', 'd', 'e', 'ñ', 'á', 'é', '1', '2', '!', '?'];

    protected const array NEW_CHARS = ['a', 'b', 'ñ'];

    protected const string PAIRED_BASE_CHAR = 'a';

    protected function getSpecials(): array
    {
        return new EsLanguage()->getSpecials();
    }
}
