<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 30.11.17
 * Time: 19:55
 */

namespace App\entry;

use App\entry\userBalance;

class entryController
{
    private $userBalance;

    public function __construct(userBalance $userBalance)
    {
        $this->userBalance = $userBalance;
    }

    public function showBalance ($user, $dateFrom, $dateTo) {
        $results = $this->userBalance->calculateBalance($user, $dateFrom, $dateTo);

        include __DIR__ . "/../views/balance/balanceTable.php";

    }

}