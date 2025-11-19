<?php

namespace App\Rules;

use App\Traits\Constants\WithDatabaseConstants;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxUnsignedInteger implements ValidationRule
{
    use WithDatabaseConstants;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $max = self::MAX_UNSIGNED_INTEGER;

        if ($value > $max) {
            $fail("The :attribute field must not be greater than {$max}.");
        }
    }
}
