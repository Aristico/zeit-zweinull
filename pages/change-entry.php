<?php
  require __DIR__ . "/../src/views/layout/header.php";
  require __DIR__ . "/../init.php";

    $entryRepository = $container->make("entryRepository");
    $revisionRepository = $container->make("entryRevisionRepository");
    $beginOK = $entryRepository->changeBegin($_POST["user"], $_POST["date"], $_POST["begin"]);
    $endOK = $entryRepository->changeEnd($_POST["user"], $_POST["date"], $_POST["end"]);
    $breakOK = $revisionRepository->setBreak($_POST["user"], $_POST["date"], $_POST["break"]);
    if ($beginOK == 1 && $endOK == 1 && $breakOK == 1) {
        echo "<meta http-equiv='refresh' content='1; URL=balance-overview.php'>";
    } else {
        echo "Ups, da ist was schief gelaufen!";
    }


?>
</div>

<?php require __DIR__ . "/../src/views/layout/footer.php"; ?>
