<?php

namespace Tests\Providers\Languages\Lesson;

use App\Languages\IdLanguage;
use Tests\Providers\Languages\Lesson\Contracts\LanguageLessonDataProvider;

class IdLessonDataProvider extends LanguageLessonDataProvider
{
    protected const string LANGUAGE_CODE = IdLanguage::CODE;

    protected const string CHARS = 'asdfghjkl;\'qwertyuiop[]\\zxcvbnm,./ASDFGHJKL:"QWERTYUIOP{}|ZXCVBNM<>?`1234567890-=~!@#$%^&*()_+';

    protected const array NEW_CHARS_SEQUENCE = [
        1 => 'asdfg',
        2 => 'hjkl;',
        3 => '\'qwert',
        4 => 'yuiop[',
        5 => ']\\zxcv',
        6 => 'bnm,./A',
        7 => 'SDFGHJK',
        8 => 'L:"QWERT',
        9 => 'YUIOP{}|',
        10 => 'ZXCVBNM<>',
        11 => '?`12345678',
        12 => '90-=~!@#$%^',
        13 => '&*()_+',
        14 => self::CHARS,
        15 => self::CHARS,
        16 => self::CHARS,
        17 => self::CHARS,
        18 => self::CHARS,
        19 => self::CHARS,
        20 => self::CHARS,
    ];
}
