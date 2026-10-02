<?php

namespace Tests\Providers\Languages\Lesson;

use App\Languages\RuLanguage;
use Tests\Providers\Languages\Lesson\Contracts\LanguageLessonDataProvider;

class RuLessonDataProvider extends LanguageLessonDataProvider
{
    protected const string LANGUAGE_CODE = RuLanguage::CODE;

    protected const string CHARS = 'фывапролджэйцукенгшщзхъ\\ячсмитьбю.ФЫВАПРОЛДЖЭЙЦУКЕНГШЩЗХЪ/ЯЧСМИТЬБЮ,ё1234567890-=Ё!"№;%:?*()_+';

    protected const array NEW_CHARS_SEQUENCE = [
        1 => 'фывап',
        2 => 'ролдж',
        3 => 'эйцуке',
        4 => 'нгшщзх',
        5 => 'ъ\\ячсм',
        6 => 'итьбю.Ф',
        7 => 'ЫВАПРОЛ',
        8 => 'ДЖЭЙЦУКЕ',
        9 => 'НГШЩЗХЪ/',
        10 => 'ЯЧСМИТЬБЮ',
        11 => ',ё12345678',
        12 => '90-=Ё!"№;%:',
        13 => '?*()_+',
        14 => self::CHARS,
        15 => self::CHARS,
        16 => self::CHARS,
        17 => self::CHARS,
        18 => self::CHARS,
        19 => self::CHARS,
        20 => self::CHARS,
    ];
}
