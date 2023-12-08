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
function SluitVerbinding($connection) {
    $connection = null;
}

?>
