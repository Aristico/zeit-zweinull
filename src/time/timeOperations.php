<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 28.10.17
 * Time: 11:52
 */

namespace App\time;


class timeOperations
{
    private $pdo;

    public $dateToday;
    public $currentTime;
    public $date;
    public $begin;
    public $end;
    public $break;
    public $balance;

    public function __construct()
    {
        $this->dateToday = date("Y-m-d");
        $test = setlocale(LC_TIME, "de_DE");
    }

    public function getYear ($date) {
        return date("Y", strtotime($date));
    }

    public function getMonth ($date) {
        return date("m", strtotime($date));
    }

    public function getMonthText ($date) {
        $names = ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli" , "August", "September", "Oktober", "November", "Dezember"];
        $month = date("n", strtotime($date));
        return $names[$month-1];
    }

    public function getDayText ($date) {
        $names = ["Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag", "Sonntag"];
        $day = date("N", strtotime($date));
        return $names[$day-1];
    }

    public function getUltimo ($date) {
        return date("Y-m-t",strtotime($date));
    }

    public function getWeek ($date) {
        return date("W",strtotime($date));
    }

    public function getDayOfWeek ($date) {
        return date("N", strtotime($date));
    }

    public function getDate ($date = 0) {
        if ($date = 0) {
            return $this->dateToday;
        } else {
            return date ("Y-m-d", $date);
        }
    }

    public function getDayMonth ($date = 0) {
            return date ("d.m.", strtotime($date));
    }

    public function getDateOutput ($date = 0) {
            return date ("d.m.Y", strtotime($date));
    }

    public function getBalanceOutput ($balance) {
        if ($balance > 0) { return "+" . number_format($balance,2,",",".") . " h";}
        return number_format($balance,2,",",".") . " h";
    }

    public function getHoursOutput ($hours) {
        return number_format($hours,2,",",".") . " h";
    }

    public function getTimeOutput ($time) {
        if ($time != null ) {
            return date("H:i", strtotime($time));
        }
    }



    public function getCurrentTime ()
    {
        $this->currentTime = date("H:i:s");
        return $this->currentTime;
    }









    public function getWorkTime ($begin, $end, $break) {
        // Arbeitszeit berechnen
        $hoursDecimal = ((strtotime($end) - strtotime($begin))/60-$break)/60;
        $hoursRounded = round($hoursDecimal*4)/4;
        return $hoursRounded;
    }
}