<?php

namespace Tests\Providers\Languages\Lesson;

use App\Languages\PlLanguage;
use Tests\Providers\Languages\Lesson\Contracts\LanguageLessonDataProvider;

class PlLessonDataProvider extends LanguageLessonDataProvider
{
    protected const string LANGUAGE_CODE = PlLanguage::CODE;

    protected const string CHARS = 'asdfghjkl;qwertyuiopzxcvbnm,./ąęóśłżźćńASDFGHJKL:QWERTYUIOPZXCVBNM<>?ĄĘÓŚŁŻŹĆŃ1234567890!@#$%^&*()-=+[]{}|\\"\'~`_€';

    protected const array NEW_CHARS_SEQUENCE = [
        1 => 'asdfgh',
        2 => 'jkl;qw',
        3 => 'ertyuio',
        4 => 'pzxcvbn',
        5 => 'm,./ąęóś',
        6 => 'łżźćńASD',
        7 => 'FGHJKL:QW',
        8 => 'ERTYUIOPZ',
        9 => 'XCVBNM<>?Ą',
        10 => 'ĘÓŚŁŻŹĆŃ123',
        11 => '4567890!@#$%',
        12 => '^&*()-=+[]{}|',
        13 => '\\"\'~`_€',
        14 => self::CHARS,
        15 => self::CHARS,
        16 => self::CHARS,
        17 => self::CHARS,
        18 => self::CHARS,
        19 => self::CHARS,
        20 => self::CHARS,
    ];
}
