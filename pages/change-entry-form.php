<?php
  require __DIR__ . "/../src/views/layout/header.php";
  require __DIR__ . "/../init.php";
?>
<div class="container">
<?php
    $entryController = $container->make("entryController");
    $entryController->showChangeEntryForm();
?>
</div>

<?php require __DIR__ . "/../src/views/layout/footer.php"; ?>
