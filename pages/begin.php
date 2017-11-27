<?php
      require __DIR__ . "/../elements/header.php";
      require __DIR__ . "/../init.php";

      ?>

<?php
    $entryRepository = $container->make("entryRepository");
    if (isset($_GET["user"])) {
        $returnCode = $entryRepository->setBegin($_GET['user']);
        if ($returnCode == 2) {
            echo "Es existiert bereits ein Eintrag";
        } elseif ($returnCode == 1) {
            echo "Eintrag erfolgt";
        } else {
            echo "Fehler in der Datenbank-Verbindung";
        }
    } else {
        echo "Fehler 404";
    }
?>

<?php require __DIR__ . "/../elements/footer.php"; ?>
