<?php

namespace App\Policies;

use App\Models\User;

class TestTextPolicy
{
    public function viewAny(User $user): bool
    {
        return auth()->check();
    }
}
