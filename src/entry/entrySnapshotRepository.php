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

    public function getSnapshot ($user, $date) {

            $sql = "SELECT
                        user,
                        date,
                        balance,
                        revision
                    FROM snapshots
                    WHERE user = :user
                    AND date = :date";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user', $user);
        $stmt->bindParam(":date", $date);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, "App\\entry\\entrySnapshotModel");
        $res = $stmt->fetch();
        return $res;
    }

    public function snapshotExists ($user, $date) {

        $stmt = $this->pdo->prepare("SELECT * FROM snapshots WHERE date = :date AND user = :user");
        $stmt->execute([':user' => $user, ':date' => $date]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, "App\\entry\\entrySnapshotMedel");
        $entry = $stmt->fetch();

        if(empty($entry)) {
            return false;
        } else {return true;}
    }

    public function setSnapshot ($user, $date, $balance) {

        if ($this->snapshotExists($user, $date)) {
            $sql = "UPDATE snapshots SET balance = :balance WHERE user = :user AND date = :date";
        } else {
            $sql = "INSERT INTO snapshots (user, date, balance) VALUES (:user, :date, :balance)";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":user" => $user, ":date" => $date, ":balance" => $balance]);

         if ($stmt) {
                return 1;
            } else {
                return 0;
            }
    }

    public function setRevision ($user, $date, $revision) {

        if ($this->snapshotExists($user, $date)) {
            $sql = "UPDATE snapshots SET revision = :revision WHERE user = :user AND date = :date";
        } else {
            $sql = "INSERT INTO snapshots (user, date, revision) VALUES (:user, :date, :revision)";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":user" => $user, ":date" => $date, ":revision" => $revision]);

         if ($stmt) {
                return 1;
            } else {
                return 0;
            }
    }

}