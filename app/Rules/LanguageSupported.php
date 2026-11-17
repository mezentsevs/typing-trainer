<?php

namespace App\Rules;

use App\Languages\Registry\LanguageRegistry;
use App\Traits\HasSupportedValidation;
use Illuminate\Contracts\Validation\ValidationRule;

class LanguageSupported implements ValidationRule
{
    use HasSupportedValidation;

    protected function getSupportedValues(): array
    {
        return app(LanguageRegistry::class)->getSupportedCodes();
    }
}
