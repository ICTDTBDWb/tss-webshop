<?php global $content; ?>

<!DOCTYPE html>

<html lang="en">
    <!--Head-->
    <?php include __DIR__ . "/inc/head.php"; ?>

    <body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
        <!--Header-->
        <?php include __DIR__ . "/inc/header.php"; ?>

        <!--Pagina content container-->
        <div class="container-lg flex-grow-1 gx-0 p-4">
            <?php require_once $content; ?>
        </div>

        <!--Footer & Scripts-->
        <?php include __DIR__ . "/inc/footer.php"; ?>
        <?php include __DIR__ . "/inc/scripts.php"; ?>
    </body>
</html>
