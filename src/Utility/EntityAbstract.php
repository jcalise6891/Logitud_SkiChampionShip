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
    protected static function isNotEmpty(string $param){
        if(strlen($param) == 0){
            throw new Exception('Cannot Be Empty');

        }
    }

    /**
     * @param DateTime $date
     * @throws Exception
     */
    protected static function IsOutOfDate(DateTime $date)
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
    protected static function IsMailValid(string $mail){
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Email is invalid');
        }
    }

    /**
     * @param DateTime $time
     * @throws Exception
     */
    protected static function IsBirthDateValid(DateTime $time){
        $ts_startDate = strtotime('1920-01-01');
        $endDate = new DateTime('today');
        $ts_endDate = strtotime($endDate->format('YYYY-mm-dd'));
        $ts_time = strtotime($time->format('YYYY-mm-dd'));

        if($ts_time < $ts_startDate || $ts_time > $ts_endDate){
            throw new Exception('Birthdate is not valid');
        }
    }
}