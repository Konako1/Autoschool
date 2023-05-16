<?php

namespace App\Common\Helpers;

use Illuminate\Support\Carbon;
use IntlDateFormatter;

class DateFormatter
{
    public static function stringFormat(string $date) {
        return self::format(Carbon::createFromFormat('Y-m-d', $date));
    }

    public static function stringFormatWithTime(string $date) {
        return self::format(Carbon::createFromFormat('Y-m-d H:i:s', $date));
    }

    public static function format(\DateTime $date)
    {
        setlocale(LC_TIME, "de_DE");
        $formatter = new IntlDateFormatter(
            'ru_RU',
            IntlDateFormatter::MEDIUM,
            IntlDateFormatter::SHORT
        );
        $formatter->setPattern('d MMMM Y');
        return $formatter->format($date->getTimestamp());
    }
}
