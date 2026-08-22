<?php

namespace Tests\Providers\Languages\Word;

use App\Languages\ItLanguage;
use Tests\Providers\Languages\Word\Contracts\LanguageWordDataProvider;

class ItWordDataProvider extends LanguageWordDataProvider
{
    protected const string LANGUAGE_CODE = ItLanguage::CODE;

    protected const array AVAILABLE_CHARS = ['a', 'b', 'c', 'd', 'e', 'à', 'è', 'é', '1', '2', '!', '?'];

    protected const array NEW_CHARS = ['a', 'b', 'à'];

    protected const string PAIRED_BASE_CHAR = 'a';

    protected function getSpecials(): array
    {
        return new ItLanguage()->getSpecials();
    }
}
