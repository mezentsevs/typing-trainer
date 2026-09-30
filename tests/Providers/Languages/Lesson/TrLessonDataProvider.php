<?php

namespace Tests\Providers\Languages\Lesson;

use App\Languages\TrLanguage;
use Tests\Providers\Languages\Lesson\Contracts\LanguageLessonDataProvider;

class TrLessonDataProvider extends LanguageLessonDataProvider
{
    protected const string LANGUAGE_CODE = TrLanguage::CODE;

    protected const string CHARS = 'asdfghjklşiqwertyuıopğü,<zxcvbnmöç.ASDFGHJKLŞİQWERTYUIOPĞÜ;>ZXCVBNMÖÇ:"1234567890*-é!\'^+%&/()=?_¡¢£¤¥§¶•ªº×–@€¨~æß|\\';

    protected const array NEW_CHARS_SEQUENCE = [
        1 => 'asdfgh',
        2 => 'jklşiqw',
        3 => 'ertyuıo',
        4 => 'pğü,<zx',
        5 => 'cvbnmöç.',
        6 => 'ASDFGHJK',
        7 => 'LŞİQWERTY',
        8 => 'UIOPĞÜ;>Z',
        9 => 'XCVBNMÖÇ:"',
        10 => '1234567890*',
        11 => '-é!\'^+%&/()=',
        12 => '?_¡¢£¤¥§¶•ªº×',
        13 => '–@€¨~æß|\\',
        14 => self::CHARS,
        15 => self::CHARS,
        16 => self::CHARS,
        17 => self::CHARS,
        18 => self::CHARS,
        19 => self::CHARS,
        20 => self::CHARS,
    ];
}
