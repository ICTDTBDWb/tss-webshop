<!-- PHP logica -->
<?php include __DIR__ . '/../../Application/Http/beheer/klanten.php'; ?>

<!DOCTYPE html>

<html lang="en">
<!--Head-->
<?php include __DIR__ . "/../../Application/Http/components/layout/head.php"; ?>

<body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
<!--Header-->
<?php include __DIR__ . "/../../Resources/components/layout/header.php"; ?>

<!--Menu-->
<?php include __DIR__ . "/../../Application/Http/beheer/menu.php"; ?>

<!--Pagina content container-->
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
<?php include __DIR__ . "/../../Resources/components/layout/footer.php"; ?>
<?php include __DIR__ . "/../../Resources/components/layout/scripts.php"; ?>
</body>
</html><?php
