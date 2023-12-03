<!-- PHP logica -->
<?php include __DIR__ . '/../application/example.php'; ?> <!--Verander example.php naar jouw gewenste file-->

<!DOCTYPE html>

<html lang="en">
    <!--Head-->
    <?php include __DIR__ . "/../application/components/layout/head.php"; ?>

    <body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
        <!--Header-->
        <?php include __DIR__ . "/../application/components/layout/header.php"; ?>

        <!--Pagina content container-->
        <div class="container-lg flex-grow-1 gx-0 py-4">
            <h1>Meerdere items:</h1>
            <?php foreach (queryMeerdereItems() as $item) {
                print "<pre>". var_export($item,true) ."</pre>";
            } ?>

            <h4>Enkel item:</h4>
            <?php print "<pre>". var_export(queryEnkelItem(),true) ."</pre>"; ?>
        </div>

        <!--Footer & Scripts-->
        <?php include __DIR__ . "/../application/components/layout/footer.php"; ?>
        <?php include __DIR__ . "/../application/components/layout/scripts.php"; ?>
    </body>
</html>