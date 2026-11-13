<?php

namespace App\Services\Lesson\LessonGeneration;

use App\Models\Lesson;
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
        $this->purge($userId, $language);

        $lessonBlueprints = $this->lessonSequenceGenerator->generate($language, $lessonCount);

        $lessons = [];
        foreach ($lessonBlueprints as $blueprint) {
            $lessons[] = $this->lessonDataComposer->compose($blueprint, $userId);
        }

        Lesson::insert($lessons);
    }

    protected function purge(int $userId, string $language): void
    {
        Lesson::where('user_id', $userId)
            ->where('language', $language)
            ->delete();
    }
}
