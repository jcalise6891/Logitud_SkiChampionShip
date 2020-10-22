<?php

namespace App\Utility;

use DateTime;
use Exception;

abstract class EntityAbstract
{
    /**
     * @param $param
     * @throws Exception
     */
    protected static function isNotEmpty(string $param)
    {
        if (strlen(trim($param)) <= 0) {
            throw new Exception('Cannot Be Empty');
        }
    }

    /**
     * @param DateTime $date
     * @throws Exception
     */
    protected static function isOutOfDate(DateTime $date)
    {
        $comparisonDate = new DateTime('today');
        if ($comparisonDate > $date) {
            throw new Exception('Cannot be in the Past');
        }
    }

    /**
     * @param $mail
     * @throws Exception
     */
    protected static function isMailValid(string $mail)
    {
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Email is invalid');
        }
    }

    /**
     * @param DateTime $time
     * @throws Exception
     */
    protected static function isBirthDateValid(DateTime $time)
    {
        $ts_startDate = strtotime("01-01-1920");
        $ts_endDate = strtotime('today');
        $ts_time = strtotime($time->format('d-m-Y'));

        if ($ts_time < $ts_startDate || $ts_time > $ts_endDate) {
            throw new Exception('Birthdate is not valid');
        }
    }

    /**
     * @param $s
     * @return array|false|string[]
     */
    protected static function splitAtUpperCase($s)
    {
        return preg_split('/(?=[A-Z])/', $s, -1, PREG_SPLIT_NO_EMPTY);
    }

    protected static function strToDateTime(string $string): DateTime
    {
        return DateTime::createFromFormat(
            'Y-m-d H:i',
            str_replace(
                'T',
                ' ',
                $string
            )
        );
    }
}
