<?php

include(__DIR__ . '/../../DatabaseManager.php');
include(__DIR__ . '/../../SessionManager.php');
use \application\DatabaseManager;

// Functie om klantgegevens op te halen op basis van klantId
function queryKlant($klantId) {
    $database = new DatabaseManager();
    $klanten = $database->query("SELECT * FROM klanten WHERE id = $klantId")->get();

    // Controleer of er resultaten zijn en retourneer de eerste klant als een array
    return (count($klanten) > 0) ? $klanten[0] : null;
}

// Functie om de laatste bestelling van een klant op te halen
function queryLaatstebestellingen($klantId) {
    $database = new \application\DatabaseManager();
    $query = "SELECT 
    b.id AS bestelling_id, 
    b.besteldatum, 
    b.totaal, 
    p.naam AS productnaam,
    pm.pad AS mediapad
FROM 
    tss.bestellingen AS b
JOIN tss.bestelling_regels AS br ON b.id = br.bestelling_id
JOIN tss.producten AS p ON br.product_id = p.id
JOIN tss.product_media AS prm ON p.id = prm.product_id
JOIN tss.media AS pm ON prm.media_id = pm.id
WHERE 
    b.klant_id = ? -- Vervang '?' met de specifieke klant_id.
GROUP BY 
    b.id, 
    b.besteldatum, 
    b.totaal
ORDER BY 
    b.besteldatum DESC 
LIMIT 1
";

    $resultaat = $database->query($query, [$klantId])->get();
    $database->close();

    return $resultaat;
}

// Functie om bestellingen van een klant op te halen
function haalBestellingenOpVanKlant($klantId) {
    $database = new \application\DatabaseManager();
    $query = "SELECT 
    b.id AS bestelling_id, 
    b.besteldatum, 
    b.totaal, 
    (SELECT p.naam FROM tss.producten p JOIN tss.bestelling_regels br ON p.id = br.product_id WHERE br.bestelling_id = b.id LIMIT 1) AS productnaam,
    (SELECT pm.pad FROM tss.media pm JOIN tss.product_media prm ON pm.id = prm.media_id JOIN tss.bestelling_regels br ON prm.product_id = br.product_id WHERE br.bestelling_id = b.id LIMIT 1) AS mediapad
FROM 
    tss.bestellingen AS b
WHERE 
    b.klant_id = ? -- Vervang '?' met de specifieke klant_id.
GROUP BY 
    b.id, 
    b.besteldatum, 
    b.totaal
ORDER BY 
    b.besteldatum DESC
";

    $resultaat = $database->query($query, [$klantId])->get(); // De query methode moet worden aangepast om prepared statements te ondersteunen.
    $database->close();

    return $resultaat;
}

/**
 * Verifieert de cadeauboncode en PIN en haalt het saldo op uit de database.
 *
 * @param string $code De cadeauboncode die geverifieerd moet worden.
 * @param string $pin De PIN van de cadeaubon die geverifieerd moet worden.
 * @return array|null Het resultaat van de database query of null als de code en/of PIN niet klopt(en).
 */
function verifieerCadeaubon($code, $pin) {
    $database = new application\DatabaseManager();
    $result = $database->query(
        "SELECT bedrag FROM cadeaubonnen WHERE code = ? AND pin = ?",
        [$code, $pin]
    )->first();

    $database->close();

    return $result;
}

// Functie om bestellingen van een klant te zoeken op basis van een zoekterm
function zoekBestellingen($klantId, $zoekterm) {
    $database = new \application\DatabaseManager();
    $zoekterm = '%' . $zoekterm . '%';

    $query = "SELECT b.*, p.naam AS productnaam FROM tss.bestellingen b 
              JOIN tss.bestelling_regels br ON b.id = br.bestelling_id
              JOIN tss.producten p ON br.product_id = p.id
              WHERE b.klant_id = ? AND (b.id LIKE ? OR p.naam LIKE ?)
              GROUP BY b.id";

    return $database->query($query, [$klantId, $zoekterm, $zoekterm])->get();
}

// Functie om een giftbox toe te voegen aan een bestelling
function voegGiftboxToeAanBestelling($bestelling_id, $product_id, $aantal, $stukprijs) {
    $database = new application\DatabaseManager();
    $totaal = $stukprijs * $aantal;
    $result = $database->query(
        "INSERT INTO `tss`.`bestelling_regels` (`bestelling_id`, `product_id`, `aantal`, `stukprijs`, `totaal`) VALUES (?, ?, ?, ?, ?)",
        [$bestelling_id, $product_id, $aantal, $stukprijs, $totaal]
    );
    $database->close();
    return $result;
}

// Functie om bestellingdetails op te halen op basis van bestellingId
function haalBestellingDetailsOp($bestellingId) {
    $database = new \application\DatabaseManager();

    // Aangepaste query om bestelling_id, betaalprovider_id, prijs, status, productnaam en mediapad op te halen
    $query = "SELECT b.id AS bestelling_id, bt.betalingsprovider, b.totaal AS prijs, 
                     IF(bt.betalingsprovider IS NOT NULL, 'Betaald', 'Niet Betaald') AS status,
                     (SELECT p.naam FROM tss.producten p 
                      JOIN tss.bestelling_regels br ON p.id = br.product_id 
                      WHERE br.bestelling_id = b.id LIMIT 1) AS productnaam,
                     (SELECT pm.pad FROM tss.media pm 
                      JOIN tss.product_media prm ON pm.id = prm.media_id 
                      JOIN tss.bestelling_regels br ON prm.product_id = br.product_id 
                      WHERE br.bestelling_id = b.id LIMIT 1) AS mediapad
              FROM tss.bestellingen b 
              LEFT JOIN tss.betalingen bt ON b.id = bt.bestelling_id
              WHERE b.id = ?";

    return $database->query($query, [$bestellingId])->get();
}

?>
