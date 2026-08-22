<?php

namespace Tests\Providers\Languages\Lesson;

use App\Languages\TrLanguage;
use Tests\Providers\Languages\Lesson\Contracts\LanguageLessonDataProvider;

class TrLessonDataProvider extends LanguageLessonDataProvider
{
    protected const string LANGUAGE_CODE = TrLanguage::CODE;

    protected const string CHARS = 'asdfghjklşiqwertyuıopğüzxcvbnmöç.ASDFGHJKLŞİQWERTYUIOPĞÜZXCVBNMÖÇ:1234567890!@#$%^&*()-=+[]{}|\\:"\'<>?~`,.;¡¢£¤¥§¶•ªº×–≠€®™←↑↓→þ¨æ´÷©»«‹›°µß';

    protected const array NEW_CHARS_SEQUENCE = [
        1 => 'asdfghj',
        2 => 'klşiqwer',
        3 => 'tyuıopğü',
        4 => 'zxcvbnmöç',
        5 => '.ASDFGHJK',
        6 => 'LŞİQWERTYU',
        7 => 'IOPĞÜZXCVB',
        8 => 'NMÖÇ:123456',
        9 => '7890!@#$%^&*',
        10 => '()-=+[]{}|\\:"',
        11 => '\'<>?~`,.;¡¢£¤¥',
        12 => '§¶•ªº×–≠€®™←↑↓→þ',
        13 => '¨æ´÷©»«‹›°µß',
        14 => self::CHARS,
        15 => self::CHARS,
        16 => self::CHARS,
        17 => self::CHARS,
        18 => self::CHARS,
        19 => self::CHARS,
        20 => self::CHARS,
    ];
}
