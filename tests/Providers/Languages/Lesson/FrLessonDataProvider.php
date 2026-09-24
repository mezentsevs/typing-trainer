<?php

namespace Tests\Providers\Languages\Lesson;

use App\Languages\FrLanguage;
use Tests\Providers\Languages\Lesson\Contracts\LanguageLessonDataProvider;

class FrLessonDataProvider extends LanguageLessonDataProvider
{
    protected const string LANGUAGE_CODE = FrLanguage::CODE;

    protected const string CHARS = 'qsdfghjklmùazertyuiopwxcvbnéèçàâêîôûëïœQSDFGHJKLMÙAZERTYUIOPWXCVBNÉÈÇÀÂÊÎÔÛËÏŒ1234567890!"#$%&\'()*+,-./:;<=>?@[\\]_{|}€£¤µ§°²äöæüÿÄÖÆÜŸ';

    protected const array NEW_CHARS_SEQUENCE = [
        1 => 'qsdfghj',
        2 => 'klmùazer',
        3 => 'tyuiopwx',
        4 => 'cvbnéèçà',
        5 => 'âêîôûëïœQ',
        6 => 'SDFGHJKLM',
        7 => 'ÙAZERTYUIO',
        8 => 'PWXCVBNÉÈÇÀ',
        9 => 'ÂÊÎÔÛËÏŒ1234',
        10 => '567890!"#$%&\'',
        11 => '()*+,-./:;<=>?',
        12 => '@[\\]_{|}€£¤µ§°²',
        13 => 'äöæüÿÄÖÆÜŸ',
        14 => self::CHARS,
        15 => self::CHARS,
        16 => self::CHARS,
        17 => self::CHARS,
        18 => self::CHARS,
        19 => self::CHARS,
        20 => self::CHARS,
    ];
}
