<?php

namespace Tests\Traits\Constants;

trait WithAuthConstants
{
    protected const string REGISTER_URI = '/api/register';
    protected const string LOGIN_URI = '/api/login';
    protected const string LOGOUT_URI = '/api/logout';

    protected const string TOKEN_NAME = 'testToken';
    protected const string ANOTHER_TOKEN_NAME = 'anotherToken';

    protected const int MAX_EMAIL_LENGTH = 255;
    protected const string EMAIL = 'test@example.com';
    protected const string EMAIL_WITH_SQL_INJECTION = "test'; DROP TABLE users;--@example.com";
    protected const string EMAIL_DOMAIN = '@example.com';
    protected const string INVALID_EMAIL = 'invalidEmail';
    protected const string INVALID_EMPTY_EMAIL = '';

    protected const int MAX_USER_NAME_LENGTH = 255;
    protected const string USER_NAME = 'Test User';
    protected const string USER_NAME_WITH_SQL_INJECTION = "Test'; DROP TABLE users;--";
    protected const string ANOTHER_USER_NAME = 'Another User';
    protected const string INVALID_EMPTY_USER_NAME = '';

    protected const int MIN_PASSWORD_LENGTH = 8;
    protected const int MAX_PASSWORD_LENGTH = 255;
    protected const string PASSWORD = 'password';
    protected const string PASSWORD_WITH_SQL_INJECTION = "'; DROP TABLE users;--";
    protected const string ANOTHER_PASSWORD = 'anotherPassword';
    protected const string INVALID_EMPTY_PASSWORD = '';
}
