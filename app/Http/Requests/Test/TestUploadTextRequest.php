<?php

namespace App\Http\Requests\Test;

use App\Http\Requests\BaseRequest;
use App\Models\Test;
use App\Rules\LanguageSupported;
use App\Traits\Constants\WithFileConstants;

class TestUploadTextRequest extends BaseRequest
{
    use WithFileConstants;

    public function authorize(): bool
    {
        return $this->user()->can('upload', Test::class);
    }

    public function rules(): array
    {
        return [
            'language' => ['bail', 'required', 'string', new LanguageSupported()],
            'file' => ['bail', 'required', 'file', 'mimes:txt', 'max:' . self::MAX_FILE_SIZE_KB],
        ];
    }
}
