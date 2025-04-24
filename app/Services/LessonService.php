<?php

namespace App\Services;

use App\Models\Lesson;

class LessonService
{
    protected $introductionOrder = [
        'en' => [
            'a', 's', 'd', 'f', 'j', 'k', 'l', ';',
            'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p',
            'h', 'g', 'z', 'x', 'c', 'v', 'b', 'n', 'm', ',', '.', '/',
            'A', 'S', 'D', 'F', 'J', 'K', 'L', ';',
            'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P',
            'H', 'G', 'Z', 'X', 'C', 'V', 'B', 'N', 'M', ',', '.', '/',
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '-', '=',
            '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '[', ']', '{', '}', '|', '\\', ':', '"', '\'', '<', '>', '?', '~', '`'
        ],
        'ru' => [
            'ф', 'ы', 'в', 'а', 'о', 'л', 'д', 'ж',
            'й', 'ц', 'у', 'к', 'е', 'н', 'г', 'ш', 'щ', 'з', 'х', 'ъ',
            'я', 'ч', 'с', 'м', 'и', 'т', 'ь', 'б', 'ю', 'п', 'р', 'э',
            'ё',
            'Ф', 'Ы', 'В', 'А', 'О', 'Л', 'Д', 'Ж',
            'Й', 'Ц', 'У', 'К', 'Е', 'Н', 'Г', 'Ш', 'Щ', 'З', 'Х', 'Ъ',
            'Я', 'Ч', 'С', 'М', 'И', 'Т', 'Ь', 'Б', 'Ю', 'П', 'Р', 'Э',
            'Ё',
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '-', '=',
            '!', '"', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '[', ']', '{', '}', '|', '/', ',', '.', '<', '>', '?', ':', ';'
        ],
    ];

    public function generateLessons(string $language, int $lessonCount, int $userId): void
    {
        $chars = $this->introductionOrder[$language] ?? $this->introductionOrder['en'];
        $charsPerLesson = ceil(count($chars) / $lessonCount);

        Lesson::where('language', $language)->where('user_id', $userId)->delete();

        for ($i = 0; $i < $lessonCount; $i++) {
            $start = $i * $charsPerLesson;
            $newChars = array_slice($chars, $start, $charsPerLesson);
            if ($newChars) {
                Lesson::create([
                    'user_id' => $userId,
                    'number' => $i + 1,
                    'language' => $language,
                    'new_chars' => implode('', $newChars),
                ]);
            }
        }
    }

    public function generateLessonText(string $language, int $lessonNumber, int $userId, int $length = 100): string
    {
        $availableChars = '';
        foreach (Lesson::where('language', $language)->where('user_id', $userId)->where('number', '<=', $lessonNumber)->get() as $l) {
            $availableChars .= $l->new_chars;
        }

        $availableCharsArray = mb_str_split($availableChars, 1, 'UTF-8');

        if (empty($availableCharsArray)) {
            return '';
        }

        $text = '';
        $wordsAdded = 0;
        $linesPerBreak = 7;

        while (mb_strlen($text) < $length) {
            if ($wordsAdded > 0) {
                $separator = ($wordsAdded % $linesPerBreak == 0) ? "\n" : " ";
                if (mb_strlen($text) + mb_strlen($separator) > $length) {
                    break;
                }
                $text .= $separator;
            }

            $remaining = $length - mb_strlen($text);
            if ($remaining <= 0) {
                break;
            }

            if ($remaining >= 3) {
                $wordLength = random_int(3, min(8, $remaining));
                $isFullWord = true;
            } else {
                $wordLength = $remaining;
                $isFullWord = false;
            }

            $word = '';
            for ($i = 0; $i < $wordLength; $i++) {
                $word .= $availableCharsArray[random_int(0, count($availableCharsArray) - 1)];
            }
            $text .= $word;

            if ($isFullWord) {
                $wordsAdded++;
            }
        }

        return mb_substr($text, 0, $length);
    }
}
