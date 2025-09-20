<?php

namespace Tests\Traits;

use App\Models\User;

trait WithUser
{
    protected function createUser(array $attributes = []): User
    {
        return User::factory()->create($attributes);
    }

    protected function createTokenForUser(User $user, string $tokenName): string
    {
        return $user->createToken($tokenName)->plainTextToken;
    }
}
