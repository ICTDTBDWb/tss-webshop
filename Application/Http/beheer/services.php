<?php

/**
 * Voegt een nieuwe cadeaubon toe aan de database.
 *
 * @param string $code Unieke code van de cadeaubon.
 * @param string $pin PIN van de cadeaubon.
 * @param float $bedrag Het bedrag dat de cadeaubon vertegenwoordigt.
 */
function queryVoegCadeaubonToe($code, $pin, $bedrag) {
    // Maak een instantie van de DatabaseManager klasse.
    $database = new Database();
    // Voer een INSERT-query uit om de cadeaubon toe te voegen.
    $database->query(
        "INSERT INTO cadeaubonnen (code, pin, bedrag) VALUES (?, ?, ?)",
        [$code, $pin, $bedrag]
    );
    // Sluit de databaseverbinding.
    $database->close();
}

/**
 * Verwijdert een cadeaubon uit de database op basis van het opgegeven ID.
 *
 * @param int $cadeaubonId De unieke ID van de cadeaubon die verwijderd moet worden.
 */
function queryVerwijderCadeaubon($cadeaubonId) {
    // Maak een instantie van de DatabaseManager klasse.
    $database = new Database();
    // Voer een DELETE-query uit om de cadeaubon te verwijderen.
    $database->query(
        "DELETE FROM cadeaubonnen WHERE id = ?",
        [$cadeaubonId]
    );
    // Sluit de databaseverbinding.
    $database->close();
}

/**
 * Haalt alle cadeaubonnen op uit de database.
 *
 * @return array Een array van cadeaubonnen.
 */
function queryHaalCadeaubonnenOp() {
    // Maak een instantie van de DatabaseManager klasse.
    $database = new Database();

    // Voer een SELECT-query uit om alle cadeaubonnen op te halen en sla het resultaat op.
    $result = $database->query("SELECT * FROM cadeaubonnen")->get();

    // Sluit de databaseverbinding.
    $database->close();

    // Retourneer het resultaat.
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
    // Maak een instantie van de DatabaseManager klasse.
    $database = new Database();
    // Voer een UPDATE-query uit om de cadeaubon te wijzigen.
    $database->query(
        "UPDATE cadeaubonnen SET code = ?, bedrag = ? WHERE id = ?",
        [$nieuweCode, $nieuwBedrag, $cadeaubonId]
    );
    // Sluit de databaseverbinding.
    $database->close();
}

//Controleer de cadeaubon
function cadeaubonBestaat($code) {
    // Maak een instantie van de DatabaseManager klasse.
    $database = new Database();

    // Voer een SELECT-query uit om te controleren of de cadeaubon al bestaat.
    $result = $database->query(
        "SELECT COUNT(*) AS 'COUNT' FROM cadeaubonnen WHERE code = ?",
        [$code]
    )->first();
//var_dump ($result); exit();
    // Controleer of de query een resultaat heeft opgeleverd
    $cadeaubonBestaat = is_array($result) && $result ['COUNT'] > 0;

    // Sluit de databaseverbinding.
    $database->close();

    // Return true als de cadeaubon al bestaat, anders false
    return $cadeaubonBestaat;

}

/**
 * Functie om te controleren of de input geldig is.
 *
 * Deze functie controleert of de input de juiste lengte heeft en of deze voldoet aan de eisen voor numerieke of alfanumerieke tekens.
 *
 * @param string $input De te valideren input string.
 * @param int $maxLengte De maximale lengte van de input string.
 * @param bool $isNumeriek Geeft aan of de input numeriek moet zijn.
 * @return bool True als de input geldig is, anders False.
 */
function valideerInput($input, $maxLengte, $isNumeriek = false) {
    // Controleer de lengte van de input
    if (strlen($input) > $maxLengte) {
        return false;
    }

    // Controleer het type input
    if ($isNumeriek) {
        // Voor numerieke velden, controleer op alleen cijfers en punt
        return preg_match('/^[0-9.]*$/', $input);
    } else {
        // Voor niet-numerieke velden, controleer op alleen alfanumerieke tekens
        return preg_match('/^[a-zA-Z0-9]*$/', $input);
    }
}

function isValideBedrag($bedrag) {
    return preg_match('/^\d+(\.\d{1,2})?$/', $bedrag);
}












