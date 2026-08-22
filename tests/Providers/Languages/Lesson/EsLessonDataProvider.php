<?php

namespace Tests\Providers\Languages\Lesson;

use App\Languages\EsLanguage;
use Tests\Providers\Languages\Lesson\Contracts\LanguageLessonDataProvider;

class EsLessonDataProvider extends LanguageLessonDataProvider
{
    protected const string LANGUAGE_CODE = EsLanguage::CODE;

    protected const string CHARS = 'asdfghjklñqwertyuiopzxcvbnm,.-áéíóúüASDFGHJKLÑQWERTYUIOPZXCVBNM;:_1234567890!"·$%&/()=?¿¡ºª\\|@#~€¬{[]}`^*\'';

    protected const array NEW_CHARS_SEQUENCE = [
        1 => 'asdfgh',
        2 => 'jklñqw',
        3 => 'ertyui',
        4 => 'opzxcvb',
        5 => 'nm,.-áé',
        6 => 'íóúüASDF',
        7 => 'GHJKLÑQW',
        8 => 'ERTYUIOPZ',
        9 => 'XCVBNM;:_',
        10 => '1234567890',
        11 => '!"·$%&/()=?',
        12 => '¿¡ºª\\|@#~€¬{',
        13 => '[]}`^*\'',
        14 => self::CHARS,
        15 => self::CHARS,
        16 => self::CHARS,
        17 => self::CHARS,
        18 => self::CHARS,
        19 => self::CHARS,
        20 => self::CHARS,
    ];
}
