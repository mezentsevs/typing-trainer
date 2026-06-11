<?php

namespace App\Policies;

use App\Models\User;

class TestResultPolicy
{
    public function create(User $user): bool
    {
        return auth()->check();
    }
}
