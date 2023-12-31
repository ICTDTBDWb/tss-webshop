<?php

require("fpdf/fpdf.php");
function bestellingOpslaan(int $klant_id, int $verzendmethode_id, $totaal, string $betaalmethode, array $producten, $voornaam, $tussenvoegsel, $achternaam, $straat, $huisnummer, $postcode, $woonplaats, $land)
{
    $datum = date('Y-m-d H:i:s');

    $dbm = new PDO(Database::CONFIG['dns'], Database::CONFIG['username'], Database::CONFIG['password'] );

    // Valideer voor opslaan
    $cadeaubonnen = $_SESSION['winkelwagen']['cadeaubonnen']??false;

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

    // Betaling toevoegen
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
            $bestelregel_query =
                "INSERT INTO " .
                "bestelling_regels ( " .
                "bestelling_id, " .
                "product_id, " .
                "aantal, " .
                "stukprijs, " .
                "product_naam, " .
                "totaal ) " .
                "VALUES ( " .
                $bestelling_id . ", " .
                $product['id'] . ", " .
                $product['hoeveelheid_in_winkelwagen'] . ", " .
                $product['prijs'] . ", " .
                "'".filter_var($product['product_naam'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) . "', " .
                $product['hoeveelheid_in_winkelwagen'] * $product['prijs'] . ") ";

            $dbm->exec($bestelregel_query);

        }
        if($cadeaubonnen) {
            foreach($cadeaubonnen as $cadeaubon) {
                $bon_id_huidige_bedrag = $dbm->query("SELECT id, bedrag FROM cadeaubonnen WHERE code='". $cadeaubon['code'] . "';")
                    ->fetchAll(PDO::FETCH_ASSOC)[0];

                // Voeg cadeaubon toe aan bestelling
                $cadeaubon_query =
                    "INSERT INTO " .
                        "bestelling_regels ( " .
                        "bestelling_id, " .
                        "cadeaubon_id, " .
                        "aantal, " .
                        "stukprijs, " .
                        "product_naam, " .
                        "totaal ) " .
                    "VALUES ( " .
                        $bestelling_id . ", " .
                    $bon_id_huidige_bedrag['id'] . ", " .
                        '1' . ", " .
                        $cadeaubon['bedrag'] . ", " .
                        "'".$cadeaubon['code'] . "', " .
                        $cadeaubon['bedrag'] . ") ";
                $dbm->exec($cadeaubon_query);

                // Update het overgebleven bedrag van de cadeaubon

                $nieuwe_bedrag = $bon_id_huidige_bedrag['bedrag'] - $cadeaubon['bedrag'];

                $cadeaubon_update_query = "UPDATE cadeaubonnen " .
                    "SET bedrag=" . $nieuwe_bedrag . " " .
                    "WHERE code='" . $cadeaubon['code'] . "';";

                $dbm->exec($cadeaubon_update_query);
            }
        }

        $dbm->commit();
    } catch (Exception $ex) {
//        echo"<pre>";
//        var_dump($ex);
//        echo "</pre>";
//        exit;
        $dbm->rollBack();
        return false;
    }

    $bestandsnaam = genereerPdf($bestelling_id);
    $klant = $dbm->query("SELECT voornaam, email FROM klanten WHERE id=$klant_id")->fetchAll(PDO::FETCH_ASSOC)[0];

    // TODO: Test en zet in functie
    $mail_email = $klant['email'];
    $mail_subject = "Bestelling: ". $bestelling_id;
    $mail_message =
        'Beste '. $klant['voornaam'] . "," . '%0D%0A' .
        "Bedankt voor uw bestelling bij The Sixth String.".
        "Uw bestelling is als bijlage toegevoegd";

    $mail_headers = 'From: noreply@thesixthstring.nl' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    //File
    $pathInfo       = pathinfo($bestandsnaam);
    $attchmentName  = "attachment_".date("YmdHms").(
        (isset($pathInfo['extension']))? ".".$pathInfo['extension'] : ""
        );
    $attachment    = chunk_split(base64_encode(file_get_contents($bestandsnaam)));

    $mail_message .= "\nContent-Type: application/octet-stream; name=\"".$attchmentName."\"";
    $mail_message .= "\nContent-Transfer-Encoding: base64\n";
    $mail_message .= "\nContent-Disposition: attachment\n";
    $mail_message .= $attachment;

    mail(
        $mail_email,
        $mail_subject,
        $mail_message,
        $mail_headers
    );

    // Delete file after mailing
    // Is disabled om pdf te kunnen zien voor testen.
