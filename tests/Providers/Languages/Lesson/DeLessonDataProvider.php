<?php

namespace Tests\Providers\Languages\Lesson;

use App\Languages\DeLanguage;
use Tests\Providers\Languages\Lesson\Contracts\LanguageLessonDataProvider;

class DeLessonDataProvider extends LanguageLessonDataProvider
{
    protected const string LANGUAGE_CODE = DeLanguage::CODE;

    protected const string CHARS = 'asdfghjklöä#qwertzuiopü+\\yxcvbnm,.-ßASDFGHJKLÖÄQWERTZUIOPÜYXCVBNM;:_1234567890!"§$%&/()=?`°²³{[]}~|@€µ\'';

    protected const array NEW_CHARS_SEQUENCE = [
        1 => 'asdfgh',
        2 => 'jklöä#',
        3 => 'qwertz',
        4 => 'uiopü+\\',
        5 => 'yxcvbnm',
        6 => ',.-ßASD',
        7 => 'FGHJKLÖÄ',
        8 => 'QWERTZUI',
        9 => 'OPÜYXCVBN',
        10 => 'M;:_123456',
        11 => '7890!"§$%&/',
        12 => '()=?`°²³{[]}',
        13 => '~|@€µ\'',
        14 => self::CHARS,
        15 => self::CHARS,
        16 => self::CHARS,
        17 => self::CHARS,
        18 => self::CHARS,
        19 => self::CHARS,
        20 => self::CHARS,
    ];
}
