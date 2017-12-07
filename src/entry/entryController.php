<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 30.11.17
 * Time: 19:55
 */

namespace App\entry;

use App\entry\userBalance;
use App\time\timeOperations;

class entryController
{
    private $userBalance;
    private $timeOperations;

    public function __construct(userBalance $userBalance, timeOperations $timeOperations)
    {
        $this->userBalance = $userBalance;
        $this->timeOperations = $timeOperations;

    }

    public function showBalanceTable ($user, $dateFrom, $dateTo) {
        $results = $this->userBalance->calculateBalance($user, $dateFrom, $dateTo);
        include __DIR__ . "/../views/balance/balanceTable.php";
    }

    public function showBalanceOverview ($user, $dateFrom, $dateTo) {
        $results = $this->userBalance->calculateBalance($user, $dateFrom, $dateTo, true);
        include __DIR__ . "/../views/balance/balanceOverview.php";
    }

    public function showChangeEntryForm () {

        include __DIR__ . "/../views/forms/changeEntryForm.php";
    }



}