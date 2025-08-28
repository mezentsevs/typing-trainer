<?php

namespace App\Services\LessonGeneration;

use App\Enums\Language;
use App\Services\LessonGeneration\ValueObjects\LessonBlueprint;

class LessonSequenceGenerator
{
    protected const array INTRODUCTION_ORDER = [
        Language::EN->value => [
            'a', 's', 'd', 'f', 'j', 'k', 'l', ';',
            'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p',
            'h', 'g', 'z', 'x', 'c', 'v', 'b', 'n', 'm', ',', '.', '/',
            'A', 'S', 'D', 'F', 'J', 'K', 'L', ';',
            'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P',
            'H', 'G', 'Z', 'X', 'C', 'V', 'B', 'N', 'M', ',', '.', '/',
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '-', '=',
            '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '[', ']', '{', '}', '|', '\\', ':', '"', '\'', '<', '>', '?', '~', '`',
        ],
        Language::RU->value => [
            'ф', 'ы', 'в', 'а', 'о', 'л', 'д', 'ж',
            'й', 'ц', 'у', 'к', 'е', 'н', 'г', 'ш', 'щ', 'з', 'х', 'ъ',
            'я', 'ч', 'с', 'м', 'и', 'т', 'ь', 'б', 'ю', 'п', 'р', 'э',
            'ё',
            'Ф', 'Ы', 'В', 'А', 'О', 'Л', 'Д', 'Ж',
            'Й', 'Ц', 'У', 'К', 'Е', 'Н', 'Г', 'Ш', 'Щ', 'З', 'Х', 'Ъ',
            'Я', 'Ч', 'С', 'М', 'И', 'Т', 'Ь', 'Б', 'Ю', 'П', 'Р', 'Э',
            'Ё',
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '-', '=',
            '!', '"', '№', ';', '%', ':', '?', '*', '(', ')', '_', '+', '/', '\\', ',', '.',
        ],
    ];

    protected const string INTRODUCTION_ORDER_DEFAULT_LANGUAGE = Language::EN->value;

    protected const int MIN_LESSON_LENGTH = 100;
    protected const int MAX_LESSON_LENGTH = 300;

    public function generate(string $language, int $lessonCount): array
    {
        $chars = self::INTRODUCTION_ORDER[$language] ?? self::INTRODUCTION_ORDER[self::INTRODUCTION_ORDER_DEFAULT_LANGUAGE];
        $charsCount = count($chars);
        $lessonBlueprints = [];
        $availableCharsString = '';

        for ($i = 0; $i < $lessonCount; $i++) {
            $charsPerLesson = max(1, ceil($charsCount / max(1, $lessonCount - $i)));
            $newChars = [];

            for ($j = 0; $j < $charsPerLesson && !empty($chars); $j++) {
                $newChars[] = array_shift($chars);
            }

            if (empty($newChars) && !empty(self::INTRODUCTION_ORDER[$language])) {
                $newChars = self::INTRODUCTION_ORDER[$language];
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
