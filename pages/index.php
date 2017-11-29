<?php
      require __DIR__ . "/../elements/header.php";
      require __DIR__ . "/../init.php";

      ?>
    <style>
        table {
            border: 1px black solid;
        }
        td, th {
            width: 100px;
            border: 1px black solid;
            padding: 3px;
        }
    </style>
<?php


    $time = $container->make("timeOperations");
    $entryRepository = $container->make("entryRepository");
    $workingHours = $container->make("userScheduleRepository");
    $entrySnapshot = $container->make("entrySnapshotRepository");
    $entryRevision = $container->make("entryRevisionRepository");
    $userBalance = $container->make("userBalance");
    $userScheduleVersions = $container->make("userScheduleVersions");
    ?>


    <!-- ÜBERSTUNDEN AUSZAHLEN ERMÖGLICHEN UND IN DIE BERECHNUNG EINFLIEßEN LASSEN -->
    <!-- ÄNDERUNGSFORMULAR BAUEN -->
    <!-- AUFLISTUNG DER TAGE (GRAU KEIN EINTRAG), GRÜN ÜBERSTUNDEN, ROT MINUSSTUNDEN -->
    
    <?php  $user = 'yf7b97s';
                $results = $userBalance->calculateBalance($user, "2015-01-01", "2017-10-23");
                ?>
                <table>
                    <tr>
                        <th>date</th>
                        <th>begin</th>
                        <th>end</th>
                        <th>regularHours</th>
                        <th>workingHours</th>
                        <th>break</th>
                        <th>balance</th>
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
                        <td><?php echo $result["balanceTotal"]?></td>
                    </tr><?php

                }
            ?>
                </table>

    <?php
?>



<?php require __DIR__ . "/../elements/footer.php"; ?>
