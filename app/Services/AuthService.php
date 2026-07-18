<?php

namespace App\Services;

use App\Dtos\Auth\LoginDto;
use App\Dtos\Auth\RegisterDto;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function me(): User
    {
        /**
         * @var User $user
         */
        $user = Auth::user();

        return $user;
    }

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

    public function login(LoginDto $dto): ?array
    {
        if (!Auth::attempt([
            'email' => $dto->email,
            'password' => $dto->password,
        ])) {
            return null;
        }

        /**
         * @var User $user
         */
        $user = Auth::user();

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user,
        ];
    }

    public function logout(): void
    {
        /**
         * @var User $user
         */
        $user = Auth::user();

        $user->tokens()->delete();
        Auth::forgetGuards();
    }
}
