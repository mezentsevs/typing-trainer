<?php

namespace App\Services;

use App\Models\Lesson;
use App\Models\LessonProgress;
use Random\RandomException;

class LessonService
{
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

    protected const array LETTERS_LC_RU = ['а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'];

    protected const array LETTERS_UC_RU = ['А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'];

    protected const array SPECIALS_EN = ['!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '-', '_', '=', '+', '[', ']', '{', '}', '|', '/', '\\', ':', '"', '\'', '<', '>', '?', '~', '`', ',', '.', ';'];

    protected const array SPECIALS_RU = ['!', '"', '№', ';', '%', ':', '?', '*', '(', ')', '-', '_', '=', '+', '/', '\\', ',', '.'];

    protected const array PAIRED = [
        '(' => ')',
        '[' => ']',
        '{' => '}',
        '<' => '>',
        '"' => '"',
        "'" => "'",
        '`' => '`'
    ];

    protected const int MIN_LESSON_LENGTH = 100;

    protected const int MAX_LESSON_LENGTH = 300;

    protected const int MIN_WORDS_PER_LINE = 2;

    protected const int MAX_WORDS_PER_LINE = 8;

    /**
     * @throws RandomException
     */
    public function generateLessons(string $language, int $lessonCount, int $userId): void
    {
        $chars = self::INTRODUCTION_ORDER[$language] ?? self::INTRODUCTION_ORDER['en'];
        $totalChars = count($chars);

        Lesson::where('user_id', $userId)->where('language', $language)->delete();
        LessonProgress::where('user_id', $userId)->where('language', $language)->delete();

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
                    $newCharsString
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
        $availableCharsArray = mb_str_split($availableChars, 1, 'UTF-8');
        $newCharsArray = mb_str_split($newChars, 1, 'UTF-8');

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
                $baseWord = $this->generateEnhancedWord($availableCharsArray, $newCharsArray, $language);
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

                if ($lineWordCount + 2 > $currentLineWords) {
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

            if (mb_strlen($currentWord) >= 3) {
                $wordsAdded++;
                $lineWordCount++;
            }
        }

        $lines = explode("\n", $text);
        $lines = array_map('rtrim', $lines);
        $text = implode("\n", array_filter($lines, function($line) {
            return !empty($line);
        }));

        return rtrim(mb_substr($text, 0, $length), "\n");
    }

    /**
     * @throws RandomException
     */
    private function generateEnhancedWord(array $availableCharsArray, array $newCharsArray, string $language): string
    {
        $availableLetters = array_filter($availableCharsArray, function ($char) {
            return preg_match('/[a-zA-ZА-яёЁ0-9]/u', $char);
        });

        $newLetters = array_filter($newCharsArray, function ($char) {
            return preg_match('/[a-zA-ZА-яёЁ0-9]/u', $char);
        });

        $allVowels = $this->getVowels($language);
        $availableVowels = array_intersect($allVowels, $availableLetters);
        $newVowels = array_intersect($allVowels, $newLetters);

        $allConsonants = $this->getConsonants($language);
        $availableConsonants = array_intersect($allConsonants, $availableLetters);
        $newConsonants = array_intersect($allConsonants, $newLetters);

        $availableNumbers = array_filter($availableLetters, function ($char) {
            return preg_match('/[0-9]/u', $char);
        });

        $newNumbers = array_filter($newLetters, function ($char) {
            return preg_match('/[0-9]/u', $char);
        });

        $wordLength = random_int(3, 8);
        $letterPart = '';

        if (!empty($availableVowels) && !empty($availableConsonants)) {
            $startType = rand(0, 1) == 0 ? 'V' : 'C';
            $startSet = $startType == 'V' ? $availableVowels : $availableConsonants;
            $startSetNew = $startType == 'V' ? $newVowels : $newConsonants;
            $otherSet = $startType == 'V' ? $availableConsonants : $availableVowels;
            $otherSetNew = $startType == 'V' ? $newConsonants : $newVowels;
        } elseif (!empty($availableVowels)) {
            $startSet = $availableVowels;
            $startSetNew = $newVowels;
            $otherSet = [];
            $otherSetNew = [];
        } elseif (!empty($availableConsonants)) {
            $startSet = $availableConsonants;
            $startSetNew = $newConsonants;
            $otherSet = [];
            $otherSetNew = [];
        } else {
            return '';
        }

        for ($i = 0; $i < $wordLength; $i++) {
            $set = ($i % 2 == 0) ? $startSet : $otherSet;
            $setNew = ($i % 2 == 0) ? $startSetNew : $otherSetNew;

            if (empty($set)) {
                $set = $availableLetters;
                $setNew = $newLetters;
            }

            $useNumber = !empty($availableNumbers) && rand(0, 99) < 30;

            if ($useNumber) {
                if (!empty($newNumbers) && rand(0, 99) < 70) {
                    $letterPart .= $newNumbers[array_rand($newNumbers)];
                } else {
                    $letterPart .= $availableNumbers[array_rand($availableNumbers)];
                }
            } else {
                if (!empty($setNew) && rand(0, 99) < 70) {
                    $letterPart .= $setNew[array_rand($setNew)];
                } else {
                    $letterPart .= $set[array_rand($set)];
                }
            }
        }

        $availableSpecials = array_filter($availableCharsArray, function ($char) use ($language) {
            $validSpecials = match ($language) {
                'en' => self::SPECIALS_EN,
                'ru' => self::SPECIALS_RU,
                default => [],
            };

            return in_array($char, $validSpecials);
        });

        $pairedSymbols = array_merge(array_keys(self::PAIRED), array_values(self::PAIRED));
        $singleSpecials = array_diff($availableSpecials, $pairedSymbols);

        $possiblePairedOpenings = ['(', '[', '{', '<', '"', "'", '`'];
        $availablePairedOpenings = array_intersect($possiblePairedOpenings, $availableSpecials);
        $availablePaired = [];

        foreach ($availablePairedOpenings as $opening) {
            if (in_array(self::PAIRED[$opening], $availableSpecials)) {
                $availablePaired[] = $opening;
            }
        }

        $totalOptions = ['none'];

        if (!empty($singleSpecials)) {
            $totalOptions[] = 'single';
        }

        if (!empty($availablePaired)) {
            $totalOptions[] = 'paired';
        }

        $type = $totalOptions[array_rand($totalOptions)];

        if ($type == 'none') {
            return $letterPart;
        } elseif ($type == 'single') {
            $special = $singleSpecials[array_rand($singleSpecials)];

            if ($this->isPunctuation($special)) {
                return $letterPart . $special;
            }

            $position = rand(0, 1) == 0 ? 'start' : 'end';

            return $position == 'start' ? $special . $letterPart : $letterPart . $special;
        } else {
            $opening = $availablePaired[array_rand($availablePaired)];
            $closing = self::PAIRED[$opening];

            return $opening . $letterPart . $closing;
        }
    }

    private function isPunctuation(string $char): bool
    {
        return in_array($char, [',', '.', ';', ':', '!', '?']);
    }

    private function getVowels(string $language): array
    {
        if ($language == 'ru') {
            return ['а', 'е', 'ё', 'и', 'о', 'у', 'ы', 'э', 'ю', 'я', 'А', 'Е', 'Ё', 'И', 'О', 'У', 'Ы', 'Э', 'Ю', 'Я'];
        } elseif ($language == 'en') {
            return ['a', 'e', 'i', 'o', 'u', 'y', 'A', 'E', 'I', 'O', 'U', 'Y'];
        }

        return [];
    }

    private function getConsonants(string $language): array
    {
        if ($language == 'ru') {
            return array_diff($this->getRussianLetters(), $this->getVowels('ru'));
        } elseif ($language == 'en') {
            return array_diff($this->getEnglishLetters(), $this->getVowels('en'));
        }

        return [];
    }

    private function getRussianLetters(): array
    {
        return array_merge(
            self::LETTERS_LC_RU,
            self::LETTERS_UC_RU,
        );
    }

    private function getEnglishLetters(): array
    {
        return array_merge(
            range('a', 'z'),
            range('A', 'Z'),
        );
    }
}
