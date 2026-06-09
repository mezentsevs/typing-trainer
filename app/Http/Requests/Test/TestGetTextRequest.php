<?php

namespace App\Http\Requests\Test;

use App\Http\Requests\BaseRequest;
use App\Models\TestText;
use App\Rules\GenreSupported;
use App\Rules\LanguageSupported;

class TestGetTextRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', TestText::class);
    }

    public function rules(): array
    {
        return [
            'language' => ['bail', 'required', new LanguageSupported()],
            'genre' => ['bail', 'nullable', new GenreSupported()],
        ];
    }
}
