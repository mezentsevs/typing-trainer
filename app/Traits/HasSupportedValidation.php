<?php

namespace App\Traits;

use Closure;

trait HasSupportedValidation
{
    abstract protected function getSupportedValues(): array;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!in_array($value, $this->getSupportedValues(), true)) {
            $fail("The selected {$attribute} is not supported.");
        }
    }
}
