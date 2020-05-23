<?php

namespace App;

use \Carbon\Carbon;

/**
 * Class Date
 *
 * @package App
 *
 * @method Date static instance($dateTime)
 */
class Date extends Carbon
{
    public function addBusinessDays($numDays)
    {
        for ($i = 0; $i < $numDays; $i++) {
            $dayOfWeek = $this->format('w');
            if ($this->format('H') < 8) {
                // Date object is using UTC, so if it is earlier than 8am today, consider it "yesterday"
                $dayOfWeek--;
            }
            switch ($dayOfWeek) {
                case 5:
                    $this->addDays(3);
                    break;
                case 6:
                    $this->addDays(2);
                    break;
                default:
                    $this->addDay();
            }
        }

        return $this;
    }

    public function subBusinessDays($numDays)
    {
        for ($i = 0; $i < $numDays; $i++) {
            $dayOfWeek = $this->format('w');
            if ($this->format('H') < 8) {
                // Date object is using UTC, so if it is earlier than 8am today, consider it "yesterday"
                $dayOfWeek--;
            }
            switch ($dayOfWeek) {
                case 5:
                    $this->subDays(2);
                    break;
                case 6:
                    $this->subDays(1);
                    break;
                default:
                    $this->subDay();
            }
        }

        return $this;
    }

    public function isDaysAgo($numDays)
    {
        return $this->addDays($numDays) < self::now();
    }

    public function isDaysInFuture($numDays)
    {
        return $this->subDays($numDays) > self::now();
    }

    public function isHoursInFuture($numHours)
    {
        return $this->subHours($numHours) > self::now();
    }

    public function isBusinessDaysAgo($numDays)
    {
        return $this->addBusinessDays($numDays) < self::now();
    }

    public function isNotBusinessDaysAgo($numDays)
    {
        return !$this->isBusinessDaysAgo($numDays);
    }

    public function isHoursAgo($numHours)
    {
        return $this->addHours($numHours) < self::now();
    }

    public function toDayDateString()
    {
        return $this->format('D, M j, Y');
    }

    public function toYearMonthDay()
    {
        return $this->format('Y-m-d');
    }

    public function toDayMonthYearShort()
    {
        return $this->format('n/j/y');
    }

    public function toYearMonth()
    {
        return $this->format('Y-m');
    }

    public function toMonthYear()
    {
        return $this->format('M, Y');
    }

    public function shortDiffForHumans()
    {
        $diffInMinutes = $this->diffInMinutes(Date::now());
        if ($diffInMinutes == 0) {
            return 'now';
        } elseif ($diffInMinutes < 60) {
            return $diffInMinutes . 'm';
        } elseif ($diffInMinutes < 60 * 24) {
            return round($diffInMinutes / 60 ) . 'h';
        } elseif ($diffInMinutes < 60 * 24 * 14) {
            return round($diffInMinutes / 60 / 24) . 'd';
        } elseif ($diffInMinutes < 60 * 24 * 60) {
            return round($diffInMinutes / 60 / 24 / 7) . 'w';
        } elseif ($diffInMinutes < 60 * 24 * 700) {
            return round($diffInMinutes / 60 / 24 / 30) . 'mo';
        } else {
            return round($diffInMinutes / 60 / 24 / 365) . 'y';
        }
    }
}