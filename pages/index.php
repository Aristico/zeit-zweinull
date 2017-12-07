<?php
  require __DIR__ . "/../src/views/layout/header.php";
  require __DIR__ . "/../init.php";
?>
<?php


    $timeOperations = $container->make("timeOperations");
    $entryRepository = $container->make("entryRepository");
    $workingHours = $container->make("userScheduleRepository");
    $entrySnapshot = $container->make("entrySnapshotRepository");
    $entryRevision = $container->make("entryRevisionRepository");
    $userScheduleVersions = $container->make("userScheduleVersions");
    $entryController = $container->make("entryController");
    $userBalance = $container->make("userBalance");
    $user = 'yf7b97s';


    ?>

    <div class="container">

    <?php

    $entryController->showBalanceOverview($user, "2016-01-01", "2016-02-20"); ?>

    <!-- Tabelle Stylen -->
    <!-- Formular für Auszahlungen Bauen ->
    <!-- balance Overview in CSS Grid umsetzen -->

    </div>

    <?php require __DIR__ . "/../src/views/layout/footer.php"; ?>
