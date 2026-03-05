<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Enums\Language;

class LanguageSupported implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $supportedLanguages = array_values(
            array_filter(
                array_map(fn ($case) => $case->value, Language::cases()),
                fn ($v) => $v !== Language::Unknown->value,
            ),
        );

        if (!in_array($value, $supportedLanguages, true)) {
            $fail('The selected language is not supported.');
        }
    }
}
