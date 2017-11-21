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
    }

    public function getDate () {
        return $this->dateToday;
    }

    public function getCurrentTime ()
    {
        $this->currentTime = date("H:i:s");
        return $this->currentTime;
    }

    public function getUltimo ($date) {
        return date("Y-m-t",strtotime($date));
    }

    public function getMonth ($date) {
        return date("m", strtotime($date));
    }

    public function getDayOfWeek ($date) {
        return date("N", strtotime($date));
    }

    public function getWorkTime ($begin, $end, $break) {
        // Arbeitszeit berechnen
        $hoursDecimal = ((strtotime($end) - strtotime($begin))/60-$break)/60;
        $hoursRounded = round($hoursDecimal*4)/4;
        return $hoursRounded;
    }
}