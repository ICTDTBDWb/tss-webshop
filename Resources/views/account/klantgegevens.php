<?php
$auth->protectPage();

$connection = new Database();


//TODO: PHP en HTML scheiden
//TODO: Automatisch aanvullen addressgegevens op woonplaats en postcode


// Redirect to homepage if not logged in.
if(!$_SESSION['auth']['logged_in']??false){
    //redirect login page
    header("Location: /");
    exit;
}

$db = new Database();
$klant_id = $_SESSION['auth']['user_id'];

//Assume form is valid until a validation fails
$invalid_form = false;

// Set validation error array empty
$validation_error_array = [];

// Form has been submitted
if(isset($_POST) && count($_POST)){

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


    $wachtwoord_filtered = filter_input(INPUT_POST, 'wachtwoord', FILTER_SANITIZE_SPECIAL_CHARS);
    // Wachtwoord 2 stage. Eerst checken of special chars er in zitten, daarna reg-ex
    if($wachtwoord_filtered !== false) {
        $wachtwoord_regex = filter_var($wachtwoord_filtered, FILTER_VALIDATE_REGEXP, [
            "options" =>
                [
                    "regexp" => $password_regex
                ]
        ] );

    } else {
        // Wachtwoord bevat special characters
        $wachtwoord_filtered = false;
    }

    // Als wachtwoord niet leeg is maar regex failed, zet error
    if($wachtwoord_filtered !== "" && $wachtwoord_regex === false) {

        $validation_error_array['wachtwoord'] = true;
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

    $woonplaats_filtered = filter_input(INPUT_POST, 'woonplaats', FILTER_SANITIZE_SPECIAL_CHARS);
    if($woonplaats_filtered === false) {
        $validation_error_array['woonplaats'] = true;
    }

    $land_filtered = filter_input(INPUT_POST, 'land', FILTER_SANITIZE_SPECIAL_CHARS);
    if($land_filtered === false) {
        $validation_error_array['land'] = true;
    }

    $email_filtered = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if($email_filtered === false) {
        $validation_error_array['email'] = true;
    }
//    $validation_error_array['email'] = true;
    if(count($validation_error_array) == 0){

        $_partial_query_wachtwoord = "";

        // Als wachtwoord gezet is voeg deze ook toe aan de query
        if($wachtwoord_filtered !== '' ) {
            $_partial_query_wachtwoord = " password = :wachtwoord , ";
        }

        $query =
            "UPDATE klanten SET " .
            "voornaam=:voornaam ," .

            "tussenvoegsel=:tussenvoegsel, " .
            "achternaam=:achternaam, " .
            "straat=:straat, " .
            "huisnummer=:huisnummer, " .

            "woonplaats=:woonplaats, " .
            "postcode=:postcode, " .
            "land=:land, " .
            $_partial_query_wachtwoord .
            "email=:email " .
            "WHERE id=:klant_id";

        $query_variables = [
                "voornaam" => $voornaam_filtered,
                "tussenvoegsel" => $tussenvoegsel_filtered,
                "achternaam" => $achternaam_filtered,
                "straat" => $straat_filtered,
                "huisnummer" => $huisnummer_filtered,
                "postcode" => $postcode_filtered,
                "email" => $email_filtered,
                "klant_id" => $klant_id,
                "woonplaats" => $woonplaats_filtered,
                "land" => $land_filtered,
            ];

        // Als wachtwoord gezet is voeg deze ook toe de prepared variabelen
        if($wachtwoord_filtered !== ''){
            $query_variables["wachtwoord"] = $wachtwoord_filtered;
        }
        $result = $db->query($query, $query_variables);


        if(!$result) {
            //Something went wrong
        }
    }
}


$query = "SELECT id, email, voornaam, tussenvoegsel, achternaam, straat, huisnummer, postcode, woonplaats, land from klanten where id=:klant_id";

$klant = $db->query($query,["klant_id" => $klant_id])->first();

?>

<!-- Menu van de accountpagina -->
<?php include basePath("Application/Http/account/menu.php"); ?>

<div class="d-flex flex-grow-1 ">
    <div class="flex-grow-1"></div>
    <form class="form flex-grow-1 d-flex flex-column justify-content-around" action="" method="POST">
        <div class="form-group">
            <label for="voornaam">Voornaam</label>
            <input type="text" class="form-control <?php if(isset($validation_error_array["voornaam"]))echo "is_invalid";?>" id="voornaam" name="voornaam" placeholder="Voornaam" value="<?php echo $klant['voornaam']; ?>"/>
        </div>

        <div class="form-group">
            <label for="tussenvoegsel">Tussenvoegsel</label>
            <input type="text" class="form-control <?php if(isset($validation_error_array["tussenvoegsel"]))echo "is_invalid";?>" id="tussenvoegsel" name="tussenvoegsel" placeholder="Tussenvoegsel" value="<?php echo $klant['tussenvoegsel']; ?>"/>
        </div>
        <div class="form-group">
            <label for="achternaam">Achternaam</label>
            <input type="text" class="form-control <?php if(isset($validation_error_array["achternaam"]))echo "is_invalid";?>" id="achternaam" name="achternaam" placeholder="Achternaam" value="<?php echo $klant['achternaam']; ?>"/>
        </div>
        <div class="form-group">
            <label for="wachtwoord">Wachtwoord</label>
            <input
                    type="text"
                    class="form-control <?php if(isset($validation_error_array["wachtwoord"]))echo"is-invalid";?>"
                    id="wachtwoord"
                    name="wachtwoord"
                    placeholder="*********"
                    aria-describedby="wachtwoordFeedback"
            />
            <div id="wachtwoordFeedback" class="invalid-feedback">
                <ul>
                    <li>Het wachtwoord moet minimaal 8 tekens lang zijn.</li>
                    <li>Het wachtwoord moet minstens één hoofdletter, één kleine letter, één cijfer en één speciaal teken bevatten.</li>
                    <ul>
            </div>
        </div>

        <div class="form-group">
            <label for="straat">Straat</label>
            <input type="text" class="form-control <?php if(isset($validation_error_array["straat"]))echo "is_invalid";?>" id="straat" name="straat" placeholder="Straatnaam" value="<?php echo $klant['straat']; ?>"/>
        </div>
        <div class="form-group">
            <label for="huisnummer">Huisnummer</label>
            <input type="text" class="form-control <?php if(isset($validation_error_array["huisnummer"]))echo "is_invalid";?>" id="huisnummer" name="huisnummer" placeholder="Huisnummer" value="<?php echo $klant['huisnummer']; ?>"/>
        </div>
        <div class="form-group">
            <label for="postcode">Postcode</label>
            <input type="text" class="form-control <?php if(isset($validation_error_array["postcode"]))echo "is_invalid";?>" id="postcode" name="postcode" placeholder="4 cijfers en 2 letters" value="<?php echo $klant['postcode']; ?>"/>
        </div>
        <div class="form-group">
            <label for="woonplaats">Woonplaats</label>
            <input type="text" class="form-control <?php if(isset($validation_error_array["woonplaats"]))echo "is_invalid";?>" id="woonplaats" name="woonplaats" placeholder="Woonplaats" value="<?php echo $klant['woonplaats']; ?>"/>
        </div>
        <div class="form-group">
            <label for="land">Land</label>
            <input type="text" class="form-control <?php if(isset($validation_error_array["land"]))echo "is_invalid";?>" id="land" name="land" placeholder="Land" value="<?php echo $klant['land']; ?>"/>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input
                    type="text"
                    class="form-control <?php if(isset($validation_error_array["email"]))echo"is-invalid";?> "
                    id="email"
                    name="email"
                    placeholder="<email@domein.nl>"
                    value="<?php echo $klant['email']; ?>"
                    aria-describedby="emailFeedback"/>
            <div id="emailFeedback" class="invalid-feedback">
                Vul alstublief een geldig e-mail in.
            </div>
        </div>
        <input type="submit" value="Opslaan" class="btn btn-primary"></input>
    </form>
    <div class="flex-grow-1"></div>
</div>