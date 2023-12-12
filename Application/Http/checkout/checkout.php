<?php

session_start();
include(__DIR__."/../../DatabaseManager.php");
include(__DIR__."/../winkelwagen/functies.php");
include(__DIR__."/../checkout/functies.php");


// Redirect to homepage if not logged in.
$homepage_path = "http://localhost/";
if(!$_SESSION['user']['logged_in']??false){
    //redirect login page
    header("Location: $homepage_path");
    exit;
}

$dbm = new \application\DatabaseManager();

$_SESSION['user']['logged_in'] = true;
$_SESSION['user']['id'] = 1;
$klant_id = $_SESSION['user']['id'];
$query = "SELECT id, email, voornaam, tussenvoegsel, achternaam, straat, huisnummer, postcode from klanten where id=:klant_id";
$klant = $dbm->query($query, ["klant_id" => $klant_id])->first();
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

    $voornaam = filter_input(INPUT_POST, 'voornaam', FILTER_SANITIZE_SPECIAL_CHARS);
    if($voornaam  === false) {
        $validation_error_array['voornaam'] = true;
    }

    $tussenvoegsel = filter_input(INPUT_POST, 'tussenvoegsel', FILTER_SANITIZE_SPECIAL_CHARS);
    if($tussenvoegsel === false) {
        $validation_error_array['tussenvoegsel'] = true;
    }

    $achternaam = filter_input(INPUT_POST, 'achternaam', FILTER_SANITIZE_SPECIAL_CHARS);
    if($achternaam === false) {
        $validation_error_array['achternaam'] = true;
    }


    $straat = filter_input(INPUT_POST, 'straat', FILTER_SANITIZE_SPECIAL_CHARS);
    if($straat === false) {
        $validation_error_array['straat'] = true;
    }

    $huisnummer = filter_input(INPUT_POST, 'huisnummer', FILTER_SANITIZE_SPECIAL_CHARS);
    if($huisnummer === false) {
        $validation_error_array['huisnummer'] = true;
    }

    $postcode = filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_SPECIAL_CHARS);
    if($postcode === false) {
        $validation_error_array['postcode'] = true;
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
        if(count($cart_changes['removed_products']) == 0 && count($cart_changes['changed_products']) == 0 && $producten) {
            bestellingOpslaan($klant_id, $verzendmethode_filtered, getTotalFromCurrentCart(), $betaalmethode_filtered, $producten);

        }
    }
}



