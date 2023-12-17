<?php

require("fpdf/fpdf.php");
function bestellingOpslaan(int $klant_id, int $verzendmethode_id, $totaal, string $betaalmethode, array $producten, $voornaam, $tussenvoegsel, $achternaam, $straat, $huisnummer, $postcode, $woonplaats, $land)
{
    $datum = date('Y-m-d H:i:s');

    $dbm = new PDO("mysql:host=host.docker.internal;port=3308;dbname=tss;charset=utf8mb4", "root", "root");

//    $klant = $dbm->exec("SELECT");
    try{
    // Bestelling toevoegen
        $bestelling_query =
            "INSERT INTO " .
            "bestellingen ( " .
            "klant_id, " .
            "verzendmethode_id, " .
            "besteldatum, " .
            "totaal,  " .
            "voornaam, " .
            "tussenvoegsel, " .
            "achternaam, " .
            "straat, " .
            "huisnummer, " .
            "postcode, " .
            "woonplaats, " .
            "land )" .
            "VALUES ( " .
            $klant_id . ", " .
            $verzendmethode_id . ", " .
            "'" . $datum . "', " .
            "'" . $totaal . "', " .
            "'" . $voornaam . "', " .
            "'" . $tussenvoegsel . "', " .
            "'" . $achternaam . "', " .
            "'" . $straat . "', " .
            "'" . $huisnummer . "', " .
            "'" . $postcode . "', " .
            "'" . $woonplaats . "', " .
            "'" . $land . "' ) ";

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
        echo "<pre>";
        echo "test";
        genereerPdf($bestelling_id);
        throw new ErrorException("TESTING");

        $dbm->commit();
    } catch (Exception $ex) {
        $dbm->rollBack();
        return false;
    }

    $_SESSION['winkelwagen']['producten'] = [];

        //redirect login page
        header("Location: /account/bestelling_detail?id=$bestelling_id");

        return true;
}

function getVerzendmethodes(Database $dbm) {
    return $dbm->query("SELECT * FROM verzendmethoden")->get();
}

function genereerPdf(int $bestelling_id) {

    $datum = "01-01-1001";
    $order_datum = "01-01-1002";
    $dbm = new Database();

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont(' Arial');

    $pdf->Cell(40,10, 'Bestelling: ' . $bestelling_id );

    $pdf->Output("/","TEST");
    $bestelling_query = "SELECT * FROM bestelling WHERE id=:id";

    $bestelling = $dbm->query($bestelling_query, ["id"=>$bestelling_id])->first();

    $bedrijf = [
        "naam" => "The Sixth String",
        "btw_nummer" => "012345689",
        "factuurnmmer" => $bestelling_id,
        "factuurdatum" => $datum,
        "besteldatum" => $order_datum,
    ];
}
