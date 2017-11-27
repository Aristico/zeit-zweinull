<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 21.11.17
 * Time: 19:22
 */

namespace App\user;

use App\entry\entryRepository;
use App\entry\entrySnapshotRepository;
use App\entry\entryRevisionRepository;
use App\user\userScheduleRepository;

class userBalance
{
    private $entryRepository;
    private $entrySnapshotRepository;

    public function __construct($entryRepository,
                                $entrySnapshotRepository,
                                $timeOperations)
    {
        $this->entryRepository = $entryRepository;
        $this->entrySnapshotRepository = $entrySnapshotRepository;
        $this->timeOperations = $timeOperations;
    }

    public function calculateBalance ($user) {

        // Ermittelt das Datum des letzten Snapshots
        $lastSnapshot = $this->entrySnapshotRepository->getLastSnapshot($user);

        // Fragt alle Datenbankeinträge seit dem letzten Snapshot ab
        $entrys = $this->entryRepository->fetchDatabase($user, $lastSnapshot->date);

        $entryTable = [];
        $balanceTotal = $lastSnapshot->balance;
        $i = 1;
        // erzeugt ein Array mit dem Berechnungsergebnis der Arbeitszeit und dem Stundenkonto
        foreach ($entrys as $entry) {

            // Errechnet die Tatsächliche Arbeitszeit
            $balanceWork = $this->timeOperations->getWorkTime($entry->begin, $entry->end, $entry->break);

            //Errechnet die Standard-Arbeitszeit
            $balanceSchedule = $this->timeOperations->getWorkTime($entry->schedule_begin, $entry->schedule_end, $entry->schedule_break);

            //Errechnet die Abweichung von der Standardarbeitszeit
            $balance = $balanceWork - $balanceSchedule;

            // Errechnet das Stundenkonto
            $balanceTotal += $balance;

            // Speichert die Daten zu dem Arbeitstag in einem Array

            $entryTable[$i]["date"] = $entry->date;
            $entryTable[$i]["begin"] = $entry->begin;
            $entryTable[$i]["end"] = $entry->end;
            $entryTable[$i]["regularHours"] = $balanceSchedule;
            $entryTable[$i]["workingHours"] = $balanceWork;
            $entryTable[$i]["break"] = $entry->break;
            $entryTable[$i]["balance"] = $balance;
            $entryTable[$i]["balanceTotal"] = $balanceTotal;
            $i++;
        }
        return $entryTable;
    }

}