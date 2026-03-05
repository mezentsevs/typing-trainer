<?php

namespace App\Rules;

use App\Enums\Genre;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class GenreSupported implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $supportedGenres = array_values(
            array_filter(
                array_map(fn ($case) => $case->value, Genre::cases()),
                fn ($v) => $v !== Genre::Unknown->value,
            ),
        );

        if (!in_array($value, $supportedGenres, true)) {
            $fail('The selected genre is not supported.');
        }
    }
}