//    unlink($bestandsnaam);

    $_SESSION['winkelwagen']['producten'] = [];
    $_SESSION['winkelwagen']['cadeaubonnen'] = [];

        //redirect login page
        header("Location: /account/bestelling_detail?id=$bestelling_id");

        return true;
}

function getVerzendmethodes(Database $dbm) {
    return $dbm->query("SELECT * FROM verzendmethoden")->get();
}

// TODO: Zet optie om handmatig te downloaden er in.
function genereerPdf(int $bestelling_id) {

    $datum = "01-01-1001";
    $bestandsnaam = "Factuur_".$bestelling_id.".pdf";
    $dbm = new Database();

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont("Arial", "B", 24);

    $pdf->Cell(40,10, 'Factuur' );



    $bestelling_query =
        "SELECT b.*, vm.naam as verzendmethode_naam, betalingen.betalingsprovider ".
        "FROM bestellingen as b " .
        "LEFT JOIN betalingen " .
        "ON b.id=betalingen.bestelling_id " .
        "JOIN verzendmethoden as vm " .
        "ON b.verzendmethode_id=vm.id " .
        "WHERE b.id=:id";

    $bestelling = $dbm->query($bestelling_query, ["id"=>$bestelling_id])->first();

    $bestelregels_query = "SELECT br.bestelling_id, br.product_id, br.cadeaubon_id, br.aantal, br.stukprijs, br.totaal, br.product_naam FROM bestelling_regels as br LEFT JOIN producten as p on br.product_id=p.id WHERE bestelling_id=:id";
    $bestelregels = $dbm->query($bestelregels_query, ["id"=>$bestelling_id])->get();

    $klant_query = "SELECT voornaam, tussenvoegsel, achternaam, straat, huisnummer, postcode, woonplaats FROM klanten WHERE id=:id";

    $klant = $dbm->query($klant_query, ["id"=>$bestelling["klant_id"]])->first();

    $bedrijf = [
        "naam" => "The Sixth String",
        "adres" => "Adres",
        "huisnummer" => "21",
        "postcode" => "1234 AB",
        "woonplaats" => "Breda",
        "btw_nummer" => "012345689",
        "factuurnmmer" => "Factuur_".$bestelling_id,
        "factuurdatum" => $datum,
        "besteldatum" => $bestelling['besteldatum'],
    ];

    $pdf->SetFont("Arial", "", 24);
    $pdf->Cell(150,10, "The Sixth String ",0,0, "R" );
    $pdf->Ln();

    $pdf->SetFont("Arial", "", 12);

    $pdf->Cell(130,8, "" );
    $pdf->Cell(40,8, $bedrijf["naam"] );
    $pdf->Ln();

    $pdf->Cell(130,8, "" );
    $pdf->Cell(40,8, $bedrijf["adres"] . " " . $bedrijf["huisnummer"] );
    $pdf->Ln();

    $pdf->Cell(130,8, "" );
    $pdf->Cell(40,8, $bedrijf["postcode"] . " " . $bedrijf["woonplaats"] );
    $pdf->Ln();

    $pdf->Cell(130,8, "" );
    $pdf->Cell(40,8, $bedrijf["btw_nummer"] );
    $pdf->Ln();

    $pdf->SetFont("Arial", "", 14);

    $pdf->Cell(40,8, "Factuurnummer: ". $bedrijf['factuurnmmer'] );
    $pdf->Ln();

    $pdf->Cell(40,8, "Besteldatum: ". $bedrijf['besteldatum'] );
    $pdf->Ln();

    $pdf->Cell(40,8, "Factuurdatum: ". $bedrijf['factuurdatum'] );
    $pdf->Ln();
    // Factuur adres
    $adres_margin_left = 30;
    $adres_space_between = 30;
    $adres_cel_width = 40;
    $adres_line_height = 5;

    //Adress en factuur adress regels
    $pdf->SetFont("Arial", "", 14);
    $pdf->Cell($adres_margin_left,10, "" );
    $pdf->Cell(40,8, "Factuuradres" );

    $pdf->Cell($adres_space_between,10, "" );
    $pdf->Cell(40,10, "Bezorgadres" );

    $pdf->Ln();



    $pdf->SetFont("Arial", "", 12);

    $pdf->Cell($adres_margin_left,$adres_line_height, "" );
    $pdf->Cell(40,$adres_line_height,
        ($bestelling["voornaam"] ? $bestelling["voornaam"] : $klant["voornaam"]) . " " .
        ($bestelling["tussenvoegsel"] ? $bestelling["tussenvoegsel"] : $klant["tussenvoegsel"]) . " " .
        ($bestelling["achternaam"] ? $bestelling["achternaam"] : $klant["achternaam"])

    );
    $pdf->Cell($adres_space_between,$adres_line_height, "" );

    $pdf->Cell(40,$adres_line_height,
        ($bestelling["voornaam"] ? $bestelling["voornaam"] : $klant["voornaam"]) . " " .
        ($bestelling["tussenvoegsel"] ? $bestelling["tussenvoegsel"] : $klant["tussenvoegsel"]) . " " .
        ($bestelling["achternaam"] ? $bestelling["achternaam"] : $klant["achternaam"])

    );

    $pdf->Ln();
    $pdf->Cell($adres_margin_left,$adres_line_height, "" );
    $pdf->Cell(40,$adres_line_height,
        ($bestelling["straat"] ? $bestelling["straat"] : $klant["straat"]) . " " .
        ($bestelling["huisnummer"] ? $bestelling["huisnummer"] : $klant["huisnummer"])
    );

    $pdf->Cell($adres_space_between,$adres_line_height, "" );
    $pdf->Cell(40,$adres_line_height,
        ($bestelling["straat"] ? $bestelling["straat"] : $klant["straat"]) . " " .
        ($bestelling["huisnummer"] ? $bestelling["huisnummer"] : $klant["huisnummer"])
    );

    $pdf->Ln();
    $pdf->Cell($adres_margin_left,$adres_line_height, "" );
    $pdf->Cell(40,$adres_line_height,
        ($bestelling["postcode"] ? $bestelling["postcode"] : $klant["postcode"]) . " " .
        ($bestelling["woonplaats"] ? $bestelling["woonplaats"] : $klant["woonplaats"])
    );

    $pdf->Cell($adres_space_between,$adres_line_height, "" );
    $pdf->Cell(40,$adres_line_height,
        ($bestelling["postcode"] ? $bestelling["postcode"] : $klant["postcode"]) . " " .
        ($bestelling["woonplaats"] ? $bestelling["woonplaats"] : $klant["woonplaats"])
    );


    $pdf->Ln();
    $pdf->Ln();
    $product_margin_left = 10;
    $product_space_between = 20;
    $product_line_height = 10;
    $product_cell_width = 10;

    // Producten
    // Naam - Hoeveelheid - Prijs - Stuks - Totaal
    $pdf->SetFont("Arial", "", 14);
    $pdf->Cell($product_margin_left ,$product_line_height, "" );

    $pdf->Cell(60,$product_line_height, "Naam");
    $pdf->Cell($product_space_between ,$product_line_height, "" );

    $pdf->Cell($product_cell_width,$product_line_height, "Prijs");
    $pdf->Cell($product_space_between ,$product_line_height, "" );

    $pdf->Cell($product_cell_width,$product_line_height, "Aantal");
    $pdf->Cell($product_space_between ,$product_line_height, "" );

    $pdf->Cell($product_cell_width,$product_line_height, "Totaal");
    $pdf->Cell($product_space_between ,$product_line_height, "" );

    $pdf->Ln();
    //    $bestelregels

    $pdf->SetFont("Arial", "", 12);
    foreach($bestelregels as $bestelregel) {

        $pdf->Cell($product_margin_left ,$product_line_height, "" );

        $pdf->Cell(60,$product_line_height, $bestelregel['product_naam']);
        $pdf->Cell($product_space_between ,$product_line_height, "" );

        // Zet een - voor de prijs als het een cadeaubon is
        if($bestelregel['cadeaubon_id'] != false) {
            $negative_prefix = "-";
        } else {
            $negative_prefix = "";
        }

        $pdf->Cell($product_cell_width,$product_line_height, $negative_prefix.$bestelregel['stukprijs']);
        $pdf->Cell($product_space_between ,$product_line_height, "" );


        $pdf->Cell($product_cell_width,$product_line_height, $bestelregel['aantal']);
        $pdf->Cell($product_space_between ,$product_line_height, "" );

        $pdf->Cell($product_cell_width,$product_line_height, $negative_prefix.$bestelregel['totaal']);
        $pdf->Cell($product_space_between ,$product_line_height, "" );
        $pdf->Ln();
    }

    $pdf->Cell(10+60+10+40,$product_line_height,"");
    $pdf->Cell(10,$product_line_height,"Totaal: ");
    $pdf->Cell($product_space_between,$product_line_height,"");
    $pdf->Cell(10,$product_line_height,$bestelling['totaal']);
    $pdf->Ln();

    //Betaalmethode
    $pdf->Cell($product_margin_left,$product_line_height,"");
    $pdf->Cell(20,$product_line_height,"Betaalmethode: ");
    $pdf->Cell($product_space_between,$product_line_height,"");
    $pdf->Cell(20,$product_line_height,$bestelling['betalingsprovider']);
    $pdf->Ln();

    //Verzendmethode
    $pdf->Cell($product_margin_left,$product_line_height,"");
    $pdf->Cell(20,$product_line_height,"Verzendmethode: ");
    $pdf->Cell($product_space_between,$product_line_height,"");
    $pdf->Cell(20,$product_line_height,$bestelling['verzendmethode_naam']);
    $pdf->Ln();


    $pdf->Output("F",$bestandsnaam);

    $dbm->close();
    return $bestandsnaam;
}
function validateCartCadeaubonnen($dbm)
{
    // Als er geen cadeaubonnen in de winkelwagen zitten, zijn ze automatisch valide
    if(
        !isset($_SESSION['winkelwagen']['cadeaubonnen']) || count($_SESSION['winkelwagen']['cadeaubonnen']) == 0
    ){
        return true;
    }

    $filter_cart_cadeaubonnen = [];
    foreach ($_SESSION['winkelwagen']['cadeaubonnen'] as $cadeaubon) {
        $filtered_cadeaubon = [
            "code" => filter_var($cadeaubon['code'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            "pin" => filter_var($cadeaubon['pin'], FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            "bedrag" => filter_var($cadeaubon['bedrag'], FILTER_VALIDATE_FLOAT),
        ];

        if($filtered_cadeaubon['code'] === false || $filtered_cadeaubon['pin'] === false || $filtered_cadeaubon['bedrag'] === false) {
            return false;
        }

        $filter_cart_cadeaubonnen[] = $filtered_cadeaubon;
    }



    $prepared = "";
    $count = count($filter_cart_cadeaubonnen);


    for ($i = 0;  $i < $count; $i++) {
        $prepared .= "?, ";
    }

    $prepared = trim($prepared, ", ");

    $query =
        "SELECT code, pin, bedrag " .
        "FROM cadeaubonnen " .
        "WHERE code IN (" . $prepared . ");";

    $codes = array_column($filter_cart_cadeaubonnen, "code");
    $database_cadeaubonnen = $dbm->query($query, $codes)->get();

    // Als de hoeveelheid cadeaubnnen niet hetzelfde is tussendatabase en sessie it er een fout tussen.
    if (count($database_cadeaubonnen) != count($filter_cart_cadeaubonnen)) {
        return false;
    }

    foreach ($database_cadeaubonnen as $database_cadeaubon) {
        foreach ($filter_cart_cadeaubonnen as $filter_cart_cadeaubon) {
            if ($filter_cart_cadeaubon['code'] == $database_cadeaubon['code']) {

                // Als de pin van een code niet matched,  zijn cadeaubonnen invalid.
                if ($filter_cart_cadeaubon['pin'] != $filter_cart_cadeaubon['pin']) {
                    return false;
                }

                // Als het bedrag van de cadeaubon in de winkelwagen hoger is dan die in de database is de cadeaubon invalid
                if ($filter_cart_cadeaubon['bedrag'] > $database_cadeaubon['bedrag']) {
                    return false;
                }
            }

        }
    }

    // Coupons in sessie zijn valid
    return true;
}

function getCouponBedrag(){
    $return = 0;
    if (isset($_SESSION['winkelwagen']['cadeaubonnen']) && count($_SESSION['winkelwagen']['cadeaubonnen']) > 0) {
        foreach ($_SESSION['winkelwagen']['cadeaubonnen'] as $cadeaubonnen) {
            $return += $cadeaubonnen['bedrag'];
        }
    }
    return $return;
}
