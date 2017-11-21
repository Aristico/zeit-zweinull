<?php
      require __DIR__ . "/../elements/header.php";
      require __DIR__ . "/../init.php";

      ?>

<?php
    $entryRepository = new \App\entry\entryRepository($pdo);
    if (isset($_GET["user"])) {
        $returnCode = $entryRepository->setEnd($_GET['user']);
        if ($returnCode == 2) {
            echo "Es existiert noch kein Eintrag";
        } elseif ($returnCode == 1) {
            echo "Eintrag aktualisiert";
        } else {
            echo "Fehler in der Datenbank-Verbindung";
        }
    } else {
        echo "Fehler 404";
    }
?>

<?php require __DIR__ . "/../elements/footer.php"; ?>
