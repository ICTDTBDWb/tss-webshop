<!-- PHP logica -->
<?php
    include __DIR__ . '/../Application/Http/homepagina.php';
    $session = \application\SessionManager::getInstance();
    $session->set('test.test2', 'Het Werkt!');
?>

<!DOCTYPE html>

<html lang="en">
    <!--Head-->
    <?php include __DIR__ . "/../Resources/components/layout/head.php"; ?>

    <body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
        <!--Header-->
        <?php include __DIR__ . "/../Resources/components/layout/header.php"; ?>

        <!--Pagina content container-->
        <div class="container-lg flex-grow-1 gx-0 p-4">
            <!--Banner-->
            <section class="row gx-0 mb-5">
                <a href="/" class="col-8 pe-2 bg-image">
                    <img
                            src="https://img.freepik.com/free-photo/guy-playing-acoustic-guitar_169016-2126.jpg?w=1380&t=st=1701540133~exp=1701540733~hmac=7522639adac31beacdcfcb3c31df1aeb3666b4d6547be7ad761153305b7025f8"
                            alt="Banner"
                            class="rounded w-100 h-100"
                            style="object-fit: cover"
                    >
                </a>
                <div class="col-4 d-flex flex-column gap-2">
                    <a href="/" class="container-fluid bg-image">
                        <img
                                src="https://img.freepik.com/free-photo/guy-playing-acoustic-guitar_169016-2126.jpg?w=1380&t=st=1701540133~exp=1701540733~hmac=7522639adac31beacdcfcb3c31df1aeb3666b4d6547be7ad761153305b7025f8"
                                alt="Banner"
                                class="rounded w-100 h-100"
                                style="object-fit: cover"
                        >
                    </a>
                    <a href="/" class="container-fluid bg-image">
                        <img
                                src="https://img.freepik.com/free-photo/guy-playing-acoustic-guitar_169016-2126.jpg?w=1380&t=st=1701540133~exp=1701540733~hmac=7522639adac31beacdcfcb3c31df1aeb3666b4d6547be7ad761153305b7025f8"
                                alt="Banner"
                                class="rounded w-100 h-100"
                                style="object-fit: cover"
                        >
                    </a>
                </div>
            </section>

            <?php echo var_export($session->get('test.test2'), true); ?>

        </div>

        <!--Footer & Scripts-->
        <?php include __DIR__ . "/../Resources/components/layout/footer.php"; ?>
        <?php include __DIR__ . "/../Resources/components/layout/scripts.php"; ?>
    </body>
</html>