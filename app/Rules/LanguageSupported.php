<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Enums\Language;

class LanguageSupported implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $supportedLanguages = [
            Language::En->value,
            Language::Ru->value,
        ];

        if (!in_array($value, $supportedLanguages, true)) {
            $fail('The selected language is not supported.');
        }
    }
}
