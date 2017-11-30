<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 21.11.17
 * Time: 19:22
 */

namespace App\entry;

use DateTime;

class userBalance
{
    private $entryRepository;
    private $entrySnapshotRepository;
    private $timeOperations;

    public function __construct($entryRepository,
                                $entrySnapshotRepository,
                                $timeOperations)
    {
        $this->entryRepository = $entryRepository;
        $this->entrySnapshotRepository = $entrySnapshotRepository;
        $this->timeOperations = $timeOperations;
    }

    public function calculateBalance ($user, $dateFrom, $dateTo) {

        // Ermittelt das Datum des letzten Snapshots
        $lastSnapshot = $this->entrySnapshotRepository->getLastSnapshot($user, $dateFrom);
        $dateCounter = new DateTime($lastSnapshot->date);
        $dateCounter->modify("+ 1 Day");

        // Fragt alle Datenbankeinträge seit dem letzten Snapshot ab
        $entrys = $this->entryRepository->fetchDatabase($user, $lastSnapshot->date, $dateTo);

        $entryTable = [];
        $balanceTotal = $lastSnapshot->balance;
        $revision = null;
        $i = 0;
        // erzeugt ein Array mit dem Berechnungsergebnis der Arbeitszeit und dem Stundenkonto.
        // Es wird für jeden Kalendertag ein Entrag angelegt, egal ob ein Eintrag in der DB existiert oder nicht.
        foreach ($entrys as $entry) {

            while ($dateCounter->format("Y-m-d") != $entry->date) {
                if ($dateCounter->format("Y-m-d") == $this->timeOperations->getUltimo($dateCounter->format("Y-m-d"))) {
                    if ($this->entrySnapshotRepository->snapshotExists($user, $dateCounter->format("Y-m-d"))) {
                        $snapshot = $this->entrySnapshotRepository->getSnapshot($user, $dateCounter->format("Y-m-d"));
                        $revision = $snapshot->revision;
                        $balanceTotal = $balanceTotal - $revision;

                    }
                    $this->entrySnapshotRepository->setSnapshot($user, $dateCounter->format("Y-m-d"), $balanceTotal);
                }

                // Erstellt einen Eintrag für ein Datum an dem kein Eintrag in der DB existiert.
                $entryTable[$i]["date"] = $dateCounter->format("Y-m-d");
                $entryTable[$i]["begin"] = null;
                $entryTable[$i]["end"] = null;
                $entryTable[$i]["regularHours"] = null;
                $entryTable[$i]["workingHours"] = null;
                $entryTable[$i]["break"] = null;
                $entryTable[$i]["balance"] = null;
                $entryTable[$i]["revision"] = $revision;
                $entryTable[$i]["balanceTotal"] = $balanceTotal;

                $dateCounter->modify("+1 day");
                $i++;
                $revision = null;
                }

                // Errechnet die Tatsächliche Arbeitszeit
                $balanceWork = $this->timeOperations->getWorkTime($entry->begin, $entry->end, $entry->break);

                //Errechnet die Standard-Arbeitszeit
                $balanceSchedule = $this->timeOperations->getWorkTime($entry->schedule_begin, $entry->schedule_end, $entry->schedule_break);

                //Errechnet die Abweichung von der Standardarbeitszeit
                $balance = $balanceWork - $balanceSchedule;

                // Errechnet das Stundenkonto
                $balanceTotal += $balance;

                if ($dateCounter->format("Y-m-d") == $this->timeOperations->getUltimo($dateCounter->format("Y-m-d"))) {
                    if ($this->entrySnapshotRepository->snapshotExists($user, $dateCounter->format("Y-m-d"))) {
                        $snapshot = $this->entrySnapshotRepository->getSnapshot($user, $dateCounter->format("Y-m-d"));
                        $revision = $snapshot->revision;
                        $balanceTotal = $balanceTotal - $revision;
                    }
                    $this->entrySnapshotRepository->setSnapshot($user, $dateCounter->format("Y-m-d"), $balanceTotal);
                }

                // Speichert die Daten zu dem Arbeitstag in einem Array

                $entryTable[$i]["date"] = $entry->date;
                $entryTable[$i]["begin"] = $entry->begin;
                $entryTable[$i]["end"] = $entry->end;
                $entryTable[$i]["regularHours"] = $balanceSchedule;
                $entryTable[$i]["workingHours"] = $balanceWork;
                $entryTable[$i]["break"] = $entry->break;
                $entryTable[$i]["balance"] = $balance;
                $entryTable[$i]["revision"] = $revision;
                $entryTable[$i]["balanceTotal"] = $balanceTotal;

                $i++;
                $revision = null;
                $dateCounter->modify("+1 day");

        }
        while (strtotime($dateFrom) > strtotime($entryTable[0]["date"])) {
            array_shift($entryTable);
        }

        return $entryTable;
    }

}