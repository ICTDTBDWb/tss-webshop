<?php
$auth->protectPage();
// Inclusie van de services voor accountbeheer en de aparte functie
include basePath("Application/Http/account/services.php");


// Bepalen van de huidige pagina voor form actie
$current_page = basename($_SERVER['PHP_SELF']);

// Initialiseren van variabelen voor cadeaukaart verificatie
$verificatieResultaat = null;
$verificatieMelding = '';
$foutmelding = '';

// Haal de product_id_map dynamisch op uit de database
$product_id_map = haalGiftboxProductIDMapOp();

// Controleren of de huidige request een POST request is
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verwerken van cadeaukaartgegevens indien beschikbaar
    if (isset($_POST['cadeaukaartcode'], $_POST['pincode'])) {
        $code = $_POST['cadeaukaartcode'];
        $pin = $_POST['pincode'];

        // Verifiëren van de cadeaubon en opslaan van het resultaat
        $verificatieResultaat = verifieerCadeaubon($code, $pin);

        // Opstellen van een bericht op basis van de verificatie
        $verificatieMelding = $verificatieResultaat
            ? "Het saldo van de cadeaubon is: €" . htmlspecialchars($verificatieResultaat['bedrag'])
            : "De ingevoerde cadeauboncode of PIN is ongeldig.";
    }

    // Verwerken van giftbox gegevens indien beschikbaar
    if (isset($_POST['giftboxbedrag'], $_POST['aantal_giftboxes'])) {
        // Ophalen van de POST data
        $stukprijs = $_POST['giftboxbedrag'];
        $aantal = $_POST['aantal_giftboxes'];
        $product_id = isset($product_id_map[$stukprijs]) ? $product_id_map[$stukprijs] : null;

        // Als het product_id bestaat, voeg de giftbox toe aan de bestelling
        if ($product_id) {
            voegGiftboxToeAanBestelling($product_id, $aantal);
            header('Location: /account/cadeaubonnen');
            exit();
        } else {
            // Anders, toon een foutmelding
            $foutmelding = "Er is een ongeldig giftboxbedrag geselecteerd.";
        }
    }
}
?>

<!-- Menu van de accountpagina -->
<?php include basePath("Application/Http/account/menu.php"); ?>

<div class="row">
    <!-- Sectie voor het verifiëren van cadeaubonnen -->
    <div class="col-md-6">
        <h2>Cadeaubonnen</h2>
        <form action="/account/cadeaubonnen" method="post">
            <!-- Veld voor het invoeren van de cadeaukaartcode -->
            <div class="mb-3">
                <label for="cadeaukaartcode" class="form-label">Cadeaukaartcode</label>
                <input type="text" class="form-control" id="cadeaukaartcode" name="cadeaukaartcode" required>
            </div>
            <!-- Veld voor het invoeren van de PIN -->
            <div class="mb-3">
                <label for="pincode" class="form-label">PIN</label>
                <input type="password" class="form-control" id="pincode" name="pincode" required>
            </div>
            <!-- Verzendknop -->
            <button type="submit" class="btn btn-primary">Cadeaubon Verifiëren</button>
        </form>
        <!-- Toon bericht na verificatie -->
        <?php if ($verificatieResultaat): ?>
            <p class="alert alert-success">
                <?= $verificatieMelding ?>
            </p>
        <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cadeaukaartcode'])): ?>
            <p class="alert alert-danger">
                <?= $verificatieMelding ?>
            </p>
        <?php endif; ?>
    </div>

    <!-- Sectie voor het toevoegen van giftboxes -->
    <div class="col-md-6">
        <h2>Giftbox</h2>
        <form action="" method="post">
            <!-- Selectie van giftbox bedrag -->
            <div class="mb-3">
                <label for="giftboxbedrag" class="form-label">Bedrag</label>
                <select class="form-control" id="giftboxbedrag" name="giftboxbedrag" required>
                    <?php
                    // Toon de giftbox opties op basis van de beschikbare ID's en bedragen
                    foreach ($product_id_map as $prijs => $id) {
                        echo "<option value=\"{$prijs}\">€{$prijs}</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Veld voor het aantal giftboxes -->
            <div class="mb-3">
                <label for="aantal_giftboxes" class="form-label">Aantal</label>
                <input type="number" class="form-control" id="aantal_giftboxes" name="aantal_giftboxes" required min="1">
            </div>
            <!-- Verzendknop -->
            <button type="submit" class="btn btn-primary">Toevoegen aan winkelwagen</button>
        </form>
        <!-- Toon foutmelding indien aanwezig -->
        <?php if ($foutmelding): ?>
            <p class="alert alert-danger"><?= $foutmelding ?></p>
        <?php endif; ?>
        <!-- Beschrijving van de giftbox -->
        <br>
        <p>De TSS Giftbox, een cadeaukaart die de ontvanger zelf kan inwisselen bij TSS voor een tegoed in de webwinkel, wordt sfeervol verpakt en kosteloos thuisbezorgd.</p>
        <!-- Afbeelding van een cadeaubon -->
        <img src="/assets/afbeeldingen/cadeaubon.jpg" alt="Cadeaubon Afbeelding" style="max-width: 100%; height: auto;">
    </div>
</div>
