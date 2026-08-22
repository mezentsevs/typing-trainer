<?php

namespace Tests\Providers\Languages\Word;

use App\Languages\PlLanguage;
use Tests\Providers\Languages\Word\Contracts\LanguageWordDataProvider;

class PlWordDataProvider extends LanguageWordDataProvider
{
    protected const string LANGUAGE_CODE = PlLanguage::CODE;

    protected const array AVAILABLE_CHARS = ['a', 'ą', 'b', 'c', 'ć', 'd', 'e', 'ę', '1', '2', '!', '?'];

    protected const array NEW_CHARS = ['a', 'ą', 'b'];

    protected const string PAIRED_BASE_CHAR = 'a';

    protected function getSpecials(): array
    {
        return new PlLanguage()->getSpecials();
    }
}
