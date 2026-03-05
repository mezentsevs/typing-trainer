<?php

namespace App\Enums;

enum Genre: string
{
    case None = '';
    case Fiction = 'fiction';
    case NonFiction = 'non-fiction';
    case Poetry = 'poetry';
    case Unknown = 'unknown';
}
