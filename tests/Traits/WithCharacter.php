<?php

namespace Tests\Traits;

use App\Languages\Registry\LanguageRegistry;
use App\Services\Word\WordGeneration\WordCharDataProvider;

trait WithCharacter
{
    protected function getNonPunctuation(string $language): array
    {
        $provider = app(WordCharDataProvider::class);
        $registry = app(LanguageRegistry::class);

        $candidates = array_unique(array_merge(
            $provider->getAllLetters($language),
            $registry->getSupportedOrDefault($language)->getSpecials(),
            array_keys(WordCharDataProvider::PAIRED),
            array_values(WordCharDataProvider::PAIRED),
            range('0', '9'),
            ['', ' ', "\n", "\t"],
        ));

        return array_diff($candidates, WordCharDataProvider::PUNCTUATION);
    }
}
