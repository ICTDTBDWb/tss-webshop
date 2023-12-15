<?php

include __DIR__ . '/../DatabaseManager.php';
include __DIR__ . '/../SessionManager.php';
$session = \application\SessionManager::getInstance();


// Funtion voor query van een enkel product aan de hand van ID
function queryEnkelProduct($productId) {
    $database = new application\DatabaseManager();
    $result = $database->query(
        "SELECT * FROM producten WHERE id = ?",
        [$productId]
    )->get();

    $database->close();

    return $result;
}

// Functie voor query van meerdere producten
function queryProducten() {
    $database = new \application\DatabaseManager(); // Maak een instantie van de DatabaseManager klasse.
    $result = $database->query("SELECT * FROM producten")->get(); // Voer een query uit en haal meerdere rijen op.

    $database->close(); // Sluit de database connectie.

    return $result;
}

// Functie voor query van de naam van categorieen
function queryCategorieen() {
    $database = new \application\DatabaseManager(); // Maak een instantie van de DatabaseManager klasse.
    $result = $database->query("SELECT naam FROM categorieen")->get(); // Voer een query uit en haal meerdere rijen op.

    $database->close(); // Sluit de database connectie.

    return $result;
}

// Functie voor query van producten en categorieen
function queryProductCategorieen() {
    $database = new \application\DatabaseManager(); // Maak een instantie van de DatabaseManager klasse.
    $result = $database->query("SELECT categorie_id, product_id, producten.naam, categorieen.naam
                                        FROM product_categorieen
                                        JOIN categorieen ON categorieen.id = product_categorieen.categorie_id
                                        JOIN producten ON producten.id = product_categorieen.product_id
                                        WHERE categorie_id = 1")
        ->get(); // Voer een query uit en haal meerdere rijen op.

    $database->close(); // Sluit de database connectie.

    return $result;
}

?>