<?php

namespace Tests\Providers\Languages\Lesson;

use App\Languages\EsLanguage;
use Tests\Providers\Languages\Lesson\Contracts\LanguageLessonDataProvider;

class EsLessonDataProvider extends LanguageLessonDataProvider
{
    protected const string LANGUAGE_CODE = EsLanguage::CODE;

    protected const string CHARS = 'asdfghjklñqwertyuiop+<zxcvbnm,.-áéíóúüASDFGHJKLÑQWERTYUIOP*>ZXCVBNM;:_ÁÉÍÓÚÜº1234567890\'¡ª!"·$%&/()=?¿\\|@#~€¬[]{}àèìòùỳâêîôûŷäëïöÿýÀÈÌÒÙỲÂÊÎÔÛŶÄËÏÖŸÝ';

    protected const array NEW_CHARS_SEQUENCE = [
        1 => 'asdfghjk',
        2 => 'lñqwerty',
        3 => 'uiop+<zxc',
        4 => 'vbnm,.-áé',
        5 => 'íóúüASDFGH',
        6 => 'JKLÑQWERTY',
        7 => 'UIOP*>ZXCVB',
        8 => 'NM;:_ÁÉÍÓÚÜº',
        9 => '1234567890\'¡ª',
        10 => '!"·$%&/()=?¿\\|',
        11 => '@#~€¬[]{}àèìòùỳ',
        12 => 'âêîôûŷäëïöÿýÀÈÌÒÙ',
        13 => 'ỲÂÊÎÔÛŶÄËÏÖŸÝ',
        14 => self::CHARS,
        15 => self::CHARS,
        16 => self::CHARS,
        17 => self::CHARS,
        18 => self::CHARS,
        19 => self::CHARS,
        20 => self::CHARS,
    ];
}
