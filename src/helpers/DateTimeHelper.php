<?php

namespace wajox\yii2base\helpers;

class DateTimeHelper
{
    const FORMAT_DATETIME = 'd.m.Y H:i';
    const FORMAT_DATE = 'd.m.Y';
    const FORMAT_TIME = 'H:i';

    const INTERVAL_CUSTOM = 'custom';
    const INTERVAL_TODAY = 'today';
    const INTERVAL_YESTERDAY = 'yesterday';
    const INTERVAL_WEEK = 'week';
    const INTERVAL_MONTH = 'month';
    const INTERVAL_HALFYEAR = 'halfyear';
    const INTERVAL_YEAR = 'year';
    const INTERVAL_ALL = 'all';

    const STEP_HOUR = 'hour';
    const STEP_DAY = 'day';
    const STEP_WEEK = 'week';
    const STEP_MONTH = 'month';
    const STEP_ALL = 'all';

    public static function getIntervalStepsList()
    {
        return [
            self::STEP_HOUR => \Yii::t('app', 'Time Step Hour'),
            self::STEP_DAY => \Yii::t('app', 'Time Step Day'),
            self::STEP_WEEK => \Yii::t('app', 'Time Step Week'),
            self::STEP_MONTH => \Yii::t('app', 'Time Step Month'),
            self::STEP_ALL => \Yii::t('app', 'Time Step All'),
        ];
    }

    public static function getIntervalsList()
    {
        return [
            self::INTERVAL_CUSTOM => \Yii::t('app', 'Custom'),
            self::INTERVAL_TODAY => \Yii::t('app', 'Today'),
            self::INTERVAL_YESTERDAY => \Yii::t('app', 'Yesterday'),
            self::INTERVAL_WEEK => \Yii::t('app', 'Week'),
            self::INTERVAL_MONTH => \Yii::t('app', 'Month'),
            self::INTERVAL_HALFYEAR => \Yii::t('app', 'Halfyear'),
            self::INTERVAL_YEAR => \Yii::t('app', 'Year'),
            self::INTERVAL_ALL => \Yii::t('app', 'All'),
        ];
    }

    public static function getMonthsList()
    {
        return [
                \Yii::t('app', 'Month Jan'),
                \Yii::t('app', 'Month Feb'),
                \Yii::t('app', 'Month Mar'),
                \Yii::t('app', 'Month Apr'),
                \Yii::t('app', 'Month May'),
                \Yii::t('app', 'Month Jun'),
                \Yii::t('app', 'Month Jul'),
                \Yii::t('app', 'Month Aug'),
                \Yii::t('app', 'Month Sep'),
                \Yii::t('app', 'Month Oct'),
                \Yii::t('app', 'Month Nov'),
                \Yii::t('app', 'Month Dec'),
            ];
    }

    public static function getWeekDaysList()
    {
        return [
                \Yii::t('app', 'Week Day Mon'),
                \Yii::t('app', 'Week Day Tue'),
                \Yii::t('app', 'Week Day Wed'),
                \Yii::t('app', 'Week Day Thu'),
                \Yii::t('app', 'Week Day Fri'),
                \Yii::t('app', 'Week Day Sat'),
                \Yii::t('app', 'Week Day Sun'),
            ];
    }

    public static function getMonth($timestamp = null)
    {
        $timestamp = $timestamp ?: time();

        $month = (int) date('m', $timestamp);

        return self::getMonthsList()[$month - 1];
    }

    public static function getWeekDay($timestamp = null)
    {
        $timestamp = $timestamp ?: time();

        $weekDay = (int) date('w', $timestamp);

        return self::getWeekDaysList()[$weekDay];
    }

    public static function getMonthYear($timestamp = null)
    {
        $timestamp = $timestamp ?: time();

        $year = date('Y', $timestamp);

        return self::getMonth($timestamp) . ' ' . $year;
    }

    public static function getDayMonth($timestamp = null)
    {
        $timestamp = $timestamp ?: time();

        $day = (int) date('d', $timestamp);

        return $day . ' ' . self::getMonth($timestamp);
    }

    public static function getDayTime($timestamp = null)
    {
        $timestamp = $timestamp ?: time();

        $day = self::getWeekDay($timestamp);

        return $day . ' ' . self::getPrettyTime($timestamp);
    }

