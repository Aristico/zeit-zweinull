<?php

namespace App\entry;

/*use App\time\timeOperations;*/
use PDO;

class entryRepository
{
    private $pdo;
    private $timeOperations;
    private $userScheduleVersions;

    public function __construct(PDO $pdo, $timeOperations, $userScheduleVersions)
    {
        $this->pdo = $pdo;
        $this->timeOperations = $timeOperations;
        $this->userScheduleVersions = $userScheduleVersions;
    }

    public function entryExists ($user, $date) {

        $stmt = $this->pdo->prepare("SELECT * FROM entrys WHERE date = :date AND user = :user");
        $stmt->execute([':user' => $user, ':date' => $date]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "App\\entry\\entryMedel");
        $entry = $stmt->fetch();

        if(empty($entry)) {
            return false;
        } else {return true;}
    }

    public function fetchDatabase($user, $dateafter = '', $dateto = '') {

        if ($dateafter == '') { $condition_date_after = '';}
                else {$condition_date_after = " AND entrys.date > :dateafter";}

        if ($dateto != '' ) {$condition_date_to = " AND entrys.date <= :dateto";}
                else {$condition_date_to = '';}

        $sql = "select entrys.user,
                       entrys.date,
                       us.day,
                       entrys.begin,
                       entrys.end,
                       CASE WHEN revision.break is null THEN us.break ELSE revision.break END AS break,
                       entrys.version,
                       us.begin AS schedule_begin, 
                       us.end AS schedule_end,
                       us.break AS schedule_break
                FROM   entrys 
                LEFT JOIN revision ON revision.user = entrys.user AND revision.date = entrys.date
                LEFT JOIN user_schedule us ON us.user = entrys.user AND us.version = entrys.version AND weekday(entrys.date)+1 = us.day 
                WHERE entrys.user = :user" . $condition_date_after . $condition_date_to;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam("user", $user);
        if ($condition_date_after > '') {
            $stmt->bindParam("dateafter", $dateafter);
        }
        if ($condition_date_to > '') {
            $stmt->bindParam("dateto", $dateto);
        }
        $stmt->execute();
        $entrys = $stmt->fetchAll(PDO::FETCH_CLASS, "App\\entry\\entryModel");
        return $entrys;
    }

    public function setBegin ($user) {
        $dateToday = $this->timeOperations->dateToday;
        $currentTime = $this->timeOperations->getCurrentTime();
        if ($this->entryExists($user, $dateToday)) {
            return 2;
        } else {
            $stmt = $this->pdo->prepare("INSERT INTO entrys (user, date, begin, end, version) 
                                                   VALUES (:user, :date, :currentTime,:currentTime2, :version)");
            $result = $stmt->execute(["user" => $user, "date"=>$dateToday, "currentTime" => $currentTime, "currentTime2" => $currentTime, "version" => $this->userScheduleVersions->getCurrentVersion($user)]);
            if ($result) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function setEnd ($user) {
        $dateToday = $this->timeOperations->dateToday;
        $currentTime = $this->timeOperations->getCurrentTime();
        if ($this->entryExists($user, $dateToday)) {
            $stmt = $this->pdo->prepare("UPDATE entrys SET end = :currentTime WHERE user = :user AND date = :date");
            $result = $stmt->execute(["user" => $user, "date"=>$dateToday, "currentTime" => $currentTime]);
            if ($result) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 2;
        }
    }
}