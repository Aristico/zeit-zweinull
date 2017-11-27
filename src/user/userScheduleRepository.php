<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 28.10.17
 * Time: 16:19
 */

namespace App\user;

use PDO;

class userScheduleRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getWorkingHours ($day, $user) {

        $stmt = $this->pdo->prepare("SELECT * FROM user_schedule WHERE day = :day and user = :user");
        $stmt->execute([':day' => $day, ":user" => $user]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "App\\entry\\userScheduleModel");
        $res = $stmt->fetch();

        return $res;
    }

      public function getWorkingSchedule ($user) {

        $stmt = $this->pdo->prepare("SELECT * FROM user_schedule WHERE user = :user ORDER BY day ASC");
        $stmt->execute([':user' => $user]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "App\\user\\userScheduleModel");
        $res = $stmt->fetchAll();

        $userValues = [];

        foreach ($res AS $row) {
            $userValues[$row->day] = $row;
        }

        return $userValues;
    }

}