    public static function getTime($timestamp = null)
    {
        $timestamp = $timestamp ?: time();

        return date(self::FORMAT_TIME, $timestamp);
    }

    public static function getDate($timestamp = null)
    {
        $timestamp = $timestamp ?: time();

        return date(self::FORMAT_DATE, $timestamp);
    }

    public static function getDateTime($timestamp = null)
    {
        $timestamp = $timestamp ?: time();

        return date(self::FORMAT_DATETIME, $timestamp);
    }

    public static function getPrettyTime($timestamp = null)
    {
        $timestamp = $timestamp ?: time();

        $current = time();
        $timeSize = $current - $timestamp;

        if ($timeSize < 60) {
            return \Yii::t('app', 'Time Right Now');
        }

        if ($timeSize < 3600) {
            return \Yii::t('app', 'Time {minutes} Ago', [
                    'minutes' => intval($timeSize / 60),
                ]);
        }

        if ($timeSize < 3600 * 3) {
            return \Yii::t('app', 'Time {hours} Ago', [
                    'hours' => intval($timeSize / 3600),
                ]);
        }

        return date(self::FORMAT_TIME, $timestamp);
    }

    public static function getPrettyDate($timestamp = null)
    {
        $timestamp = $timestamp ?: time();

        if (date('dmY') == date('dmY', $timestamp)) {
            return \Yii::t('app', 'Date Today');
        }

        if (date('dmY', strtotime('-1 day')) == date('dmY', $timestamp)) {
            return \Yii::t('app', 'Date Yesterday');
        }

        if (date('Y') == date('Y', $timestamp)) {
            return self::getDayMonth($timestamp);
        }

        return date(self::FORMAT_DATE, $timestamp);
    }

    public static function getPrettyDateTime($timestamp = null)
    {
        $timestamp = $timestamp ?: time();
        $date = self::getPrettyDate($timestamp);
        $time = self::getTime($timestamp);

        return $date . ' ' . $time;
    }

    public static function getLifeTime($timestamp)
    {
        $result = '';
        $lifetime = time() - $timestamp;

        $seconds = $lifetime % 60;
        $t = self::getEnd($seconds, ['секунда', 'секунды', 'секунд']);
        $result = $seconds.' '.$t.' ';
        $lifetime -= $seconds;

        if ($lifetime == 0) {
            return $result;
        }

        $minutes = ($lifetime % 3600) / 60;
        $t = self::getEnd($minutes, ['минута', 'минуты', 'минут']);
        $result = $minutes.' '.$t.' '.$result;
        $lifetime -= $minutes * 60;

        if ($lifetime == 0) {
            return $result;
        }

        $hours = ($lifetime % (24 * 3600)) / 3600;
        $t = self::getEnd($hours, ['час', 'часа', 'часов']);
        $result = $hours.' '.$t.' '.$result;
        $lifetime -= $hours * 3600;

        if ($lifetime == 0) {
            return $result;
        }

        $days = ($lifetime % (24 * 3600 * 30)) / (24 * 3600);
        $t = self::getEnd($days, ['день', 'дня', 'дней']);
        $result = $days.' '.$t.' '.$result;
        $lifetime -= $days * 24 * 3600;

        if ($lifetime == 0) {
            return $result;
        }

        $months = ($lifetime % (24 * 3600 * 30 * 12)) / (24 * 3600 * 30);
        $t = self::getEnd($months, ['месяц', 'месяца', 'месяцев']);
        $result = $months.' '.$t.' '.$result;
        $lifetime -= $months * 24 * 3600 * 30;

        if ($lifetime == 0) {
            return $result;
        }

        $years = $lifetime / (24 * 3600 * 30 * 12);
        $t = self::getEnd($years, ['год', 'года', 'лет']);
        $result = $years.' '.$t.' '.$result;

        return $result;
    }

    public static function getEnd($n, $variants)
    {
        if ($n == 1 || $n % 10 == 1) {
            return $variants[0];
        }

        if ($n < 5 || $n % 10 < 5) {
            return $variants[1];
        }

        if (($n > 9 && $n % 10 == 0) || $n % 10 > 5) {
            return $variants[2];
        }
    }

