<?php

namespace Tests\Providers\Languages\Lesson;

use App\Languages\EnLanguage;
use Tests\Providers\Languages\Lesson\Contracts\LanguageLessonDataProvider;

class EnLessonDataProvider extends LanguageLessonDataProvider
{
    protected const string LANGUAGE_CODE = EnLanguage::CODE;

    protected const string CHARS = 'asdfjkl;qwertyuiophgzxcvbnm,./ASDFJKL;QWERTYUIOPHGZXCVBNM,./1234567890-=!@#$%^&*()_+[]{}|\:"\'<>?~`';

    protected const array NEW_CHARS_SEQUENCE = [
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
        14 => self::CHARS,
        15 => self::CHARS,
        16 => self::CHARS,
        17 => self::CHARS,
        18 => self::CHARS,
        19 => self::CHARS,
        20 => self::CHARS,
    ];
}
