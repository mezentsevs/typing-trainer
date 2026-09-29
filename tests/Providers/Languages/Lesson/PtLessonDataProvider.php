<?php

namespace Tests\Providers\Languages\Lesson;

use App\Languages\PtLanguage;
use Tests\Providers\Languages\Lesson\Contracts\LanguageLessonDataProvider;

class PtLessonDataProvider extends LanguageLessonDataProvider
{
    protected const string LANGUAGE_CODE = PtLanguage::CODE;

    protected const string CHARS = 'asdfghjklçºqwertyuiop+<zxcvbnm,.-áéíóúâêôãõASDFGHJKLÇªQWERTYUIOP*>ZXCVBNM;:_ÁÉÍÓÚÂÊÔÃÕ\\1234567890\'«|!"#$%&/()=?»¬@£§¢‡{[]}€©®™àÀ';

    protected const array NEW_CHARS_SEQUENCE = [
        1 => 'asdfghj',
        2 => 'klçºqwe',
        3 => 'rtyuiop+',
        4 => '<zxcvbnm',
        5 => ',.-áéíóú',
        6 => 'âêôãõASDF',
        7 => 'GHJKLÇªQWE',
        8 => 'RTYUIOP*>Z',
        9 => 'XCVBNM;:_ÁÉ',
        10 => 'ÍÓÚÂÊÔÃÕ\\123',
        11 => '4567890\'«|!"#',
        12 => '$%&/()=?»¬@£§¢‡',
        13 => '{[]}€©®™àÀ',
        14 => self::CHARS,
        15 => self::CHARS,
        16 => self::CHARS,
        17 => self::CHARS,
        18 => self::CHARS,
        19 => self::CHARS,
        20 => self::CHARS,
    ];
}
