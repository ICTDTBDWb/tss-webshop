<?php
// Inclusie van de services voor accountbeheer
include basePath("Application/Http/account/services.php");

// Bepalen van de huidige pagina voor form actie
$current_page = basename($_SERVER['PHP_SELF']);
//print $current_page;
// Initialiseren van variabelen voor cadeaukaart verificatie
$verificatieResultaat = null;
$verificatieMelding = '';

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
        // Definiëren van product ID's op basis van giftbox bedragen
        $product_id_map = [
            '25' => 6,
            '50' => 7,
            '75' => 8,
            '100' => 9
        ];

        // Ophalen van de POST data
        $stukprijs = $_POST['giftboxbedrag'];
        $aantal = $_POST['aantal_giftboxes'];
        $product_id = $product_id_map[$stukprijs];

        // Aannemen dat bestelling_id elders bepaald wordt
        $bestelling_id = 1; // Voorbeeld waarde

        // Toevoegen van de giftbox aan de bestelling
        voegGiftboxToeAanBestelling($bestelling_id, $product_id, $aantal, $stukprijs);
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
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cadeaukaartcode'])): ?>
            <p class="alert <?= $verificatieResultaat ? 'alert-success' : 'alert-danger' ?>">
                <?= $verificatieMelding ?>
            </p>
        <?php endif; ?>
    </div>

    <!-- Sectie voor het toevoegen van giftboxes -->
    <div class="col-md-6">
        <h2>Giftbox</h2>
        <form action="<?= $current_page ?>" method="post">
            <!-- Selectie van giftbox bedrag -->
            <div class="mb-3">
                <label for="giftboxbedrag" class="form-label">Giftbox bedrag</label>
                <select class="form-control" id="giftboxbedrag" name="giftboxbedrag" required>
                    <option value="25">€25</option>
                    <option value="50">€50</option>
                    <option value="75">€75</option>
                    <option value="100">€100</option>
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
        <br>
        <!-- Beschrijving van de giftbox -->
        <p>De TSS Giftbox, een cadeaukaart die de ontvanger zelf kan inwisselen bij TSS voor een tegoed in de webwinkel, wordt sfeervol verpakt en kosteloos thuisbezorgd.</p>
        <!-- Afbeelding van een cadeaubon -->
        <img src="/assets/afbeeldingen/cadeaubon.jpg" alt="Cadeaubon Afbeelding" style="max-width: 100%; height: auto;">
    </div>
</div>