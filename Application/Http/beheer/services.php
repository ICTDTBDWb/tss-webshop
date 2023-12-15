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
