<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_get_test_text(): void
    {
        $user = User::factory()->create();

        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->getJson('/api/test/text?language=en');

        $response->assertStatus(200)
            ->assertJsonStructure(['text']);
    }

    public function test_user_can_save_test_result(): void
    {
        $user = User::factory()->create();

        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->postJson('/api/test/result', [
                'language' => 'en',
                'speed_wpm' => 50,
                'errors' => 2,
            ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['id', 'user_id', 'language', 'speed_wpm', 'errors']);
    }
}
