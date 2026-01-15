<?php

namespace Tests\Traits\Constants;

trait WithLanguageConstants
{
    protected const int INVALID_INT_LANGUAGE = 123;
    protected const string INVALID_EMPTY_LANGUAGE = '';
    protected const string INVALID_SQL_INJECTION_LANGUAGE = "' OR EXISTS(SELECT * FROM users) AND 'a'='a";
}
