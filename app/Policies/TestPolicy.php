<?php

namespace App\Policies;

use App\Models\User;

class TestPolicy
{
    public function viewAny(User $user): bool
    {
        return auth()->check();
    }

    public function upload(User $user): bool
    {
        return auth()->check();
    }
}
