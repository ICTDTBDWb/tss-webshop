<!-- PHP logica -->
<?php
include __DIR__ . "/../../Application/Http/account/services.php";
$session = \application\SessionManager::getInstance();
?>
<?php $current_page = basename($_SERVER['PHP_SELF']);;?>
<!DOCTYPE html>

<html lang="en">
<!--Head-->
<?php include __DIR__ . "/../../Resources/components/layout/head.php"; ?>

<body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
<!--Header-->
<?php include __DIR__ . "/../../Resources/components/layout/header.php"; ?>
<!--Header-->
<?php include __DIR__ . '/../../Application/Http/account/menu.php'; ?>
<!--Pagina content container-->


<!--Pagina content container-->
        <!--Pagina content container-->
        <body>
        <div class="container mt-5">
            <!-- Cadeaubon sectie -->
            <div class="row">
                <div class="col-md-6">
                    <h2>Cadeaubonnen</h2>
                    <form>
                        <div class="mb-3">
                            <label for="cadeaukaartcode" class="form-label">Cadeaukaartcode</label>
                            <input type="text" class="form-control" id="cadeaukaartcode">
                        </div>
                        <button type="submit" class="btn btn-primary">Bekijken en Bewaren</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <h2>Giftbox</h2>
                    <form>
                        <div class="mb-3">
                            <label for="giftboxBedrag" class="form-label">Giftbox bedrag</label>
                            <input type="text" class="form-control" id="giftboxBedrag">
                        </div>
                        <button type="submit" class="btn btn-primary">Toevoegen aan winkelwagen</button>
                    </form>
                </div>
            </div>

            <!-- Cadeaubonnen overzicht -->
            <div class="row mt-4">
                <div class="col-12">
                    <h3>Jouw cadeaubonnen</h3>
                    <!-- Eerste cadeaubon -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Nog te besteden</h5>
                            <p class="card-text">€15,00</p>
                            <p class="card-text"><small class="text-muted">TSS cadeaukaart Restwaarde: €15,00(was € 30,00)</small></p>
                            <p class="card-text"><small class="text-muted">3099-3645-6007-2205-651</small></p>
                        </div>
                    </div>
                    <!-- Tweede cadeaubon -->
                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Nog te besteden</h5>
                            <p class="card-text">€0,00</p>
                            <p class="card-text"><small class="text-muted">TSS cadeaukaart Deze kaart is verbruikt</small></p>
                            <p class="card-text"><small class="text-muted">6064-3645-6107-2205-651</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Footer & Scripts-->
        <?php include __DIR__ . "/../../Resources/components/layout/footer.php"; ?>
        <?php include __DIR__ . "/../../Resources/components/layout/scripts.php"; ?>

        </body>
</html>