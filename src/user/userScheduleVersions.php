<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 23.11.17
 * Time: 19:53
 */

namespace App\user;

use PDO;
class userScheduleVersions
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getScheduleVersions ($user, $begin) {

        $sql = "SELECT * FROM user_schedule_versions
                WHERE user = :user AND (lastDayOfUse >= :begin OR firstDayOfUse <= :end)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":begin", $begin );
        $stmt->bindParam(":end", $end);
        $stmt->bindParam(":user", $user);
        $stmt->execute();
        $scheduleVersions = $stmt->fetchAll(PDO::FETCH_CLASS, "App\\user\\userScheduleVersionsModel");

        return $scheduleVersions;
    }

    public function getCurrentVersion ($user) {

        $sql = "SELECT * FROM user_schedule_versions
                WHERE user = :user AND 
                (
                  (firstDayOfUse <= current_date AND lastDayOfUse >= current_date)
                  OR (firstDayOfUse <= current_date AND lastDayOfUse is null)
                )";

        //
        $curdate = "2017-11-20";
        $stmt =$this->pdo->prepare($sql);
        $stmt->bindParam(":user", $user);
        $stmt->execute();
        $currentVersion = $stmt->fetchAll(PDO::FETCH_CLASS, "App\\user\\userScheduleVersionsModel");

        return $currentVersion[0]->version;
    }

}