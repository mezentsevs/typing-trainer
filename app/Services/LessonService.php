<?php

namespace App\Services;

use App\Models\Lesson;
use App\Models\LessonResult;
use Random\RandomException;

class LessonService
{
    protected const string ENCODING = 'UTF-8';
    protected const string DEFAULT_LANGUAGE = 'en';

    protected const array INTRODUCTION_ORDER = [
        'en' => [
            'a', 's', 'd', 'f', 'j', 'k', 'l', ';',
            'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p',
            'h', 'g', 'z', 'x', 'c', 'v', 'b', 'n', 'm', ',', '.', '/',
            'A', 'S', 'D', 'F', 'J', 'K', 'L', ';',
            'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P',
            'H', 'G', 'Z', 'X', 'C', 'V', 'B', 'N', 'M', ',', '.', '/',
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '-', '=',
            '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '[', ']', '{', '}', '|', '\\', ':', '"', '\'', '<', '>', '?', '~', '`',
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
            '!', '"', '№', ';', '%', ':', '?', '*', '(', ')', '_', '+', '/', '\\', ',', '.',
        ],
    ];

    protected const int MIN_LESSON_LENGTH = 100;
    protected const int MAX_LESSON_LENGTH = 300;
    protected const int MIN_WORDS_PER_LINE = 2;
    protected const int MAX_WORDS_PER_LINE = 8;
    protected const int WORDS_BEFORE_NEWLINE = 2;
    protected const int MIN_WORD_LENGTH_TO_COUNT = 3;

    public function __construct(protected WordService $wordService)
    {
    }

    /**
     * @throws RandomException
     */
    public function generateLessons(string $language, int $lessonCount, int $userId): void
    {
        $chars = self::INTRODUCTION_ORDER[$language] ?? self::INTRODUCTION_ORDER[self::DEFAULT_LANGUAGE];
        $totalChars = count($chars);

        Lesson::where('user_id', $userId)->where('language', $language)->delete();
        LessonResult::where('user_id', $userId)->where('language', $language)->delete();

        $lessons = [];
        $availableCharsString = '';

        for ($i = 0; $i < $lessonCount; $i++) {
            $charsPerLesson = max(1, ceil($totalChars / max(1, $lessonCount - $i)));
            $newChars = [];

            for ($j = 0; $j < $charsPerLesson && !empty($chars); $j++) {
                $newChars[] = array_shift($chars);
            }

            if (empty($newChars) && !empty(self::INTRODUCTION_ORDER[$language])) {
                $newChars = self::INTRODUCTION_ORDER[$language];
            }

            $newCharsString = implode('', $newChars);
            $availableCharsString .= $newCharsString;

            $lessons[] = [
                'user_id' => $userId,
                'number' => $i + 1,
                'total' => $lessonCount,
                'language' => $language,
                'new_chars' => $newCharsString,
                'text' => $this->generateLessonText(
                    $language,
                    $i + 1,
                    $lessonCount,
                    $availableCharsString,
                    $newCharsString,
                ),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Lesson::insert($lessons);
    }

    /**
     * @throws RandomException
     */
    public function generateLessonText(string $language, int $lessonNumber, int $totalLessons, string $availableChars, string $newChars, ?int $length = null): string
    {
        $availableCharsArray = mb_str_split($availableChars, 1, self::ENCODING);
        $newCharsArray = mb_str_split($newChars, 1, self::ENCODING);

        if (empty($availableCharsArray)) {
            return '';
        }

        if ($length === null) {
            if ($totalLessons <= 1) {
                $length = self::MIN_LESSON_LENGTH;
            } else {
                $length = self::MIN_LESSON_LENGTH + (self::MAX_LESSON_LENGTH - self::MIN_LESSON_LENGTH) * ($lessonNumber - 1) / ($totalLessons - 1);
            }
        }

        $text = '';
        $wordsAdded = 0;
        $lineWordCount = 0;
        $currentLineWords = random_int(self::MIN_WORDS_PER_LINE, self::MAX_WORDS_PER_LINE);
        $isFirstOfPair = true;
        $baseWord = null;

        while (mb_strlen($text) < $length) {
            if ($wordsAdded > 0) {
                if ($lineWordCount >= $currentLineWords) {
                    $separator = "\n";
                    $lineWordCount = 0;
                    $currentLineWords = random_int(self::MIN_WORDS_PER_LINE, self::MAX_WORDS_PER_LINE);
                } else {
                    $separator = ' ';
                }

                if (mb_strlen($text) + mb_strlen($separator) > $length) {
                    break;
                }

                $text .= $separator;
            }

            if ($isFirstOfPair) {
                $baseWord = $this->wordService->generateWord($availableCharsArray, $newCharsArray, $language);
                $currentWord = $baseWord;
                $isFirstOfPair = false;

                $remainingAfterFirst = $length - mb_strlen($text) - mb_strlen($currentWord);

                if ($wordsAdded > 0) {
                    $remainingAfterFirst -= mb_strlen($separator ?? ' ');
                }

                $remainingAfterSecond = $remainingAfterFirst - mb_strlen(' ') - mb_strlen($currentWord);

                if ($remainingAfterFirst < 0 || $remainingAfterSecond < 0) {
                    break;
                }

                if ($lineWordCount + self::WORDS_BEFORE_NEWLINE > $currentLineWords) {
                    $text .= "\n";
                    $lineWordCount = 0;
                    $currentLineWords = random_int(self::MIN_WORDS_PER_LINE, self::MAX_WORDS_PER_LINE);
                }
            } else {
                $currentWord = $baseWord;
                $isFirstOfPair = true;
            }

            $remaining = $length - mb_strlen($text);

            if (mb_strlen($currentWord) > $remaining) {
                $currentWord = mb_substr($currentWord, 0, $remaining);
            }

            $text .= $currentWord;

            if (mb_strlen($currentWord) >= self::MIN_WORD_LENGTH_TO_COUNT) {
                $wordsAdded++;
                $lineWordCount++;
            }
        }

        $lines = explode("\n", $text);
        $lines = array_map('rtrim', $lines);
        $text = implode("\n", array_filter($lines, function ($line) {
            return !empty($line);
        }));

        return rtrim(mb_substr($text, 0, $length), "\n");
    }
}
