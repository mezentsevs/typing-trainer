<?php

namespace Tests\Providers\Languages\Word;

use App\Languages\DeLanguage;
use Tests\Providers\Languages\Word\Contracts\LanguageWordDataProvider;

class DeWordDataProvider extends LanguageWordDataProvider
{
    protected const string LANGUAGE_CODE = DeLanguage::CODE;

    protected const array AVAILABLE_CHARS = ['a', 'b', 'c', 'd', 'e', 'ö', 'ü', 'ß', '1', '2', '!', '?'];

    protected const array NEW_CHARS = ['a', 'b', 'ö'];

    protected const string PAIRED_BASE_CHAR = 'a';

    protected function getSpecials(): array
    {
        return new DeLanguage()->getSpecials();
    }
}
