<?php

namespace Tests\Traits\Constants;

trait WithStatisticsConstants
{
    protected const int TIME_SECONDS = 60;
    protected const int ZERO_TIME_SECONDS = 0;
    protected const int INVALID_INT_TIME_SECONDS = -1;
    protected const bool INVALID_BOOL_TIME_SECONDS = true;
    protected const string INVALID_STRING_TIME_SECONDS = 'invalidStringTimeSeconds';
    protected const float INVALID_FLOAT_TIME_SECONDS = 60.5;

    protected const int SPEED_WPM = 50;
    protected const int ZERO_SPEED_WPM = 0;
    protected const int INVALID_INT_SPEED_WPM = -1;
    protected const bool INVALID_BOOL_SPEED_WPM = true;
    protected const string INVALID_STRING_SPEED_WPM = 'invalidStringSpeedWpm';

    protected const int ERRORS_COUNT = 2;
    protected const int ZERO_ERRORS_COUNT = 0;
    protected const int INVALID_INT_ERRORS_COUNT = -1;
    protected const bool INVALID_BOOL_ERRORS_COUNT = true;
    protected const string INVALID_STRING_ERRORS_COUNT = 'invalidStringErrorsCount';
}
