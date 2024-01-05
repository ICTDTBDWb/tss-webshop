<?php

// Funtion voor query om alle klanten weer te geven
function queryKlanten() {
    $database = new Database(); // Maak een instantie van de DatabaseManager klasse.
    $result = $database->query("SELECT * FROM klanten")->get(); // Voer een query uit en haal meerdere rijen op.

    $database->close(); // Sluit de database connectie.

    return $result;
}

// Funtion voor query van een enkele klant aan de hand van ID
function queryEnkeleKlant($klantId) {
    $database = new Database();
    $result = $database->query(
        "SELECT * FROM klanten WHERE id = ?",
        [$klantId]
    )->get();

    $database->close();

    return $result;
}


// Funtion voor query voor het opzoeken van een klant op basis van voornaam of achternaam
function zoekKlanten($zoekKlantNaam) {
    $database = new Database();
    $zoekKlantNaam = '%' . $zoekKlantNaam . '%';

    $query = "SELECT * FROM klanten WHERE voornaam LIKE ? OR achternaam LIKE ?";

    // Execute the query
    $result = $database->query($query, [$zoekKlantNaam, $zoekKlantNaam])->get();

    // Close the database connection
    $database->close();

    return $result;
}