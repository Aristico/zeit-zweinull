<div class="table-responsive">
    <table class="schedule__table table-bordered table-hover">
                <tr class="schedule_row">
                    <th class="schedule__cell">Datum</th>
                    <th class="schedule__cell">Uhrzeit</th>
                    <th class="schedule__cell">Pause</th>
                    <th class="schedule__cell">Arbeitszeit (Regulär)</th>
                    <th class="schedule__cell">Abweichung</th>
                    <th class="schedule__cell">Stundenkonto (Auszahlung)</th>
                </tr> <?php
            foreach ($results AS $result) {?>
                <tr>
                    <td class="schedule__cell"><?php echo $this->timeOperations->getDateOutput($result["date"])?></td> <?php
                    if ($result["begin"] != null) { ?>
                    <td class="schedule__cell"><?php echo $this->timeOperations->getTimeOutput($result["begin"]) . " - " .
                                   $this->timeOperations->getTimeOutput($result["end"])?></td>
                    <td class="schedule__cell"><?php echo $result["break"]?></td>
                    <td class="schedule__cell"><?php echo $this->timeOperations->getHoursOutput($result["workingHours"]) . " ("
                                    . $this->timeOperations->getHoursOutput($result["regularHours"]) . ")"?></td>

                    <td class="schedule__cell"><?php echo $this->timeOperations->getBalanceOutput($result["balance"])?></td>
                    <?php } else { echo ""; ?>
                    <td class="schedule__cell"></td>
                    <td class="schedule__cell"></td>
                    <td class="schedule__cell"></td>
                    <td class="schedule__cell"></td>
                    <?php }
                    $revision = "";
                    if ($result["revision"] != null) { $revision = " (" . $result["revision"] . ")";}
                    ?>
                    <td class="schedule__cell"><?php echo $this->timeOperations->getBalanceOutput($result["balanceTotal"]) . $revision?></td>
                </tr><?php

            }
        ?>
    </table>
</div>