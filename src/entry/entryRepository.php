<?php

namespace App\entry;

/*use App\time\timeOperations;*/
use PDO;

class entryRepository
{
    private $pdo;
    private $timeOperations;

    public function __construct(PDO $pdo, $timeOperations)
    {
        $this->pdo = $pdo;
        $this->timeOperations = $timeOperations;
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

    public function fetchDatabase($user, $dateafter = '', $datebefore = '') {

        if ($dateafter == '') { $condition_date_after = '';}
                else {$condition_date_after = " AND date > :dateafter";}

        if ($datebefore != '' ) {$condition_date_before = " AND date < :datebefore";}
                else {$condition_date_before = '';}

        $sql = "select * from entrys WHERE user = :user" . $condition_date_after . $condition_date_before;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam("user", $user);
        if ($condition_date_after > '') {
            $stmt->bindParam("dateafter", $dateafter);
        }
        if ($condition_date_before > '') {
            $stmt->bindParam("datebefore", $datebefore);
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
            $stmt = $this->pdo->prepare("INSERT INTO entrys (user, date, begin, end) VALUES (:user, :date, :currentTime,:currentTime2)");
            $result = $stmt->execute(["user" => $user, "date"=>$dateToday, "currentTime" => $currentTime, "currentTime2" => $currentTime ]);
            if ($result) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    //TODO Funktion schreiben, die die Tabelle mit den Überstunden speichert. Weil, wenn sich die Arbeitzeiten ändern, dann ändern sie sich auch Rückwirkend
    // Das führt dazu, dass ggf. die Stundenzettel sich rückwirkend verändert. Immer dann ein Problem, wenn der Snapshot sich ändert. Alternative Möglichkeit, snapshots festschreiben
    // Und zusätzlich die Arbeitszeiten-Änderungen dokumentieren. Vielleicht im Snapshot die Arbeitszeiten pro Tag speichern.

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