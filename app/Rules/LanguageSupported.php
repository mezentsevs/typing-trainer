<?php

namespace App\Rules;

use App\Enums\Language;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LanguageSupported implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!in_array($value, Language::supportedValues(), true)) {
            $fail('The selected language is not supported.');
        }
    }
}
