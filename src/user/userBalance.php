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
use App\user\userDataRepository;

class userBalance
{
    private $entryRepository;
    private $entrySnapshotRepository;
    private $entryRevisionRepository;
    private $userDataRepository;

    public function __construct($entryRepository,
                                $entrySnapshotRepository,
                                $entryRevisionRepository,
                                $userDataRepository,
                                $timeOperations)
    {
        $this->entryRepository = $entryRepository;
        $this->entrySnapshotRepository = $entrySnapshotRepository;
        $this->entryRevisionRepository = $entryRevisionRepository;
        $this->userDataRepository = $userDataRepository;
        $this->timeOperations = $timeOperations;
    }

    public function calculateBalance ($user) {

        // Ermittelt das Datum des letzten Snapshots
        $lastSnapshot = $this->entrySnapshotRepository->getLastSnapshot($user);

        // Fragt die Arbeitszeiten des Users ab
        $userSchedule = $this->userDataRepository->getWorkingSchedule($user);

        // Fragt alle Datenbankeinträge seit dem letzten Snapshot ab
        $entrys = $this->entryRepository->fetchDatabase($user, $lastSnapshot->date);

        // Fragt alle abweichenden Pausen seit dem letzten Snapshot ab
        $revisions = $this->entryRevisionRepository->fetchDatabase($user, $lastSnapshot->date);


        $entryTable = [];
        $balanceTotal = $lastSnapshot->balance;
        $i = 1;
        // erzeugt ein Array mit dem Berechnungsergebnis der Arbeitszeit und dem Stundenkonto
        foreach ($entrys as $entry) {

            // Gibt es in den Revisions eine abweichende Pause? Dann wird diese genutzt.
            if (isset($revisions[$entry->date])) {
                $break = $revisions[$entry->date]->break;
            } else { $break = $userSchedule[$this->timeOperations->getDayOfWeek($entry->date)]->break;}

            // Errechnet die Tatsächliche Arbeitszeit
            $balanceWork = $this->timeOperations->getWorkTime($entry->begin, $entry->end, $break);

            //Errechnet die Standard-Arbeitszeit
            $balanceSchedule = $this->timeOperations->getWorkTime($userSchedule[$this->timeOperations->getDayOfWeek($entry->date)]->begin,
                                                  $userSchedule[$this->timeOperations->getDayOfWeek($entry->date)]->end,
                                                  $userSchedule[$this->timeOperations->getDayOfWeek($entry->date)]->break);

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
            $entryTable[$i]["break"] = $break;
            $entryTable[$i]["balance"] = $balance;
            $entryTable[$i]["balanceTotal"] = $balanceTotal;
            $i++;
        }
        return $entryTable;
    }

}