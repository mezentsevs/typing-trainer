<?php

namespace Tests\Unit\Services;

use App\Models\Lesson;
use App\Models\LessonResult;
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

    public function testGenerateLessonsDeletesExistingAndCreatesNew(): void
    {
        $language = 'en';
        $lessonCount = 5;
        $existingLessonCount = 3;
        $existingLessonResultCount = 3;

        $existingLessons = Lesson::factory()->count($existingLessonCount)->create([
            'user_id' => $this->user->id,
            'language' => $language,
        ]);

        $existingLessonResults = LessonResult::factory()->count($existingLessonResultCount)->create([
            'user_id' => $this->user->id,
            'language' => $language,
        ]);

        $this->service->generateLessons($language, $lessonCount, $this->user->id);

        foreach ($existingLessons as $lesson) {
            $this->assertDatabaseMissing('lessons', [
                'id' => $lesson->id,
            ]);
        }

        foreach ($existingLessonResults as $lessonResult) {
            $this->assertDatabaseMissing('lesson_results', [
                'id' => $lessonResult->id,
            ]);
        }

        $newLessons = Lesson::where('user_id', $this->user->id)
            ->where('language', $language)
            ->get();

        $this->assertCount($lessonCount, $newLessons);

        foreach ($newLessons as $lesson) {
            $this->assertInstanceOf(Lesson::class, $lesson);
            $this->assertEquals($this->user->id, $lesson->user_id);
            $this->assertEquals($language, $lesson->language);

            $this->assertIsInt($lesson->number);
            $this->assertGreaterThanOrEqual(1, $lesson->number);
            $this->assertLessThanOrEqual($lessonCount, $lesson->number);

            $this->assertIsInt($lesson->total);
            $this->assertEquals($lessonCount, $lesson->total);

            $this->assertIsString($lesson->new_chars);
            $this->assertNotEmpty($lesson->new_chars);

            $this->assertIsString($lesson->text);
            $this->assertNotEmpty($lesson->text);
            $this->assertGreaterThanOrEqual(1, mb_strlen($lesson->text));
            $this->assertLessThanOrEqual($this->reflection->getConstant('MAX_LESSON_LENGTH'), mb_strlen($lesson->text));
        }
    }
}
