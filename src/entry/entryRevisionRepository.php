<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 28.10.17
 * Time: 16:19
 */

namespace App\entry;

use PDO;

class entryRevisionRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetchDatabase($user, $dateafter = '', $datebefore = '') {

        if ($dateafter == '') { $condition_date_after = '';}
                else {$condition_date_after = " AND date > :dateafter";}

        if ($datebefore != '' ) {$condition_date_before = " AND date < :datebefore";}
                else {$condition_date_before = '';}

        $sql = "select * from revision WHERE user = :user" . $condition_date_after . $condition_date_before;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam("user", $user);
        if ($condition_date_after > '') {
            $stmt->bindParam("dateafter", $dateafter);
        }
        if ($condition_date_before > '') {
            $stmt->bindParam("datebefore", $datebefore);
        }
        $stmt->execute();
        $entrys = $stmt->fetchAll(PDO::FETCH_CLASS, "App\\entry\\entryRevisionModel");

        $revisionValues = [];

        foreach ($entrys AS $row) {
            $revisionValues[$row->date] = $row;
        }

        return $revisionValues;
    }

    public function revisionExists ($user, $date) {

        $stmt = $this->pdo->prepare("SELECT * FROM revision WHERE date = :date AND user = :user");
        $stmt->execute([':user' => $user, ':date' => $date]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "App\\entry\\entrySnapshotMedel");
        $entry = $stmt->fetch();

        if(empty($entry)) {
            return false;
        } else {return true;}
    }

    public function setBreak ($user, $date, $break) {

        if ($this->revisionExists($user, $date)) {
            $sql = "UPDATE revision SET break = :break WHERE user = :user AND date = :date";
        } else {
            $sql = "INSERT INTO revision (user, date, break) VALUES (:user, :date, :break)";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":user" => $user, ":date" => $date, ":break" => $break]);

         if ($stmt) {
                return 1;
            } else {
                return 0;
            }
    }
}