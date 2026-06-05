<?php

namespace App\Policies;

use App\Models\Lesson;
use App\Models\User;

class LessonPolicy
{
    public function viewAny(User $user): bool
    {
        return auth()->check();
    }

    public function view(User $user, Lesson $lesson): bool
    {
        return $user->id === $lesson->user_id;
    }

    public function saveResult(User $user, Lesson $lesson): bool
    {
        return $user->id === $lesson->user_id;
    }
}
