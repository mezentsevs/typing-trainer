<?php

namespace App\Policies;

use App\Models\Lesson;
use App\Models\User;

class LessonPolicy
{
    public function saveResult(User $user, Lesson $lesson): bool
    {
        return $user->id === $lesson->user_id;
    }
}
