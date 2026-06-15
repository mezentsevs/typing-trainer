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
    public function generate(int $userId, string $language, int $lessonCount): void
    {
        $this->deleteLessons($userId, $language);
        $this->deleteLessonResults($userId, $language);

        $lessonBlueprints = $this->lessonSequenceGenerator->generate($language, $lessonCount);

        $lessons = [];
        foreach ($lessonBlueprints as $blueprint) {
            $lessons[] = $this->lessonDataComposer->compose($blueprint, $userId);
        }

        Lesson::insert($lessons);
    }

    protected function deleteLessons(int $userId, string $language): void
    {
        Lesson::where('user_id', $userId)
            ->where('language', $language)
            ->delete();
    }

    protected function deleteLessonResults(int $userId, string $language): void
    {
        LessonResult::where('user_id', $userId)
            ->where('language', $language)
            ->delete();
    }
}
