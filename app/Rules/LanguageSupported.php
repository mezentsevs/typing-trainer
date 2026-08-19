<?php

namespace App\Rules;

use App\Languages\Registry\LanguageRegistry;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LanguageSupported implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $supportedCodes = app(LanguageRegistry::class)->getSupportedCodes();

        if (!in_array($value, $supportedCodes, true)) {
            $fail('The selected language is not supported.');
        }
    }
}
