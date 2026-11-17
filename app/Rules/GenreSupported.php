<?php

namespace App\Rules;

use App\Enums\Genre;
use App\Traits\HasSupportedValidation;
use Illuminate\Contracts\Validation\ValidationRule;

class GenreSupported implements ValidationRule
{
    use HasSupportedValidation;

    protected function getSupportedValues(): array
    {
        return Genre::supportedValues();
    }
}
