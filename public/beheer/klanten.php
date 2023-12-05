<!-- PHP logica -->
<?php include __DIR__ . '/../../application/beheer/klanten.php'; ?>

<!DOCTYPE html>

<html lang="en">
<!--Head-->
<?php include __DIR__ . "/../../application/components/layout/head.php"; ?>

<body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
<!--Header-->
<?php include __DIR__ . "/../../application/components/layout/header.php"; ?>

<!--Pagina content container-->
<div class="container-lg flex-grow-1 gx-0 py-4">
    <div class="d-flex justify-content-center">
        <h1 class="mt-0 font-weight-bold mb-5">Beheerdersportaal</h1>
    </div>
    <!--Button overzicht-->
    <div class="mt-2 mb-5 d-flex justify-content-evenly" style="max-width: 75%">
    <a class="btn btn-secondary" href="#" role="button">Beheeroverzicht</a>
    <a class="btn btn-secondary" href="#" role="button">Accountgegevens</a>
    <a class="btn btn-secondary" href="#" role="button">Productbeheer</a>
    <a class="btn btn-secondary" href="#" role="button">Overzicht bestellingen</a>
    <a class="btn btn-secondary active" href="/beheer/klanten.php" role="button">Klantbeheer</a>
    </div>
            <!--Zoekbalk rechts-->
            <div class="input-group d-flex justify-content-end">
            <input type="text" name="search" id="header-search" style="max-width: 25%"
                   placeholder="Klant zoeken."
                   aria-label="Klant zoeken."
                   aria-describedby="addon-wrapping"
                   class="form-control border"
            >
            <button class="btn btn-outline-light border text-dark" type="button">
                <i class="fa fa-search"></i>
            </button>
        </div>
    <!--Plaats hier de pagina elementen-->
</div>

<!--Footer & Scripts-->
<?php include __DIR__ . "/../../application/components/layout/footer.php"; ?>
<?php include __DIR__ . "/../../application/components/layout/scripts.php"; ?>
</body>
</html><?php
