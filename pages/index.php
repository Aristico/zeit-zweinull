<?php
      require __DIR__ . "/../elements/header.php";
      require __DIR__ . "/../init.php";

      ?>

<?php


    $time = $container->make("timeOperations");
    $entryRepository = $container->make("entryRepository");
    $workingHours = $container->make("userDataRepository");
    $entrySnapshot = $container->make("entrySnapshotRepository");
    $entryRevision = $container->make("entryRevisionRepository");
    $userBalance = $container->make("userBalance");

    ?>

    <!--Arbeitszeiten Versionieren Neue Spalte: Version, von, bis. (Vermutlich reicht "bis"
    // Versionswechsel nur auf volle Wochen mögliche machen.
    // Spalte Version ggf. auch in den Entrys ergänzen -> Mal schauen, ob man das auch über das Datum greifen kann.
    -->

    <pre><?php  $user = 'yf7b97s';
                var_dump($userBalance->calculateBalance($user));

            ?>
    </pre>
    <?php
?>



<?php require __DIR__ . "/../elements/footer.php"; ?>
