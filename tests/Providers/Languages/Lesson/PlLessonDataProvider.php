<?php

namespace Tests\Providers\Languages\Lesson;

use App\Languages\PlLanguage;
use Tests\Providers\Languages\Lesson\Contracts\LanguageLessonDataProvider;

class PlLessonDataProvider extends LanguageLessonDataProvider
{
    protected const string LANGUAGE_CODE = PlLanguage::CODE;

    protected const string CHARS = 'aąsśdfghjklł;\'weęrtyuioóp[]\\<zżźcćbnńm,./AĄSŚDFGHJKLŁWEĘRTYUIOÓP>ZŻŹCĆBNŃM1234567890-=!@#$%^&*()_+`~:"{}|?€qvxQVX';

    protected const array NEW_CHARS_SEQUENCE = [
        1 => 'aąsśdf',
        2 => 'ghjklł',
        3 => ';\'weęrt',
        4 => 'yuioóp[',
        5 => ']\\<zżźcć',
        6 => 'bnńm,./A',
        7 => 'ĄSŚDFGHJK',
        8 => 'LŁWEĘRTYU',
        9 => 'IOÓP>ZŻŹCĆ',
        10 => 'BNŃM1234567',
        11 => '890-=!@#$%^&',
        12 => '*()_+`~:"{}|?',
        13 => '€qvxQVX',
        14 => self::CHARS,
        15 => self::CHARS,
        16 => self::CHARS,
        17 => self::CHARS,
        18 => self::CHARS,
        19 => self::CHARS,
        20 => self::CHARS,
    ];
}
