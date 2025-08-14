<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\LessonService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ReflectionClass;
use Tests\TestCase;

class LessonServiceTest extends TestCase
{
    use RefreshDatabase;

    protected LessonService $service;

    protected ReflectionClass $reflection;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->service = new LessonService();
        $this->reflection = new ReflectionClass($this->service);
    }
}
