<?php

namespace Tests\Providers\Languages\Lesson;

use App\Languages\FrLanguage;
use Tests\Providers\Languages\Lesson\Contracts\LanguageLessonDataProvider;

class FrLessonDataProvider extends LanguageLessonDataProvider
{
    protected const string LANGUAGE_CODE = FrLanguage::CODE;

    protected const string CHARS = 'azertyuiopqsdfghjklmwxcvbn,.;:!?1234567890-=+àâæçéèêëîïôœùûüÿAZERTYUIOPQSDFGHJKLMWXCVBNÀÂÆÇÉÈÊËÎÏÔŒÙÛÜŸ[]{}|\\"\'<>~`@#$%^&*()€£¤µ§°±²³';

    protected const array NEW_CHARS_SEQUENCE = [
        1 => 'azertyu',
        2 => 'iopqsdf',
        3 => 'ghjklmwx',
        4 => 'cvbn,.;:',
        5 => '!?1234567',
        6 => '890-=+àâæ',
        7 => 'çéèêëîïôœù',
        8 => 'ûüÿAZERTYUI',
        9 => 'OPQSDFGHJKLM',
        10 => 'WXCVBNÀÂÆÇÉÈÊ',
        11 => 'ËÎÏÔŒÙÛÜŸ[]{}|',
        12 => '\\"\'<>~`@#$%^&*(',
        13 => ')€£¤µ§°±²³',
        14 => self::CHARS,
        15 => self::CHARS,
        16 => self::CHARS,
        17 => self::CHARS,
        18 => self::CHARS,
        19 => self::CHARS,
        20 => self::CHARS,
    ];
}
