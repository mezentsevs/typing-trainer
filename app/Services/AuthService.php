<?php

namespace App\Services;

use App\Dtos\RegisterDto;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(RegisterDto $dto): array
    {
        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user,
        ];
    }
}
