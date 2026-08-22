<?php

namespace Tests\Providers\Languages\Word;

use App\Languages\RuLanguage;
use Tests\Providers\Languages\Word\Contracts\LanguageWordDataProvider;

class RuWordDataProvider extends LanguageWordDataProvider
{
    protected const string LANGUAGE_CODE = RuLanguage::CODE;

    protected const array AVAILABLE_CHARS = ['а', 'б', 'в', 'г', 'д', '1', '2', '!', '@'];

    protected const array NEW_CHARS = ['а', 'б', 'в'];

    protected const string PAIRED_BASE_CHAR = 'а';

    protected function getSpecials(): array
    {
        return new RuLanguage()->getSpecials();
    }
}
