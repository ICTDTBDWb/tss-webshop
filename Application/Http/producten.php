<?php

include __DIR__ . '/DatabaseManager.php';

/**
 * Haalt meerdere items op uit de database.
 */
function queryCategorieen() {
    $database = new \application\DatabaseManager(); // Maak een instantie van de DatabaseManager klasse.
    $result = $database->query("SELECT naam FROM categorieen")->get(); // Voer een query uit en haal meerdere rijen op.

    $database->close(); // Sluit de database connectie.

    return $result;
}

/**
 * Haalt een enkel item op uit de database op basis van het opgegeven ID.
 */
function queryCategorie1() {
    $database = new \application\DatabaseManager(); // Maak een instantie van de DatabaseManager klasse.
    $result = $database->query(
        "SELECT naam FROM categorieen WHERE id = ?",
        [1] // Haal de rij op met het opgegeven ID (bijv. ID = 1).
    )->first(); // Voer een query uit en haal een enkele rij op.

    $database->close(); // Sluit de database connectie.

    return $result;
}

function queryCategorie2() {
    $database = new \application\DatabaseManager(); // Maak een instantie van de DatabaseManager klasse.
    $result = $database->query(
        "SELECT naam FROM categorieen WHERE id = ?",
        [2] // Haal de rij op met het opgegeven ID (bijv. ID = 1).
    )->first(); // Voer een query uit en haal een enkele rij op.

    $database->close(); // Sluit de database connectie.

    return $result;
}

function queryCategorie3() {
    $database = new \application\DatabaseManager(); // Maak een instantie van de DatabaseManager klasse.
    $result = $database->query(
        "SELECT naam FROM categorieen WHERE id = ?",
        [4] // Haal de rij op met het opgegeven ID (bijv. ID = 1).
    )->first(); // Voer een query uit en haal een enkele rij op.

    $database->close(); // Sluit de database connectie.

    return $result;
}

function queryCategorie4() {
    $database = new \application\DatabaseManager(); // Maak een instantie van de DatabaseManager klasse.
    $result = $database->query(
        "SELECT naam FROM categorieen WHERE id = ?",
        [3] // Haal de rij op met het opgegeven ID (bijv. ID = 1).
    )->first(); // Voer een query uit en haal een enkele rij op.

    $database->close(); // Sluit de database connectie.

    return $result;
}

$categorie1 = queryCategorie1();
$categorie2 = queryCategorie2();
$categorie3 = queryCategorie3();
$categorie4 = queryCategorie4();


?>