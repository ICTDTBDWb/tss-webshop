<?php
include(__DIR__ . '/../../DatabaseManager.php');
include(__DIR__ . '/../../SessionManager.php');
use \application\DatabaseManager;
/**
 * Voegt een nieuwe cadeaubon toe aan de database.
 */
function queryVoegCadeaubonToe($code, $pin, $bedrag) {
    $database = new application\DatabaseManager();
    $database->query(
        "INSERT INTO cadeaubonnen (code, pin, bedrag) VALUES (?, ?, ?)",
        [$code, $pin, $bedrag]
    );
    $database->close();
}

/**
 * Verwijdert een cadeaubon uit de database op basis van het opgegeven ID.
 */
function queryVerwijderCadeaubon($cadeaubonId) {
    $database = new application\DatabaseManager();
    $database->query(
        "DELETE FROM cadeaubonnen WHERE id = ?",
        [$cadeaubonId]
    );
    $database->close();
}

/**
 * Haalt alle cadeaubonnen op uit de database.
 *
 * @return array Een array van cadeaubonnen.
 */
function queryHaalCadeaubonnenOp() {
    $database = new application\DatabaseManager(); // Maak een instantie van de DatabaseManager klasse.

    // Voer een query uit om alle cadeaubonnen op te halen.
    $result = $database->query("SELECT * FROM cadeaubonnen")->get();

    $database->close(); // Sluit de database connectie.

    return $result;
}

/**
 * Wijzigt een bestaande cadeaubon in de database.
 *
 * @param int $cadeaubonId De ID van de cadeaubon die gewijzigd moet worden.
 * @param string $nieuweCode De nieuwe code van de cadeaubon.
 * @param float $nieuwBedrag Het nieuwe bedrag van de cadeaubon.
 */
function queryWijzigCadeaubon($cadeaubonId, $nieuweCode, $nieuwBedrag) {
    $database = new application\DatabaseManager();
    $database->query(
        "UPDATE cadeaubonnen SET code = ?, bedrag = ? WHERE id = ?",
        [$nieuweCode, $nieuwBedrag, $cadeaubonId]
    );
    $database->close();
}

?>
