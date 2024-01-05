<?php

// Functie om klantgegevens op te halen op basis van klantId
function queryKlant($klantId) {
    $database = new Database();
    // Query met prepared statement om SQL injection te voorkomen
    $klanten = $database->query("SELECT * FROM klanten WHERE id = ?", [$klantId])->get();

    // Controleer of er resultaten zijn en retourneer de eerste klant als een array
    return (count($klanten) > 0) ? $klanten[0] : null;
}

// Functie om de laatste bestelling van een klant op te halen
function queryLaatstebestellingen($klantId) {
    $database = new Database();
    $query = "SELECT 
        b.id AS bestelling_id, 
        b.besteldatum, 
        b.totaal, 
        p.naam AS productnaam,
        m.pad AS mediapad,
        m.extensie AS mediaextensie
    FROM 
        tss.bestellingen AS b
    JOIN tss.bestelling_regels AS br ON b.id = br.bestelling_id
    JOIN tss.producten AS p ON br.product_id = p.id
    JOIN tss.media AS m ON p.id = m.product_id
    WHERE 
        b.klant_id = ?
    GROUP BY 
        b.id, 
        b.besteldatum, 
        b.totaal,
        m.pad,
        m.extensie
    ORDER BY 
        b.besteldatum DESC 
    LIMIT 1";




    $resultaat = $database->query($query, [$klantId])->get();
    $database->close();

    return $resultaat;
}

// Functie om bestellingen van een klant op te halen
function haalBestellingenOpVanKlant($klantId) {
    $database = new Database();
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
    $database = new Database();
    $result = $database->query(
        "SELECT bedrag FROM cadeaubonnen WHERE code = ? AND pin = ?",
        [$code, $pin]
    )->first();

    $database->close();

    return $result;
}

// Functie om bestellingen van een klant te zoeken op basis van een zoekterm
function zoekBestellingen($klantId, $zoekterm) {
    $database = new Database();
    $zoekterm = '%' . $zoekterm . '%';

    $query = "SELECT b.*, p.naam AS productnaam FROM tss.bestellingen b 
              JOIN tss.bestelling_regels br ON b.id = br.bestelling_id
              JOIN tss.producten p ON br.product_id = p.id
              WHERE b.klant_id = ? AND (b.id LIKE ? OR p.naam LIKE ?)
              GROUP BY b.id";

    return $database->query($query, [$klantId, $zoekterm, $zoekterm])->get();
}

// Functie om een giftbox toe te voegen aan een winkelwagen
function voegGiftboxToeAanBestelling($product_id, $aantal) {

    if(isset($_SESSION['winkelwagen']['producten'][$product_id])) {
        $_SESSION['winkelwagen']['producten'][$product_id]['hoeveelheid_in_winkelwagen'] += $aantal;
    } else {
        $_SESSION['winkelwagen']['producten'][$product_id] = [
            'id' => $product_id,
            'hoeveelheid_in_winkelwagen' => $aantal,
        ];
    }

}

// Functie om bestellingdetails op te halen op basis van bestellingId
function haalBestellingDetailsOp($klantId,$bestellingId) {
    $database = new Database();

    // Aangepaste query om de details van bestellingen op te halen op basis van klant_id
    $query = "SELECT 
                  b.id AS bestelling_id, 
                  bt.betalingsprovider, 
                  b.totaal AS prijs, 
                  IF(bt.betalingsprovider IS NOT NULL, 'Betaald', 'Niet Betaald') AS status,
                  p.naam AS productnaam,
                  pm.pad AS mediapad,
                  pm.extensie AS mediaextensie
              FROM tss.bestellingen b 
              LEFT JOIN tss.betalingen bt ON b.id = bt.bestelling_id
              JOIN tss.bestelling_regels br ON b.id = br.bestelling_id
              JOIN tss.producten p ON br.product_id = p.id
              LEFT JOIN tss.media pm ON p.id = pm.product_id
              WHERE b.klant_id = ? and b.id = ?";

    return $database->query($query, [$klantId,$bestellingId])->get();
}

function haalGiftboxProductIDMapOp() {
    $database = new Database();

    // query om alleen de giftbox producten op te halen die actief en niet verwijderd zijn
    $query = "SELECT prijs, id FROM producten WHERE is_verwijderd = 0 and is_actief = 1 and id IN (SELECT `product_id` from product_categorieen inner join categorieen on product_categorieen.categorie_id = categorieen.id where categorieen.naam like '%Giftboxen%')";

    // Voer de query uit en haal de resultaten op
    $resultaten = $database->query($query)->get();

    // Initialiseer de map array
    $product_id_map = [];

    // Vul de map met resultaten van de query
    foreach ($resultaten as $row) {
        $product_id_map[$row['prijs']] = $row['id'];
    }

    return $product_id_map;
}


?>
