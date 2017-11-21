<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 28.10.17
 * Time: 16:19
 */

namespace App\entry;

use PDO;

class entrySnapshotRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getLastSnapshot ($user, $date = "") {

            if ($date != "")
            {$dateBefore = "AND date < :date";}
            else {$dateBefore = "";}

            $sql = "SELECT
                        user,
                        date,
                        balance
                    FROM snapshots
                    WHERE user = :user
                    {$dateBefore}
                    ORDER BY date DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user', $user);
        if ($date != "") {
            $stmt->bindParam(":date", $date);
        }
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, "App\\entry\\entrySnapshotModel");
        $res = $stmt->fetch();
        return $res;
    }

    public function setSnapshots ($user, $date) {
        // Snapshot hier speichern
    }

}