<!-- PHP logica -->
<?php include __DIR__ . '/../Application/producten.php'; ?>

<!DOCTYPE html>

<html lang="en">
    <!--Head-->
    <?php include __DIR__ . "/../Resources/components/layout/head.php"; ?>

    <body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
        <!--Header-->
        <?php include __DIR__ . "/../Resources/components/layout/header.php"; ?>

<!--Pagina content container-->
    <div class="container-lg flex-grow-1 gx-0 py-4">
        <div class="d-flex justify-content-center">
            <h1 class="mt-0 font-weight-bold mb-5">Producten</h1>
        </div>
    </div>
        <!--Weergave categorien-->
    <div class="container-lg flex-grow-1 gx-o py-4">
        <div class="row">
            <div class="col-sm-2">
                <h5 class="font-weight-bold d-flex justify-content-center" >Categorien</h5>
                <a href="#" class="list-group-item list-group-item-action" <?php print "<pre>". $categorie1['naam'] ."</pre>"; ?></a>
                <a href="#" class="list-group-item list-group-item-action" <?php print "<pre>". $categorie2['naam'] ."</pre>"; ?></a>
                <a href="#" class="list-group-item list-group-item-action" <?php print "<pre>". $categorie3['naam'] ."</pre>"; ?></a>
                <a href="#" class="list-group-item list-group-item-action" <?php print "<pre>". $categorie4['naam'] ."</pre>"; ?></a>
            </div>
            <div class="col-md">
                <h5 href="#" class="font-weight-bold d-flex justify-content-center">Product 1</h5>
                <img
                    src="https://img.freepik.com/free-photo/guy-playing-acoustic-guitar_169016-2126.jpg?w=1380&t=st=1701540133~exp=1701540733~hmac=7522639adac31beacdcfcb3c31df1aeb3666b4d6547be7ad761153305b7025f8"
                    alt="Banner"
                    class="rounded w-100 h-100"
                    style="object-fit: cover"
                >
                <a class="d-flex justify-content-center">Productomschrijving</a>
            </div>
            <div class="col-md">
                <h5 href="#" class="font-weight-bold d-flex justify-content-center">Product 2</h5>
                <img
                    src="https://img.freepik.com/free-photo/guy-playing-acoustic-guitar_169016-2126.jpg?w=1380&t=st=1701540133~exp=1701540733~hmac=7522639adac31beacdcfcb3c31df1aeb3666b4d6547be7ad761153305b7025f8"
                    alt="Banner"
                    class="rounded w-100 h-100"
                    style="object-fit: cover"
                >
                <a class="d-flex justify-content-center">Productomschrijving</a>
            </div>
            <div class="col-md">
                <h5 href="#" class="font-weight-bold d-flex justify-content-center">Product 3</h5>
                <img
                    src="https://img.freepik.com/free-photo/guy-playing-acoustic-guitar_169016-2126.jpg?w=1380&t=st=1701540133~exp=1701540733~hmac=7522639adac31beacdcfcb3c31df1aeb3666b4d6547be7ad761153305b7025f8"
                    alt="Banner"
                    class="rounded w-100 h-100"
                    style="object-fit: cover"
                >
                <a class="d-flex justify-content-center">Productomschrijving</a>
            </div>
        </div>
    </div>
    <div class="container-lg flex-grow-1 gx-o py-4">
        <div class="row">
            <div class="col-sm-2">
            </div>
            <div class="col-md">
                <h5 href="#" class="font-weight-bold d-flex justify-content-center">Product 4</h5>
                <img
                        src="https://img.freepik.com/free-photo/guy-playing-acoustic-guitar_169016-2126.jpg?w=1380&t=st=1701540133~exp=1701540733~hmac=7522639adac31beacdcfcb3c31df1aeb3666b4d6547be7ad761153305b7025f8"
                        alt="Banner"
                        class="rounded w-100 h-100"
                        style="object-fit: cover"
                >
                <a class="d-flex justify-content-center">Productomschrijving</a>
            </div>
            <div class="col-md">
                <h5 href="#" class="font-weight-bold d-flex justify-content-center">Product 5</h5>
                <img
                        src="https://img.freepik.com/free-photo/guy-playing-acoustic-guitar_169016-2126.jpg?w=1380&t=st=1701540133~exp=1701540733~hmac=7522639adac31beacdcfcb3c31df1aeb3666b4d6547be7ad761153305b7025f8"
                        alt="Banner"
                        class="rounded w-100 h-100"
                        style="object-fit: cover"
                >
                <a class="d-flex justify-content-center">Productomschrijving</a>
            </div>
            <div class="col-md">
                <h5 href="#" class="font-weight-bold d-flex justify-content-center">Product 6</h5>
                <img
                        src="https://img.freepik.com/free-photo/guy-playing-acoustic-guitar_169016-2126.jpg?w=1380&t=st=1701540133~exp=1701540733~hmac=7522639adac31beacdcfcb3c31df1aeb3666b4d6547be7ad761153305b7025f8"
                        alt="Banner"
                        class="rounded w-100 h-100"
                        style="object-fit: cover"
                >
                <a class="d-flex justify-content-center">Productomschrijving</a>
            </div>
        </div>
    </div>
</div>
<!--Plaats hier de pagina elementen-->

        <!--Footer & Scripts-->
        <?php include __DIR__ . "/../Resources/components/layout/footer.php"; ?>
        <?php include __DIR__ . "/../Resources/components/layout/scripts.php"; ?>
    </body>
</html>