<?php

// Funtion voor query van een enkel product aan de hand van ID
function queryEnkelProduct($getProductId) {
    $database = new Database();
    $result = $database->query(
        "SELECT producten.id, producten.naam, producten.beschrijving ,producten.prijs, media.pad, media.extensie
                                        FROM product_categorieen
                                        INNER JOIN producten ON producten.id = product_categorieen.product_id
                                        INNER JOIN categorieen ON categorieen.id = product_categorieen.categorie_id
                                        INNER JOIN media ON media.product_id = product_categorieen.product_id
                                        WHERE producten.id = ? and is_actief=1 AND is_verwijderd=0 GROUP BY producten.id",
        [$getProductId]
    )->get();

    $database->close();

    return $result;
}

// Funtion voor query van overzicht producten per categorie aan de hand van ID
function queryEnkeleCategorie($categorieId) {
    $database = new Database();
    $result = $database->query(
        "SELECT categorie_id, product_categorieen.product_id, producten.naam, producten.prijs, media.pad, media.extensie
                                        FROM product_categorieen
                                        INNER JOIN producten ON producten.id = product_categorieen.product_id
                                        INNER JOIN categorieen ON categorieen.id = product_categorieen.categorie_id
                                        INNER JOIN media ON media.product_id = product_categorieen.product_id
                                        WHERE categorie_id = ? and is_actief=1 AND is_verwijderd=0 GROUP BY producten.id",
        [$categorieId]
    )->get();

    $database->close();

    return $result;
}

// Functie voor query van de naam van categorieen
function queryCategorieen() {
    $database = new Database(); // Maak een instantie van de DatabaseManager klasse.
    $result = $database->query("SELECT * FROM categorieen where naam not like '%Giftboxen%'")->get(); // Voer een query uit en haal meerdere rijen op.

    $database->close(); // Sluit de database connectie.

    return $result;
}

// Funtion voor query van product informatie en bijbehorende afbeelding aan de hand van ID
function queryProductEnAfbeelding() {
    $query = "SELECT producten.id, producten.naam, producten.prijs, media.product_id, media.pad, media.extensie, product_categorieen.categorie_id
FROM product_categorieen
INNER JOIN producten ON producten.id = product_categorieen.product_id
INNER JOIN categorieen ON categorieen.id = product_categorieen.categorie_id
INNER JOIN media ON media.product_id = product_categorieen.product_id
WHERE is_actief=1 AND is_verwijderd=0 ";

    if (isset($_GET['zoeken']) && strlen($_GET['zoeken']) >= 3) {
        $query .= " AND producten.naam LIKE '%{$_GET['zoeken']}%'";
    }

    $database = new Database(); // Maak een instantie van de DatabaseManager klasse.
    $result = $database->query($query)->get(); // Voer een query uit en haal meerdere rijen op.

    $database->close(); // Sluit de database connectie.

    return $result;
}

// Functie om een product toe te voegen aan een winkelwagen
function voegProductToeAanBestelling($product_id, $aantal) {
    $_SESSION["winkelwagen"]["producten"][] = [
        "id" => $product_id,
        "hoeveelheid_in_winkelwagen" => $aantal,
    ];
}


?>