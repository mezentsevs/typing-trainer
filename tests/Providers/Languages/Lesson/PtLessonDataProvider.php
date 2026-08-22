<?php

namespace Tests\Providers\Languages\Lesson;

use App\Languages\PtLanguage;
use Tests\Providers\Languages\Lesson\Contracts\LanguageLessonDataProvider;

class PtLessonDataProvider extends LanguageLessonDataProvider
{
    protected const string LANGUAGE_CODE = PtLanguage::CODE;

    protected const string CHARS = 'asdfghjklçqwertyuiopzxcvbnm,.-áâãàéêíóôõúüASDFGHJKLÇQWERTYUIOPZXCVBNM;:_ÁÂÃÀÉÊÍÓÔÕÚÜ1234567890!"#$%&/()=?«»\\|¬@£§¢€{[]}~^´¨ªº±©®¼½¾×÷*';

    protected const array NEW_CHARS_SEQUENCE = [
        1 => 'asdfghj',
        2 => 'klçqwert',
        3 => 'yuiopzxc',
        4 => 'vbnm,.-á',
        5 => 'âãàéêíóôõ',
        6 => 'úüASDFGHJ',
        7 => 'KLÇQWERTYU',
        8 => 'IOPZXCVBNM;',
        9 => ':_ÁÂÃÀÉÊÍÓÔÕ',
        10 => 'ÚÜ1234567890!',
        11 => '"#$%&/()=?«»\\|',
        12 => '¬@£§¢€{[]}~^´¨ª',
        13 => 'º±©®¼½¾×÷*',
        14 => self::CHARS,
        15 => self::CHARS,
        16 => self::CHARS,
        17 => self::CHARS,
        18 => self::CHARS,
        19 => self::CHARS,
        20 => self::CHARS,
    ];
}
