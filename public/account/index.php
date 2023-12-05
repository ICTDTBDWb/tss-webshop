<!-- PHP logica -->
<?php include __DIR__ . '/../../application/account/overzicht.php'; ?>
<?php include_once __DIR__ . '/../../application/DatabaseManager.php';?>

<!DOCTYPE html>

<html lang="en">
<!--Head-->
<?php include __DIR__ . "/../../application/components/layout/head.php"; ?>

<body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
<!--Header-->
<?php include __DIR__ . "/../../application/components/layout/header.php"; ?>
<!--Header-->
<?php include __DIR__ . '/../../application/account/menu.php'; ?>
<!--Pagina content container-->


<div class="container mt-5 text-center">
    <div class="row">
        <?php $laatstebestelling = queryLaatstebestellingen(1);?>
        <!-- Laatste bestellingen sectie -->
        <div class="col-md-9">
            <div class="card">
                <!-- Laatste bestellingen sectie -->
                <div class="card-header">
                    Laatste bestellingen
                </div>
                <div class="card-body">
                    <h6 class="card-text"><?php echo "Product: ".$laatstebestelling->product_naam; ?></h6>
                    <h6 class="card-text"><?php echo "Afbeelding: ".$laatstebestelling->product_foto_pad; ?></h6>

                    <!-- Andere klantgegevens indien nodig -->
                </div>
            </div>
        </div>
    <br>
        <br>
    <div class="row">
        <?php $klant = queryKlant(1);?>
        <div class="col-md-4">
            <div class="card">
                <!-- Klantgegevens sectie -->

                <div class="card-header">
                    Klantgegevens
                </div>
                <div class="card-body">
                    <h6 class="card-text"><?php echo "Naam: ".$klant->voornaam; ?> <?php echo ($klant->achternaam); ?></h6>
                    <h6 class="card-text"><?php echo "Adres: ".$klant->straat; ?> <?php echo ($klant->huisnummer); ?></h6>
                    <h6 class="card-text"><?php echo "Postcode: ".$klant->postcode; ?></h6>
                    <h6 class="card-text"><?php echo "Woonplaats: ".$klant->woonplaats; ?></h6>
                    <h6 class="card-text"><?php echo "Email: ".$klant->email; ?></h6>
                    <h6 class="card-text"><?php echo "Klantnummer: ".$klant->id; ?></h6>
                    <!-- Andere klantgegevens indien nodig -->
                </div>
            </div>
        </div>
        <div class="col-md-4 offset-1">
            <div class="card">
                <!-- Klantgegevens sectie -->

                <div class="card-header">
                    Cadeaubonnen
                </div>
                <div class="card-body">
                    <p class="card-text"><strong>Bon gekregen?</strong></p>
                    <p class="card-text">Check de waarde en voeg het saldo toe aan je account.</p>
                    <!-- Andere klantgegevens indien nodig -->
                </div>
            </div>
        </div>
    </div>


</div>

<!--Footer & Scripts-->
<?php include __DIR__ . "/../../application/components/layout/footer.php"; ?>
<?php include __DIR__ . "/../../application/components/layout/scripts.php"; ?>

</body>
</html>