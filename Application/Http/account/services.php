<?php
include __DIR__ . "/../../application/DatabaseManager.php";
include __DIR__ . "/../../application/account/models.php";
use \application\DatabaseManager;

function queryKlant($klantId) {
        $database = new DatabaseManager();
        $klanten = $database->query("SELECT * FROM klanten where id = $klantId")->get();
        $klant = new Klant($klanten[0]['voornaam'], $klanten[0]['achternaam'], $klanten[0]['straat'],$klanten[0]['huisnummer'],$klanten[0]['postcode'],$klanten[0]['woonplaats'],$klanten[0]['email'],$klanten[0]['id']);
        return $klant;
}

function queryKlanten() {
    $database = new DatabaseManager();
    $klanten = $database->query("SELECT * FROM klanten")->get();
    return $klanten;
}



function queryLaatstebestellingen($klantId) {
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


function zoekBestellingen($zoekterm)
{
    // Maak verbinding met de database
    // (Vervang dit met je eigen databaseverbinding logica)
    $db = new DatabaseManager();
    $db->connect();

    // Zorg voor veilige zoektermen
    $veiligeZoekterm = $db->escapeString($zoekterm);

    // SQL query
    $query = "SELECT * FROM bestellingen WHERE kolom_naam LIKE '%$veiligeZoekterm%'";

    // Voer de query uit
    $resultaten = $db->query($query);

    $bestellingen = [];
    while ($row = $db->fetchAssoc($resultaten)) {
        $bestellingen[] = $row;
    }

    $db->close();

    return $bestellingen;
}


