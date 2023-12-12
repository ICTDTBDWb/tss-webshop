<?php

function bestellingOpslaan(int $klant_id, int $verzendmethode_id, $totaal, string $betaalmethode, array $producten)
{
    $datum = date('Y-m-d H:i:s');

    $dbm = new PDO("mysql:host=host.docker.internal;port=3308;dbname=tss;charset=utf8mb4", "root", "root");
try{
// Bestelling toevoegen
    $bestelling_query =
        "INSERT INTO " .
        "bestellingen ( " .
        "klant_id, " .
        "verzendmethode_id, " .
        "besteldatum, " .
        "totaal ) " .
        "VALUES ( " .
        $klant_id . ", " .
        $verzendmethode_id . ", " .
        "'" . $datum . "', " .
        $totaal . ")";


    $dbm->beginTransaction();
    $dbm->exec($bestelling_query);
    $bestelling_id = $dbm->lastInsertId();

// Betalijng toevoegen
    $betaling_query =
        "INSERT INTO " .
        "betalingen ( " .
        "bestelling_id, " .
        "betalingsprovider, " .
        "datum, " .
        "totaal ) " .
        "VALUES ( " .
        $bestelling_id . ", " .
        "'" . $betaalmethode . "', " .
        "'" . $datum . "', " .
        '0' . " ) ";

    $dbm->exec($betaling_query);


// Producten toevoegen
    foreach ($producten as $product) {
        $cadeaubon_id = 'NULL';
        $bestelregel_query =
            "INSERT INTO " .
            "bestelling_regels ( " .
            "bestelling_id, " .
            "product_id, " .
            "cadeaubon_id, " .
            "aantal, " .
            "stukprijs, " .
            "totaal ) " .
            "VALUES ( " .
            $bestelling_id . ", " .
            $product['id'] . ", " .
            $cadeaubon_id . ", " .
            $product['hoeveelheid_in_winkelwagen'] . ", " .
            $product['prijs'] . ", " .
            $product['hoeveelheid_in_winkelwagen'] * $product['prijs'] . ") ";

        $dbm->exec($bestelregel_query);

    }

    $dbm->commit();
} catch (Exception $ex) {
    $dbm->rollBack();
    return false;
}
    $_SESSION['winkelwagen']['producten'] = [];

        //redirect login page
        header("Location: /account/orders/$bestelling_id");


        return true;
}

function getVerzendmethodes(\application\DatabaseManager $dbm) {
    return $dbm->query("SELECT * FROM verzendmethoden")->get();
}

