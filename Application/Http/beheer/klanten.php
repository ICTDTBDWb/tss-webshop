<?php

include __DIR__ . '/../../DatabaseManager.php';
include __DIR__ . '/../../SessionManager.php';
$session = \application\SessionManager::getInstance();

function queryKlanten() {
    $database = new application\DatabaseManager(); // Maak een instantie van de DatabaseManager klasse.
    $result = $database->query("SELECT * FROM klanten")->get(); // Voer een query uit en haal meerdere rijen op.

    $database->close(); // Sluit de database connectie.

    return $result;
}

// Funtion voor query van een enkele klant aan de hand van ID
function queryEnkeleKlant($klantId) {
    $database = new application\DatabaseManager();
    $result = $database->query(
        "SELECT * FROM klanten WHERE id = ?",
        [$klantId]
    )->get();

    $database->close();

    return $result;
}

function updateEnkeleKlant() {
    $database = new application\DatabaseManager();
    $result = $database->query("UPDATE klanten SET email, password, voornaam, tussenvoegsel, achternaam, straat, huisnummer, postcode, woonplaats, land
               WHERE id=?"
    )->get();

    $database->close();

    return $result;

}

function klantVerwijderen($klantId) {
    $database = new application\DatabaseManager();
    $result = $database->query("DELETE klanten FROM klanten WHERE id=",
        [$klantId]
    )->first();

    $database->close();

    return $result;

}

?>