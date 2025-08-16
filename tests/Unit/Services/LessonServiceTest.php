<?php

namespace Tests\Unit\Services;

use App\Models\Lesson;
use App\Models\LessonResult;
use App\Models\User;
use App\Services\LessonService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use ReflectionClass;
use Tests\TestCase;
use Tests\Unit\Services\Providers\LessonDataProvider;

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

    #[DataProviderExternal(LessonDataProvider::class, 'provideSupportedLanguages')]
    public function testGenerateLessonsDeletesExistingAndCreatesNew(string $language): void
    {
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
    }

    #[DataProviderExternal(LessonDataProvider::class, 'provideLessonsSequenceData')]
    public function testGenerateLessonsWithValidSequenceAndContent(array $data): void
    {
        $this->service->generateLessons($data['language'], $data['lessonCount'], $this->user->id);

        $lesson = Lesson::where('user_id', $this->user->id)
            ->where('language', $data['language'])
            ->where('number', $data['lessonNumber'])
            ->first();

        $this->assertEquals($this->user->id, $lesson->user_id);
        $this->assertEquals($data['language'], $lesson->language);
        $this->assertEquals($data['lessonNumber'], $lesson->number);
        $this->assertEquals($data['lessonCount'], $lesson->total);

        $this->assertIsString($lesson->new_chars);
        $this->assertNotEmpty($lesson->new_chars);
        $this->assertEquals($data['expectedNewChars'], $lesson->new_chars);

        $this->assertIsString($lesson->text);
        $this->assertNotEmpty($lesson->text);
        $this->assertTextContainsOnlyAllowedChars($lesson->text, $data['expectedAvailableChars']);
        $this->assertTextLengthWithinBounds($lesson->text);
        $this->assertLineStructureValid($lesson->text);
    }

    private function assertTextContainsOnlyAllowedChars(string $text, string $availableChars): void
    {
        $allowedChars = array_merge(mb_str_split($availableChars), [' ', "\n"]);
        $uniqueTextChars = array_unique(preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY));

        foreach ($uniqueTextChars as $char) {
            $this->assertContains($char, $allowedChars, "Character '{$char}' is not allowed.");
        }
    }

    private function assertTextLengthWithinBounds(string $text): void
    {
        $textLength = mb_strlen($text);
        $maxTextLength = $this->reflection->getConstant('MAX_LESSON_LENGTH');

        $this->assertGreaterThan(0, $textLength, 'Text length must be greater than 0.');
        $this->assertLessThanOrEqual(
            $maxTextLength,
            $textLength,
            'Text length must not exceed the maximum limit of ' . $maxTextLength . ' characters.',
        );
    }

    private function assertLineStructureValid(string $text): void
    {
        $lines = array_filter(explode("\n", $text));
        $minWordsPerLine = $this->reflection->getConstant('MIN_WORDS_PER_LINE');
        $maxWordsPerLine = $this->reflection->getConstant('MAX_WORDS_PER_LINE');

        foreach ($lines as $line) {
            $wordsPerLine = count(explode(' ', $line));

            $this->assertGreaterThanOrEqual(
                $minWordsPerLine,
                $wordsPerLine,
                "Line '{$line}' has too few words. Expected at least " . $minWordsPerLine . ", got {$wordsPerLine}.",
            );

            $this->assertLessThanOrEqual(
                $maxWordsPerLine,
                $wordsPerLine,
                "Line '{$line}' has too many words. Expected at most " . $maxWordsPerLine . ", got {$wordsPerLine}.",
            );
        }
    }
}
