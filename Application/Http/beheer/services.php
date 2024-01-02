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
 * Functie om input te valideren en ongewenste tekens aan te passen.
 *
 * Deze functie trimt de input, beperkt deze tot de maximale lengte en verwijdert ongewenste tekens.
 * Als het een numeriek veld is, worden alleen cijfers en het punt (.) toegestaan.
 * Voor niet-numerieke velden worden alleen alfanumerieke tekens toegestaan.
 *
 * @param string $input De te valideren input string.
 * @param int $maxLengte De maximale lengte van de input string.
 * @param bool $isNumeriek Geeft aan of de input numeriek moet zijn.
 * @return string De gevalideerde en aangepaste input string.
 */
function valideerInput($input, $maxLengte, $isNumeriek = false) {
    // Trim de input en beperk tot de maximale lengte
    $input = substr(trim($input), 0, $maxLengte);

    // Verwijder ongewenste tekens afhankelijk van het type input
    if ($isNumeriek) {
        // Voor numerieke velden, verwijder alles behalve cijfers en punt
        $input = preg_replace('/[^0-9.]/', '', $input);
    } else {
        // Voor niet-numerieke velden, verwijder alles behalve alfanumerieke tekens
        $input = preg_replace('/[^a-zA-Z0-9]/', '', $input);
    }

    return $input;
}

/**
 * Controleert of een bedrag valide is.
 *
 * Een bedrag is valide als het een numerieke waarde is met maximaal twee decimalen.
 *
 * @param string $bedrag De te controleren bedrag string.
 * @return bool True als het bedrag valide is, anders False.
 */
function isValideBedrag($bedrag) {
    return preg_match('/^\d+(\.\d{1,2})?$/', $bedrag);
}

/**
 * Controleert of de lengte van een input string binnen de vereiste lengte valt.
 *
 * @param string $input De te controleren input string.
 * @param int $vereisteLengte De maximale toegestane lengte van de input.
 * @return bool True als de lengte van de input binnen de vereiste lengte valt, anders False.
 */
function isValideLengte($input, $vereisteLengte) {
    return strlen($input) <= $vereisteLengte;
}










