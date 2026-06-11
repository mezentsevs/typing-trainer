<?php

namespace App\Policies;

use App\Models\Lesson;
use App\Models\User;

class LessonResultPolicy
{
    public function create(User $user, Lesson $lesson): bool
    {
        return $user->id === $lesson->user_id;
    }
}
