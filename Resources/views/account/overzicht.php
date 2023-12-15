<?php
// Plaats van benodigde PHP-bestanden en sessiebeheer
include basePath('/Application/Http/account/services.php');
?>

<?php include basePath('/Application/Http/account/menu.php'); ?>
    <div class="row">
        <?php
        // Ophalen van de laatste bestelling(en)
        $laatstebestellingen = queryLaatstebestellingen(1);
        if (count($laatstebestellingen) > 0) {
            // Als er bestellingen zijn, toon de details
            ?>
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        Laatste bestelling
                    </div>
                    <div class="card-body">
                        <?php foreach ($laatstebestellingen as $laatstebestelling) { ?>
                            <a href="bestelling_detail?id=<?php echo urlencode($laatstebestelling['bestelling_id']); ?>" class="text-decoration-none text-dark">
                                <p class="card-text"><strong>Product:</strong> <?php echo $laatstebestelling['productnaam']; ?></p>
                                <img class="" src="<?php echo $laatstebestelling['mediapad']; ?>" style="width: 512px; height: auto;"/>
                            </a>
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
                                        <?php
                                        // Ophalen van klantgegevens
                                        $klant = queryKlant(1);
                                        if ($klant) {
                                            echo "<p class='card-text'><strong>Naam:</strong> " . $klant['voornaam'] . " " . $klant['achternaam'] . "</p>";
                                            echo "<p class='card-text'><strong>Adres:</strong> " . $klant['straat'] . " " . $klant['huisnummer'] . "</p>";
                                            echo "<p class='card-text'><strong>Postcode:</strong> " . $klant['postcode'] . "</p>";
                                            echo "<p class='card-text'><strong>Woonplaats:</strong> " . $klant['woonplaats'] . "</p>";
                                            echo "<p class='card-text'><strong>Email:</strong> " . $klant['email'] . "</p>";
                                            echo "<p class='card-text'><strong>Klantnummer:</strong> " . $klant['id'] . "</p>";
                                        } else {
                                            echo "<p>Klantgegevens niet gevonden.</p>";
                                        }
                                        ?>
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
                                            Check de waarde van je cadeaubon:
                                            <a href="/account/cadeaubonnen">cadeaubonnenpagina</a>.
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
    </div>
</div>
