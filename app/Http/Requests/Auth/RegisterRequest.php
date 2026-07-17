<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'bail|required|string|max:255|regex:/^[a-zA-Z \-0-9]+$/',
            'email' => 'bail|required|string|email|max:255|unique:users',
            'password' => 'bail|required|string|min:8|max:255|confirmed|regex:/^[!-~]+$/',
        ];
    }
}
