<?php

namespace Tests\Feature;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LessonTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_generate_lessons(): void
    {
        $user = User::factory()->create();

        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->postJson('/api/lessons/generate', [
                'language' => 'en',
                'lesson_count' => 5,
            ]);

        $response->assertStatus(200);

        $this->assertCount(5, Lesson::where('language', 'en')->get());
    }

    public function test_user_can_get_lesson_text(): void
    {
        $user = User::factory()->create();

        $token = $user->createToken('test')->plainTextToken;

        Lesson::create(['number' => 1, 'language' => 'en', 'new_chars' => 'abc']);

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->getJson('/api/lessons/en/1/text');

        $response->assertStatus(200)
            ->assertJsonStructure(['text']);
    }
}
