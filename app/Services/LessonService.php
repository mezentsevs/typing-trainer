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

    protected $pairedMap = [
        '(' => ')',
        '[' => ']',
        '{' => '}',
        '<' => '>',
        '"' => '"',
        "'" => "'",
        '`' => '`'
    ];

    protected $minLessonLength = 100;
    protected $maxLessonLength = 1000;
    protected $minWordsPerLine = 2;
    protected $maxWordsPerLine = 8;

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

    public function generateLessonText(string $language, int $lessonNumber, int $userId, ?int $length = null): string
    {
        $availableChars = '';
        $newChars = '';

        $lessons = Lesson::where('language', $language)->where('user_id', $userId)->where('number', '<=', $lessonNumber)->get();
        foreach ($lessons as $lesson) {
            $availableChars .= $lesson->new_chars;
            if ($lesson->number == $lessonNumber) {
                $newChars = $lesson->new_chars;
            }
        }

        $availableCharsArray = mb_str_split($availableChars, 1, 'UTF-8');
        $newCharsArray = mb_str_split($newChars, 1, 'UTF-8');

        if (empty($availableCharsArray)) {
            return '';
        }

        $totalLessons = Lesson::where('language', $language)->where('user_id', $userId)->max('number') ?? 1;
        if ($length === null) {
            if ($totalLessons <= 1) {
                $length = $this->minLessonLength;
            } else {
                $length = $this->minLessonLength + ($this->maxLessonLength - $this->minLessonLength) * ($lessonNumber - 1) / ($totalLessons - 1);
            }
        }

        $text = '';
        $wordsAdded = 0;
        $lineWordCount = 0;
        $currentLineWords = random_int($this->minWordsPerLine, $this->maxWordsPerLine);
        $isFirstOfPair = true;
        $baseWord = null;

        while (mb_strlen($text) < $length) {
            if ($wordsAdded > 0) {
                if ($lineWordCount >= $currentLineWords) {
                    $separator = "\n";
                    $lineWordCount = 0;
                    $currentLineWords = random_int($this->minWordsPerLine, $this->maxWordsPerLine);
                } else {
                    $separator = " ";
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
                    $remainingAfterFirst -= mb_strlen($separator);
                }
                $remainingAfterSecond = $remainingAfterFirst - mb_strlen(" ") - mb_strlen($currentWord);

                if ($remainingAfterFirst < 0 || $remainingAfterSecond < 0) {
                    break;
                }

                if ($lineWordCount + 2 > $currentLineWords) {
                    $text .= "\n";
                    $lineWordCount = 0;
                    $currentLineWords = random_int($this->minWordsPerLine, $this->maxWordsPerLine);
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

        $text = rtrim($text, " \n");

        return mb_substr($text, 0, $length);
    }

    private function generateEnhancedWord(array $availableCharsArray, array $newCharsArray, string $language): string
    {
        $availableLetters = array_filter($availableCharsArray, function ($char) {
            return preg_match('/[a-zA-Zа-яА-ЯёЁ0-9]/u', $char);
        });

        $newLetters = array_filter($newCharsArray, function ($char) {
            return preg_match('/[a-zA-Zа-яА-ЯёЁ0-9]/u', $char);
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

        $availableSpecials = array_filter($availableCharsArray, function ($char) {
            return !preg_match('/[a-zA-Z0-9а-яА-ЯёЁ]/u', $char);
        });

        $pairedSymbols = array_merge(array_keys($this->pairedMap), array_values($this->pairedMap));
        $singleSpecials = array_diff($availableSpecials, $pairedSymbols);

        $possiblePairedOpenings = ['(', '[', '{', '<', '"', "'", '`'];
        $availablePairedOpenings = array_intersect($possiblePairedOpenings, $availableSpecials);
        $availablePaired = [];

        foreach ($availablePairedOpenings as $opening) {
            if (in_array($this->pairedMap[$opening], $availableSpecials)) {
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
            $closing = $this->pairedMap[$opening];
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
            ['а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'],
            ['А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я']
        );
    }

    private function getEnglishLetters(): array
    {
        return array_merge(
            range('a', 'z'),
            range('A', 'Z')
        );
    }
}
