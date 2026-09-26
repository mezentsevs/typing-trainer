<?php

namespace Tests\Providers\Languages\Lesson;

use App\Languages\ItLanguage;
use Tests\Providers\Languages\Lesson\Contracts\LanguageLessonDataProvider;

class ItLessonDataProvider extends LanguageLessonDataProvider
{
    protected const string LANGUAGE_CODE = ItLanguage::CODE;

    protected const string CHARS = 'asdfghjklòàùqwertyuiopè+<zxcvbnm,.-ìéASDFGHJKLÒÀÙQWERTYUIOPÈ>ZXCVBNMÌ1234567890!"£$%&/()=?^*°§;:_\\|\'@#[]{}€ç';

    protected const array NEW_CHARS_SEQUENCE = [
        1 => 'asdfgh',
        2 => 'jklòàù',
        3 => 'qwerty',
        4 => 'uiopè+<',
        5 => 'zxcvbnm',
        6 => ',.-ìéASD',
        7 => 'FGHJKLÒÀ',
        8 => 'ÙQWERTYUI',
        9 => 'OPÈ>ZXCVB',
        10 => 'NMÌ1234567',
        11 => '890!"£$%&/(',
        12 => ')=?^*°§;:_\\|',
        13 => '\'@#[]{}€ç',
        14 => self::CHARS,
        15 => self::CHARS,
        16 => self::CHARS,
        17 => self::CHARS,
        18 => self::CHARS,
        19 => self::CHARS,
        20 => self::CHARS,
    ];
}
