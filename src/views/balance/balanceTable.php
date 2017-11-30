<table>
            <tr>
                <th>date</th>
                <th>begin</th>
                <th>end</th>
                <th>regularHours</th>
                <th>workingHours</th>
                <th>break</th>
                <th>balance</th>
                <th>Revision</th>
                <th>balanceTotal</th>
            </tr> <?php
        foreach ($results AS $result) {?>
            <tr>
                <td><?php echo $result["date"]?></td>
                <td><?php echo $result["begin"]?></td>
                <td><?php echo $result["end"]?></td>
                <td><?php echo $result["regularHours"]?></td>
                <td><?php echo $result["workingHours"]?></td>
                <td><?php echo $result["break"]?></td>
                <td><?php echo $result["balance"]?></td>
                <td><?php echo $result["revision"]?></td>
                <td><?php echo $result["balanceTotal"]?></td>
            </tr><?php

        }
    ?>
</table>