<?php

include(__DIR__ . '/../../DatabaseManager.php');
include(__DIR__ . '/../../SessionManager.php');
use \application\DatabaseManager;

function queryKlant($klantId) {
    $database = new DatabaseManager();
    $klanten = $database->query("SELECT * FROM klanten WHERE id = $klantId")->get();

    // Controleer of er resultaten zijn en retourneer de eerste klant als een array
    return (count($klanten) > 0) ? $klanten[0] : null;
}


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

    $resultaat = $database->query($query, [$klantId])->get(); // De query methode moet worden aangepast om prepared statements te ondersteunen.
    $database->close();

    return $resultaat;
}


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





