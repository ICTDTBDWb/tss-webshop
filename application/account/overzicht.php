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
    $database = new DatabaseManager();
    // SQL-query
    $laatstebestellingen = $database->query("SELECT 
                b.klant_id AS klant_id,
                b.id AS bestelling_id,
                p.naam AS product_naam, 
                m.pad AS product_foto_pad, 
                m.naam AS product_foto_naam,
                b.besteldatum
            FROM 
                tss.bestellingen b
            INNER JOIN 
                tss.bestelling_regels br ON b.id = br.bestelling_id
            INNER JOIN 
                tss.producten p ON br.product_id = p.id
            INNER JOIN 
                tss.product_media pm ON p.id = pm.product_id
            INNER JOIN 
                tss.media m ON pm.media_id = m.id
            WHERE 
            b.klant_id = $klantId
            ORDER BY 
                b.besteldatum DESC
            LIMIT 10")->get();
    $laatstebestelling = new Laatstebestelling($laatstebestellingen[0]['bestelling_id'],$laatstebestellingen[0]['product_naam'], $laatstebestellingen[0]['product_foto_pad'], $laatstebestellingen[0]['product_foto_naam'],$laatstebestellingen[0]['besteldatum'],$laatstebestellingen[0]['klant_id']);
    return $laatstebestelling;
}



function SluitVerbinding($connection) {
    $connection = null;
}

?>
