<?php

namespace App\Rules;

use App\Enums\Genre;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class GenreSupported implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!in_array($value, Genre::supportedValues(), true)) {
            $fail('The selected genre is not supported.');
        }
    }
}
