<?php

namespace App\Services\LessonGeneration;

use App\Models\Lesson;
use App\Models\LessonResult;
use Random\RandomException;

class LessonGenerationOrchestrator
{
    public function __construct(
        protected LessonSequenceGenerator $lessonSequenceGenerator,
        protected LessonDataComposer $lessonDataComposer,
    ) {
    }

    /**
     * @throws RandomException
     */
    public function generate(string $language, int $lessonCount, int $userId): void
    {
        $this->deleteLessons($language, $userId);
        $this->deleteLessonResults($language, $userId);

        $lessonBlueprints = $this->lessonSequenceGenerator->generate($language, $lessonCount);

        $lessons = [];
        foreach ($lessonBlueprints as $blueprint) {
            $lessons[] = $this->lessonDataComposer->compose($blueprint, $userId);
        }

        Lesson::insert($lessons);
    }

    protected function deleteLessons(string $language, int $userId): void
    {
        Lesson::where('user_id', $userId)
            ->where('language', $language)
            ->delete();
    }

    protected function deleteLessonResults(string $language, int $userId): void
    {
        LessonResult::where('user_id', $userId)
            ->where('language', $language)
            ->delete();
    }
}
