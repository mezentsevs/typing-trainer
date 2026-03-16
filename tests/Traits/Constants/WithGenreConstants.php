<?php

namespace Tests\Traits\Constants;

trait WithGenreConstants
{
    protected const string INVALID_SQL_INJECTION_GENRE = "' OR EXISTS(SELECT * FROM users) AND 'a'='a";
}
