<?php

include __DIR__ . '/../DatabaseManager.php';

/**
 * Haalt meerdere items op uit de database.
 */
function queryMeerdereItems() {
    $database = new application\DatabaseManager(); // Maak een instantie van de DatabaseManager klasse.
    $result = $database->query("SELECT * FROM klanten")->get(); // Voer een query uit en haal meerdere rijen op.

    $database->close(); // Sluit de database connectie.

    return $result;
}

/**
 * Haalt een enkel item op uit de database op basis van het opgegeven ID.
 */
function queryEnkelItem() {
    $database = new application\DatabaseManager(); // Maak een instantie van de DatabaseManager klasse.
    $result = $database->query(
        "SELECT * FROM klanten WHERE id = ?",
        [1] // Haal de rij op met het opgegeven ID (bijv. ID = 1).
    )->first(); // Voer een query uit en haal een enkele rij op.

    $database->close(); // Sluit de database connectie.

    return $result;
}

/**
 * Voegt een nieuw item toe aan de database.
 */
function queryInsertItem() {
    $database = new application\DatabaseManager(); // Maak een instantie van de DatabaseManager klasse.
    $database->query(
        "INSERT INTO tabel_naam (kolom1, kolom2, kolom3) VALUES (?, ?, ?)",
        ["value1", 2, "value3"]
    ); // Voer een query uit en voeg een nieuwe rij toe aan de gespecificeerde tabel.

    $database->close(); // Sluit de database connectie.
}
