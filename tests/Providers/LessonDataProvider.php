<?php

namespace Tests\Providers;

use App\Enums\Language;

class LessonDataProvider
{
    protected const CHARS_EN = 'asdfjkl;qwertyuiophgzxcvbnm,./ASDFJKL;QWERTYUIOPHGZXCVBNM,./1234567890-=!@#$%^&*()_+[]{}|\:"\'<>?~`';

    protected const CHARS_RU = 'фываолджйцукенгшщзхъячсмитьбюпрэёФЫВАОЛДЖЙЦУКЕНГШЩЗХЪЯЧСМИТЬБЮПРЭЁ1234567890-=!"№;%:?*()_+/\,.';

    protected const NEW_CHARS_SEQUENCE_EN = [
        1 => 'asdfj',
        2 => 'kl;qwe',
        3 => 'rtyuio',
        4 => 'phgzxc',
        5 => 'vbnm,./',
        6 => 'ASDFJKL',
        7 => ';QWERTY',
        8 => 'UIOPHGZX',
        9 => 'CVBNM,./1',
        10 => '234567890',
        11 => '-=!@#$%^&*',
        12 => '()_+[]{}|\:',
        13 => '"\'<>?~`',
        14 => self::CHARS_EN,
        15 => self::CHARS_EN,
        16 => self::CHARS_EN,
        17 => self::CHARS_EN,
        18 => self::CHARS_EN,
        19 => self::CHARS_EN,
        20 => self::CHARS_EN,
    ];

    protected const NEW_CHARS_SEQUENCE_RU = [
        1 => 'фывао',
        2 => 'лджйц',
        3 => 'укенгш',
        4 => 'щзхъяч',
        5 => 'смитьб',
        6 => 'юпрэёФЫ',
        7 => 'ВАОЛДЖЙ',
        8 => 'ЦУКЕНГШЩ',
        9 => 'ЗХЪЯЧСМИ',
        10 => 'ТЬБЮПРЭЁ1',
        11 => '234567890-',
        12 => '=!"№;%:?*()',
        13 => '_+/\,.',
        14 => self::CHARS_RU,
        15 => self::CHARS_RU,
        16 => self::CHARS_RU,
        17 => self::CHARS_RU,
        18 => self::CHARS_RU,
        19 => self::CHARS_RU,
        20 => self::CHARS_RU,
    ];

    public static function provideLessonsSequenceData(): array
    {
        $data = [];
        $availableCharsEn = '';
        $availableCharsRu = '';

        $lessonCountEn = count(self::NEW_CHARS_SEQUENCE_EN);
        $lessonCountRu = count(self::NEW_CHARS_SEQUENCE_RU);

        foreach (self::NEW_CHARS_SEQUENCE_EN as $number => $newChars) {
            if ($availableCharsEn !== self::CHARS_EN) {
                $availableCharsEn .= $newChars;
            }

            $data["en_{$number}"] = [[
                'language' => Language::En->value,
                'lessonCount' => $lessonCountEn,
                'lessonNumber' => $number,
                'expectedNewChars' => $newChars,
                'expectedAvailableChars' => $availableCharsEn,
            ]];
        }

        foreach (self::NEW_CHARS_SEQUENCE_RU as $number => $newChars) {
            if ($availableCharsRu !== self::CHARS_RU) {
                $availableCharsRu .= $newChars;
            }

            $data["ru_{$number}"] = [[
                'language' => Language::Ru->value,
                'lessonCount' => $lessonCountRu,
                'lessonNumber' => $number,
                'expectedNewChars' => $newChars,
                'expectedAvailableChars' => $availableCharsRu,
            ]];
        }

        return $data;
    }
}
