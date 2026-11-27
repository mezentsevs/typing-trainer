<?php

namespace Tests\Providers\Languages\Word;

use App\Languages\IdLanguage;

class IdWordDataProvider extends EnWordDataProvider
{
    protected const string LANGUAGE_CODE = IdLanguage::CODE;

    protected function getSpecials(): array
    {
        return new IdLanguage()->getSpecials();
    }
}
