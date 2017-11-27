<?php
      require __DIR__ . "/../elements/header.php";
      require __DIR__ . "/../init.php";

      ?>

<?php


    $time = $container->make("timeOperations");
    $entryRepository = $container->make("entryRepository");
    $workingHours = $container->make("userScheduleRepository");
    $entrySnapshot = $container->make("entrySnapshotRepository");
    $entryRevision = $container->make("entryRevisionRepository");
    $userBalance = $container->make("userBalance");
    $userScheduleVersions = $container->make("userScheduleVersions");
    ?>

    // TODO: Beim Speichern der Einträge die aktuelle Version speichern.

    <pre><?php  $user = 'yf7b97s';
                var_dump($userScheduleVersions->getCurrentVersion($user));

            ?>
    </pre>
    <?php
?>



<?php require __DIR__ . "/../elements/footer.php"; ?>
