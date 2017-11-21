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
}