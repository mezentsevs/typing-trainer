<?php

namespace App\Http\Requests\Test;

use App\Http\Requests\BaseRequest;
use App\Models\Test;
use App\Rules\GenreSupported;
use App\Rules\LanguageSupported;

class TestRetrieveRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', Test::class);
    }

    public function rules(): array
    {
        return [
            'language' => ['bail', 'required', new LanguageSupported()],
            'genre' => ['bail', 'nullable', new GenreSupported()],
        ];
    }
}
