<?php

namespace App\Services\LessonGeneration;

use App\Services\LessonGeneration\ValueObjects\LessonBlueprint;
use App\Services\WordService;
use Random\RandomException;

class LessonTextGenerator
{
    protected const string ENCODING = 'UTF-8';
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
    public function generate(LessonBlueprint $blueprint): string
    {
        $availableChars = mb_str_split($blueprint->availableChars, 1, self::ENCODING);
        $newChars = mb_str_split($blueprint->newChars, 1, self::ENCODING);

        if (empty($availableChars)) {
            return '';
        }

        $text = '';
        $wordsAdded = 0;
        $lineWordCount = 0;
        $currentLineWords = random_int(self::MIN_WORDS_PER_LINE, self::MAX_WORDS_PER_LINE);
        $isFirstOfPair = true;
        $baseWord = null;

        while (mb_strlen($text) < $blueprint->length) {
            if ($wordsAdded > 0) {
                $separator = $this->determineSeparator($lineWordCount, $currentLineWords);
                if ($separator === "\n") {
                    $lineWordCount = 0;
                    $currentLineWords = random_int(self::MIN_WORDS_PER_LINE, self::MAX_WORDS_PER_LINE);
                }

                if (mb_strlen($text) + mb_strlen($separator) > $blueprint->length) {
                    break;
                }

                $text .= $separator;
            }

            if ($isFirstOfPair) {
                $baseWord = $this->wordService->generateWord($blueprint->language, $availableChars, $newChars);
                $currentWord = $baseWord;
                $isFirstOfPair = false;

                $remainingAfterFirst = $blueprint->length - mb_strlen($text) - mb_strlen($currentWord);

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

            $remainingLength = $blueprint->length - mb_strlen($text);

            if (mb_strlen($currentWord) > $remainingLength) {
                $currentWord = mb_substr($currentWord, 0, $remainingLength);
            }

            $text .= $currentWord;

            if (mb_strlen($currentWord) >= self::MIN_WORD_LENGTH_TO_COUNT) {
                $wordsAdded++;
                $lineWordCount++;
            }
        }

        return $this->formatFinalText($text, $blueprint->length);
    }

    protected function determineSeparator(int $lineWordCount, int $currentLineWords): string
    {
        return $lineWordCount >= $currentLineWords ? "\n" : ' ';
    }

    protected function formatFinalText(string $text, int $length): string
    {
        $lines = explode("\n", $text);
        $lines = array_map('rtrim', $lines);
        $text = implode("\n", array_filter($lines, function ($line) {
            return !empty($line);
        }));

        return rtrim(mb_substr($text, 0, $length), "\n");
    }
}
