<?php

namespace Tests\Feature\Traits;

use App\Models\Lesson;
use App\Models\User;

trait WithLesson
{
    protected function createLesson(User $user, array $attributes = []): Lesson
    {
        return Lesson::factory()->create(array_merge(['user_id' => $user->id], $attributes));
    }
}
