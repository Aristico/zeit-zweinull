<?php
      require __DIR__ . "/../src/views/layout/header.php";
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
    $userScheduleVersions = $container->make("userScheduleVersions");
    $entryController = $container->make("entryController");
    ?>


    <!-- ÄNDERUNGSFORMULAR BAUEN -->
    <!-- Formular für Auszahlungen Bauen ->
    <!-- AUFLISTUNG DER TAGE (GRAU KEIN EINTRAG), GRÜN ÜBERSTUNDEN, ROT MINUSSTUNDEN -->

    <?php  $user = 'yf7b97s';

        /*$entrySnapshot->setRevision($user,"2016-01-31","4.5");*/
        $entryController->showBalance($user, '2016-01-01', '2016-05-01');




      require __DIR__ . "/../src/views/layout/footer.php"; ?>
