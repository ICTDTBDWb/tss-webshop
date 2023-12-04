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


            <div class="container mt-5">


                <div class="row">



                    <?php $klant = queryKlant(1);?>
                    <div class="col-md-4">
                        <div class="card">

                            <div class="card-body">
                                <!-- Laatste bestellingen sectie -->
                                <div class="card-header">
                                    Laatste bestellingen</div>
                            <!-- Klantgegevens sectie -->
                            <div class="card-header">
                                Klantgegevens</div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo "Naam: ".$klant->voornaam; ?> <?php echo ($klant->achternaam); ?></h5>
                                <h5 class="card-title"><?php echo "Adres: ".$klant->straat; ?> <?php echo ($klant->huisnummer); ?></h5>
                                <h5 class="card-title"><?php echo "Postcode: ".$klant->postcode; ?></h5>
                                <h5 class="card-title"><?php echo "Woonplaats: ".$klant->woonplaats; ?></h5>
                                <h5 class="card-title"><?php echo "Email: ".$klant->email; ?></h5>
                                <h5 class="card-title"><?php echo "Klantnummer: ".$klant->id; ?></h5>
                                <!-- Andere klantgegevens indien nodig -->

                                <!-- Cadeaubonnen -->
                                <div class="card-header">
                                    Cadeaubonnen</div>




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