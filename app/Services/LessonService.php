<?php

namespace App\Services;

use App\Models\Lesson;

class LessonService
{
    protected $charSets = [
        'en' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=[]{}|;:,.<>?',
        'ru' => 'абвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ0123456789!@#$%^&*()_+-=[]{}|;:,.<>?',
    ];

    public function generateLessons(string $language, int $lessonCount): void
    {
        $chars = str_split($this->charSets[$language] ?? $this->charSets['en']);
        $charsPerLesson = ceil(count($chars) / $lessonCount);

        Lesson::where('language', $language)->delete();

        for ($i = 0; $i < $lessonCount; $i++) {
            $start = $i * $charsPerLesson;
            $newChars = array_slice($chars, $start, $charsPerLesson);
            if ($newChars) {
                Lesson::create([
                    'number' => $i + 1,
                    'language' => $language,
                    'new_chars' => implode('', $newChars),
                ]);
            }
        }
    }

    public function generateLessonText(string $language, int $lessonNumber, int $length = 100): string
    {
        $lesson = Lesson::where('language', $language)->where('number', $lessonNumber)->firstOrFail();
        $availableChars = '';
        foreach (Lesson::where('language', $language)->where('number', '<=', $lessonNumber)->get() as $l) {
            $availableChars .= $l->new_chars;
        }

        $text = '';
        for ($i = 0; $i < $length; $i++) {
            $text .= $availableChars[random_int(0, strlen($availableChars) - 1)];
        }

        return $text;
    }
}