    public static function computeIntervals($interval, $custom_start_date, $custom_finish_date)
    {
        if ($interval == self::INTERVAL_TODAY) {
            $time = time();
            $start_date = date('d.m.Y', $time);
            $finish_date = date('d.m.Y', $time + 86400);
        } elseif ($interval == self::INTERVAL_YESTERDAY) {
            $time = time();
            $start_date = date('d.m.Y', $time - 86400);
            $finish_date = date('d.m.Y', $time);
        } elseif ($interval == self::INTERVAL_WEEK) {
            $time = time();
            $start_date = date('d.m.Y', $time - 86400 * intval(date('N', $time)));
            $finish_date = date('d.m.Y', $time + 86400);
        } elseif ($interval == 'month') {
            $time = time();
            $start_date = date('d.m.Y', $time - 86400  * intval(date('d', $time)));
            $finish_date = date('d.m.Y', $time + 86400);
        } elseif ($interval == self::INTERVAL_HALFYEAR) {
            $time = time();
            $date = new \DateTime();
            $date->modify('-6 month');

            $start_date = $date->format('d.m.Y');
            $finish_date = date('d.m.Y', $time + 86400);
        } elseif ($interval == self::INTERVAL_YEAR) {
            $time = time();
            $time = time();
            $date = new \DateTime();
            $date->modify('-12 month');

            $start_date = $date->format('d.m.Y');
            $finish_date = date('d.m.Y', $time + 86400);
        } elseif ($interval == self::INTERVAL_ALL) {
            $start_date = date('d.m.Y', 0);
            $finish_date = date('d.m.Y', time() + 86400);
        } else {
            $interval = self::INTERVAL_CUSTOM;
            $start_date = date('d.m.Y', strtotime($custom_start_date));
            $finish_date = date('d.m.Y', strtotime($custom_finish_date));
        }

        return [
            'interval' => $interval,
            'start_date' => $start_date,
            'finish_date' => $finish_date,
        ];
    }

    public static function splitByStep($stepType, $startAt, $finishAt)
    {
        $steps = [];

        $date = new \DateTime();
        $date->setTimeStamp($startAt);
        $date->setTime(0, 0, 0);

        $year    = (int) $date->format('Y');
        $month   = (int) $date->format('m');
        $day     = (int) $date->format('d');
        $weekDay = (int) $date->format('w');

        if ($stepType == self::STEP_ALL) {
            $steps[] = [
                'title' => \Yii::t('app', 'All'),
                'startAt' => $startAt,
                'finishAt' => $finishAt,
            ];

            return $steps;
        }

        if ($stepType == self::STEP_WEEK
            && $weekDay != 0
        ) {
            $date->modify('-' . $weekDay . ' day');
        }

        if ($stepType == self::STEP_MONTH
            && $day != 1
        ) {
            $date->setDate($year, $month, 1);
        }

        $i = 0;

        while ($date->getTimestamp() < $finishAt) {
            $i++;

            $stepStartAt = $date->getTimestamp();
            $date->modify('+1 ' . $stepType);
            $stepFinishAt = $date->getTimestamp() - 1;

            if ($stepStartAt < $startAt) {
                $stepStartAt = $startAt;
            }

            if ($stepFinishAt >= $finishAt) {
                break;
            }

            $title = self::getDateTime($stepStartAt);

            if ($stepType == self::STEP_HOUR) {
                $title = self::getDateTime($stepStartAt);
            }

            if ($stepType == self::STEP_DAY) {
                $title = self::getPrettyDate($stepStartAt);
            }

            if ($stepType == self::STEP_WEEK) {
                $title = \Yii::t(
                    'app',
                    'Date Week {number} {start} {finish}',
                    [
                        'number' => $i,
                        'start' => self::getPrettyDate($stepStartAt),
                        'finish' => self::getPrettyDate($stepFinishAt),
                    ]);
            }

            if ($stepType == self::STEP_MONTH) {
                $title = self::getMonthYear($stepStartAt);
            }

            $steps[] = [
                'title' => $title,
                'startAt' => $stepStartAt,
                'finishAt' => $stepFinishAt,
            ];
        }

        $steps[] = [
            'title' => \Yii::t('app', 'All'),
            'startAt' => $startAt,
            'finishAt' => $finishAt,
        ];

        return $steps;
    }
}
