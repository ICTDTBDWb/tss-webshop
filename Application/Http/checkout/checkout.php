<?php

$dbm = new Database();

include(__DIR__."/../winkelwagen/functies.php");
include(__DIR__."/../checkout/functies.php");

// Redirect to homepage if not logged in.
$homepage_path = "http://localhost/";
if(!$auth->isLoggedIn()){
    //redirect login page
    header("Location: $homepage_path");
    exit;
}


$query = "SELECT id, email, voornaam, tussenvoegsel, achternaam, straat, huisnummer, postcode from klanten where id=:klant_id";
$klant = $dbm->query($query, ["klant_id" => $auth->user()['id']])->first();


$verzendmethodes_array = getVerzendmethodes($dbm);

$cart_changes = updateSessionCartProducts($dbm);

if(
    ($_SESSION["winkelwagen"]['producten']??false)
    && count($_SESSION["winkelwagen"]['producten'])
){
    $producten = $_SESSION["winkelwagen"]['producten'];

} else{
    $producten = false;
        //redirect login page
        header("Location: $homepage_path");
        exit;
}



$validation_error_array = [];
if($_POST??false){
    //Validate
    // Ongevalideerde ChatGPT regular expression voor wachtwoord
    $password_regex = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^\w\s]).{8,}$/";

    $voornaam_filtered = filter_input(INPUT_POST, 'voornaam', FILTER_SANITIZE_SPECIAL_CHARS);
    if($voornaam_filtered  === false) {
        $validation_error_array['voornaam'] = true;
    }

    $tussenvoegsel_filtered = filter_input(INPUT_POST, 'tussenvoegsel', FILTER_SANITIZE_SPECIAL_CHARS);
    if($tussenvoegsel_filtered === false) {
        $validation_error_array['tussenvoegsel'] = true;
    }

    $achternaam_filtered = filter_input(INPUT_POST, 'achternaam', FILTER_SANITIZE_SPECIAL_CHARS);
    if($achternaam_filtered === false) {
        $validation_error_array['achternaam'] = true;
    }


    $straat_filtered = filter_input(INPUT_POST, 'straat', FILTER_SANITIZE_SPECIAL_CHARS);
    if($straat_filtered === false) {
        $validation_error_array['straat'] = true;
    }

    $huisnummer_filtered = filter_input(INPUT_POST, 'huisnummer', FILTER_SANITIZE_SPECIAL_CHARS);
    if($huisnummer_filtered === false) {
        $validation_error_array['huisnummer'] = true;
    }

    $postcode_filtered = filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_SPECIAL_CHARS);
    if($postcode_filtered === false) {
        $validation_error_array['postcode'] = true;
    }

    $woonplaats_filtered = filter_input(INPUT_POST, 'straat', FILTER_SANITIZE_SPECIAL_CHARS);
    if($woonplaats_filtered === false) {
        $validation_error_array['woonplaats'] = true;
    }

    $land_filtered = filter_input(INPUT_POST, 'straat', FILTER_SANITIZE_SPECIAL_CHARS);
    if($land_filtered === false) {
        $validation_error_array['land'] = true;
    }

    $betaalmethode_filtered = filter_input(INPUT_POST, 'betaalmethode', FILTER_SANITIZE_SPECIAL_CHARS);
    if($betaalmethode_filtered == false) {
        $validation_error_array['betaalmethode'] = true;
    }

    $verzendmethode_filtered = filter_input(INPUT_POST, 'verzendmethode', FILTER_SANITIZE_SPECIAL_CHARS);

    // Valideer dat de verzendmethode bestaat.
    $query = "SELECT id from verzendmethoden where id=:verzendmethode_id";
    $verzendmethode_row = $dbm->query($query, ["verzendmethode_id" => $verzendmethode_filtered])->first();

//    var_dump($verzendmethode, $verzendmethode_row);exit;
    if($verzendmethode_filtered == false || $verzendmethode_row == false || count($verzendmethode_row) == 0) {
        $validation_error_array['verzendmethode'] = true;
    }

    if(count($validation_error_array) == 0) {

        if(
            count($cart_changes['removed_products']) == 0 &&
            count($cart_changes['changed_products']) == 0 &&
            $producten &&
            validateCartCadeaubonnen($dbm)
        ) {

            bestellingOpslaan(
                $auth->user()['id'],
                $verzendmethode_filtered,
                getTotalFromCurrentCart() - getCouponBedrag(),
                $betaalmethode_filtered,
                $producten,
                $voornaam_filtered,
                $tussenvoegsel_filtered,
                $achternaam_filtered,
                $straat_filtered,
                $huisnummer_filtered,
                $postcode_filtered,
                $woonplaats_filtered,
                $land_filtered
            );

        }
    }
}


