<?php

namespace Tests\Providers\Languages;

use App\Languages\RuLanguage;
use Tests\Providers\Languages\Contracts\LanguageLessonDataProvider;

class RuLessonDataProvider extends LanguageLessonDataProvider
{
    protected const string LANGUAGE_CODE = RuLanguage::CODE;

    protected const string CHARS = 'фываолджйцукенгшщзхъячсмитьбюпрэёФЫВАОЛДЖЙЦУКЕНГШЩЗХЪЯЧСМИТЬБЮПРЭЁ1234567890-=!"№;%:?*()_+/\,.';

    protected const array NEW_CHARS_SEQUENCE = [
        1 => 'фывао',
        2 => 'лджйц',
        3 => 'укенгш',
        4 => 'щзхъяч',
        5 => 'смитьб',
        6 => 'юпрэёФЫ',
        7 => 'ВАОЛДЖЙ',
        8 => 'ЦУКЕНГШЩ',
        9 => 'ЗХЪЯЧСМИ',
        10 => 'ТЬБЮПРЭЁ1',
        11 => '234567890-',
        12 => '=!"№;%:?*()',
        13 => '_+/\,.',
        14 => self::CHARS,
        15 => self::CHARS,
        16 => self::CHARS,
        17 => self::CHARS,
        18 => self::CHARS,
        19 => self::CHARS,
        20 => self::CHARS,
    ];
}
