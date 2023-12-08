<!-- PHP logica -->
<?php include __DIR__ . '/../../application/account/services.php'; ?>
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
        <?php
        $laatstebestellingen = queryLaatstebestellingen(1);
        if (count($laatstebestellingen) > 0) {
            // Als er bestellingen zijn, toon de details
            ?>
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        Laatste bestellingen
                    </div>
                    <div class="card-body">
                        <?php foreach ($laatstebestellingen as $laatstebestelling) { ?>
                            <h6 class="card-text">Product: <?php echo $laatstebestelling['productnaam']; ?></h6>
                            <h6 class="card-text">Afbeelding: <?php echo $laatstebestelling['mediapad']; ?></h6>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php
        } else {
            // Als er geen bestellingen zijn, toon een bericht
            ?>
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        Laatste bestellingen
                    </div>
                    <div class="card-body">
                        <p>Er zijn geen bestellingen gevonden</p>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>




    <br>
        <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="container mt-5 text-center">
                    <!-- Andere inhoud... -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="row no-gutters"> <!-- Rij binnen de kaart zonder tussenruimte -->
                                    <!-- Klantgegevens sectie -->
                                    <div class="col-md-6">
                                        <div class="card-header">
                                            Klantgegevens
                                        </div>
                                        <div class="card-body">
                                            <?php $klant = queryKlant(1); ?>
                                            <h6 class="card-text"><?php echo "Naam: ".$klant->voornaam; ?> <?php echo ($klant->achternaam); ?></h6>
                                            <h6 class="card-text"><?php echo "Adres: ".$klant->straat; ?> <?php echo ($klant->huisnummer); ?></h6>
                                            <h6 class="card-text"><?php echo "Postcode: ".$klant->postcode; ?></h6>
                                            <h6 class="card-text"><?php echo "Woonplaats: ".$klant->woonplaats; ?></h6>
                                            <h6 class="card-text"><?php echo "Email: ".$klant->email; ?></h6>
                                            <h6 class="card-text"><?php echo "Klantnummer: ".$klant->id; ?></h6>
                                        </div>
                                    </div>


                                    <!-- Cadeaubonnen sectie -->
                                    <div class="col-md-6">
                                        <div class="card-header">
                                            Cadeaubonnen
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text"><strong>Bon gekregen?</strong></p>
                                            <p class="card-text">
                                                Check de waarde en voeg het saldo toe aan je account op de
                                                <a href="/account/cadeaubonnen.php">cadeaubonnenpagina</a>.
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Andere inhoud... -->
                </div>



</div>

<!--Footer & Scripts-->
<?php include __DIR__ . "/../../application/components/layout/footer.php"; ?>
<?php include __DIR__ . "/../../application/components/layout/scripts.php"; ?>

</body>
</html>