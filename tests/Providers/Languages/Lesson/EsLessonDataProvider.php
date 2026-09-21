<?php

namespace Tests\Providers\Languages\Lesson;

use App\Languages\EsLanguage;
use Tests\Providers\Languages\Lesson\Contracts\LanguageLessonDataProvider;

class EsLessonDataProvider extends LanguageLessonDataProvider
{
    protected const string LANGUAGE_CODE = EsLanguage::CODE;

    protected const string CHARS = 'asdfghjklñqwertyuiopzxcvbnm,.-áéíóúüASDFGHJKLÑQWERTYUIOPZXCVBNM;:_ÁÉÍÓÚÜ1234567890!"·$%&/()=?¿¡ºª\\|@#~€¬{[]}*+\'<>ýàèìòùỳâêîôûŷäëïöÿÝÀÈÌÒÙỲÂÊÎÔÛŶÄËÏÖŸ';

    protected const array NEW_CHARS_SEQUENCE = [
        1 => 'asdfghjk',
        2 => 'lñqwerty',
        3 => 'uiopzxcvb',
        4 => 'nm,.-áéíó',
        5 => 'úüASDFGHJK',
        6 => 'LÑQWERTYUI',
        7 => 'OPZXCVBNM;:',
        8 => '_ÁÉÍÓÚÜ12345',
        9 => '67890!"·$%&/(',
        10 => ')=?¿¡ºª\\|@#~€¬',
        11 => '{[]}*+\'<>ýàèìòù',
        12 => 'ỳâêîôûŷäëïöÿÝÀÈÌÒ',
        13 => 'ÙỲÂÊÎÔÛŶÄËÏÖŸ',
        14 => self::CHARS,
        15 => self::CHARS,
        16 => self::CHARS,
        17 => self::CHARS,
        18 => self::CHARS,
        19 => self::CHARS,
        20 => self::CHARS,
    ];
}
