<!-- PHP logica -->
<?php include __DIR__ . '/../application/producten.php'; ?>

<!DOCTYPE html>

<html lang="en">
<!--Head-->
<?php include __DIR__ . "/../application/components/layout/head.php"; ?>

<body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
<!--Header-->
<?php include __DIR__ . "/../application/components/layout/header.php"; ?>

<!--Pagina content container-->
<div class="container-lg flex-grow-1 gx-0 py-4">
    <div class="d-flex justify-content-center">
        <h1 class="mt-0 font-weight-bold mb-5">Producten</h1>
    </div>
    <!--Weergave categorien-->
    <div class="container-lg flex-grow-1 gx-o py-4">
        <div class="list-group justify-content-start" style="max-width: 25%">
            <h5 class="font-weight-bold d-flex justify-content-center">Categorien</h5>
            <a href="#" class="list-group-item list-group-item-action">Akoestische gitaar</a>
            <a href="#" class="list-group-item list-group-item-action">Electrische gitaar</a>
            <a href="#" class="list-group-item list-group-item-action">Basgitaar</a>
            <a href="#" class="list-group-item list-group-item-action">Kindergitaar</a>
        </div>
    </div>
</div>
<!--Plaats hier de pagina elementen-->

<!--Footer & Scripts-->
<?php include __DIR__ . "/../application/components/layout/footer.php"; ?>
<?php include __DIR__ . "/../application/components/layout/scripts.php"; ?>
</body>
</html>