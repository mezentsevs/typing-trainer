<?php

namespace App\Services\Lesson\LessonGeneration;

use App\Languages\Registry\LanguageRegistry;
use App\Services\Lesson\LessonGeneration\ValueObjects\LessonBlueprint;

class LessonSequenceGenerator
{
    protected const int MIN_LESSON_LENGTH = 100;
    protected const int MAX_LESSON_LENGTH = 300;

    public function __construct(protected LanguageRegistry $languageRegistry)
    {
    }

    public function generate(string $language, int $lessonCount): array
    {
        $introductionOrder = $this->languageRegistry
            ->getSupportedOrDefault($language)
            ->getIntroductionOrder();
        $introductionOrderCount = count($introductionOrder);
        $remainingChars = $introductionOrder;
        $lessonBlueprints = [];
        $availableCharsString = '';

        for ($i = 0; $i < $lessonCount; $i++) {
            $charsPerLesson = max(1, ceil($introductionOrderCount / max(1, $lessonCount - $i)));
            $newChars = [];

            for ($j = 0; $j < $charsPerLesson && !empty($remainingChars); $j++) {
                $newChars[] = array_shift($remainingChars);
            }

            if (empty($newChars) && !empty($introductionOrder)) {
                $newChars = $introductionOrder;
            }

            $newCharsString = implode('', $newChars);
            $availableCharsString .= $newCharsString;
            $length = $this->calculateLessonLength($i + 1, $lessonCount);

            $lessonBlueprints[] = new LessonBlueprint(
                $language,
                $i + 1,
                $lessonCount,
                $availableCharsString,
                $newCharsString,
                $length,
            );
        }

        return $lessonBlueprints;
    }

    protected function calculateLessonLength(int $lessonNumber, int $lessonCount): int
    {
        if ($lessonCount <= 1) {
            return self::MIN_LESSON_LENGTH;
        }

        return self::MIN_LESSON_LENGTH + (self::MAX_LESSON_LENGTH - self::MIN_LESSON_LENGTH) * ($lessonNumber - 1) / ($lessonCount - 1);
    }
}
