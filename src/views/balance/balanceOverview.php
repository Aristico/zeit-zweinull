<div class="entryList">
    <?php
        foreach ($results AS $result) {

            if(isset($year)) {
                if ($year != $this->timeOperations->getYear($result["date"])) {
                    $year = $this->timeOperations->getYear($result["date"]);
                    ?> <h2 class="entryList__entry entryList__entry--periodInfo"><?php echo $year ?> </h2> <?php
                }
            } else {
                $year = $this->timeOperations->getYear($result["date"]);
                ?> <h2 class=" entryList__entry entryList__entry--periodInfo"><?php echo $year ?> </h2> <?php
            }

            /*if(isset($month)) {
                if ($month != $timeOperations->getMonthText($result["date"])) {
                    $month = $timeOperations->getMonthText($result["date"]);
                    ?> <h3 class="entryList__entry entryList__entry--periodInfo"><?php echo $month ?> </h3> <?php
                }
            } else {
                $month = $timeOperations->getMonthText($result["date"]);
                ?> <h3 class="entryList__entry entryList__entry--periodInfo"><?php echo $month ?> </h3> <?php
            }*/

            if(isset($week)) {
                if ($week != $this->timeOperations->getWeek($result["date"])) {
                    $week = $this->timeOperations->getWeek($result["date"]);
                    ?> <h3 class="entryList__entry entryList__entry--periodInfo"><?php echo "kw".$week ?> </h3> <?php
                }
            } else {
                $week = $this->timeOperations->getWeek($result["date"]);
                ?> <h3 class="entryList__entry entryList__entry--periodInfo"><?php echo "KW".$week ?> </h3> <?php
            }

            if ($result["balance"] > 0) {
                $buttonColor = "alert-success";
            } elseif ($result["balance"] < 0) {
                $buttonColor = "alert-danger";
            } else {
                $buttonColor = "alert-warning";
            }
            if ($this->timeOperations->getDayOfWeek($result["date"]) > 5) {
                $dayOfWeekClass = "entryList__entry--weekend";
            } else {
                $dayOfWeekClass = "entryList__entry--workDay";
            }

            $changeURLparams = "?dateOutput={$this->timeOperations->getDateOutput($result["date"])}&date={$result["date"]}&regularHours={$result["regularHours"]}&begin={$result["begin"]}&end={$result["end"]}&break={$result["break"]}&day={$this->timeOperations->getDayText($result["date"])}&workingHours={$result["workingHours"]}&balance={$result["balance"]}&balanceTotal={$result["balanceTotal"]}&user={$result["user"]}";

            ?>
            <button class="alert entryList__entry <?php echo $buttonColor . " " . $dayOfWeekClass ?>">
                <a class="entryList__link" href="change-entry-form.php<?php echo $changeURLparams?>"><?php echo $this->timeOperations->getDayMonth($result["date"]) . "<br>". $this->timeOperations->getBalanceOutput($result["balance"]);?></a>
            </button>
        <?php } ?>
</div>