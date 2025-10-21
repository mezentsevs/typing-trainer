<?php

namespace Tests\Traits\Constants;

trait WithStatisticsConstants
{
    protected const int ERRORS_COUNT = 2;
    protected const int SPEED_WPM = 50;
    protected const int TIME_SECONDS = 60;

    protected const int ZERO_ERRORS_COUNT = 0;
    protected const int ZERO_SPEED_WPM = 0;
    protected const int ZERO_TIME_SECONDS = 0;

    protected const int INVALID_ERRORS_COUNT = -1;
    protected const int INVALID_SPEED_WPM = -1;
    protected const int INVALID_TIME_SECONDS = -1;
}
