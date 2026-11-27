<?php

namespace App\Services\Lesson\LessonGeneration;

use App\Models\Lesson;

class LessonGenerationOrchestrator
{
    public function __construct(
        private LessonSequenceGenerator $lessonSequenceGenerator,
        private LessonDataComposer $lessonDataComposer,
    ) {
    }

    public function generate(int $userId, string $language, int $lessonCount): void
    {
        $this->purge($userId, $language);

        $lessonBlueprints = $this->lessonSequenceGenerator->generate($language, $lessonCount);

        $lessons = [];
        foreach ($lessonBlueprints as $blueprint) {
            $lessons[] = $this->lessonDataComposer->compose($blueprint, $userId);
        }

        Lesson::insert($lessons);
    }

    private function purge(int $userId, string $language): void
    {
        Lesson::where('user_id', $userId)
            ->where('language', $language)
            ->delete();
    }
}
