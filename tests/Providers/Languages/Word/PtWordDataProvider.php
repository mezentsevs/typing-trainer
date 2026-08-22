<?php

namespace Tests\Providers\Languages\Word;

use App\Languages\PtLanguage;
use Tests\Providers\Languages\Word\Contracts\LanguageWordDataProvider;

class PtWordDataProvider extends LanguageWordDataProvider
{
    protected const string LANGUAGE_CODE = PtLanguage::CODE;

    protected const array AVAILABLE_CHARS = ['a', 'b', 'c', 'd', 'e', 'á', 'â', 'ç', '1', '2', '!', '?'];

    protected const array NEW_CHARS = ['a', 'b', 'á'];

    protected const string PAIRED_BASE_CHAR = 'a';

    protected function getSpecials(): array
    {
        return new PtLanguage()->getSpecials();
    }
}
