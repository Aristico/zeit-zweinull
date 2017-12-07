<?php
  require __DIR__ . "/../src/views/layout/header.php";
  require __DIR__ . "/../init.php";
?>
<?php
    $entryController = $container->make("entryController");
    $user = 'yf7b97s';
?>

    <div class="container">
        <?php $entryController->showBalanceOverview($user, "2016-01-01", "2016-02-20"); ?>
    </div>

    <?php require __DIR__ . "/../src/views/layout/footer.php"; ?>
