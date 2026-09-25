<?php

namespace Tests\Providers\Languages\Lesson;

use App\Languages\IdLanguage;
use Tests\Providers\Languages\Lesson\Contracts\LanguageLessonDataProvider;

class IdLessonDataProvider extends LanguageLessonDataProvider
{
    protected const string LANGUAGE_CODE = IdLanguage::CODE;

    protected const string CHARS = 'asdfjkl;qwertyuiophgzxcvbnm,./ASDFJKLQWERTYUIOPHGZXCVBNM1234567890-=!@#$%^&*()_+[]{}|\\:"\'<>?~`';

    protected const array NEW_CHARS_SEQUENCE = [
        1 => 'asdfj',
        2 => 'kl;qw',
        3 => 'ertyui',
        4 => 'ophgzx',
        5 => 'cvbnm,',
        6 => './ASDFJ',
        7 => 'KLQWERT',
        8 => 'YUIOPHGZ',
        9 => 'XCVBNM12',
        10 => '34567890-',
        11 => '=!@#$%^&*(',
        12 => ')_+[]{}|\\:"',
        13 => '\'<>?~`',
        14 => self::CHARS,
        15 => self::CHARS,
        16 => self::CHARS,
        17 => self::CHARS,
        18 => self::CHARS,
        19 => self::CHARS,
        20 => self::CHARS,
    ];
}
