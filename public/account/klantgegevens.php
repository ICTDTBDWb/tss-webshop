<?php
include_once __DIR__ . '/../../application/DatabaseManager.php';
session_start();

$_SESSION['user']['logged_in'] = true;
$_SESSION['user']['id'] = 1;

// Redirect to homepage if not logged in.
$homepage_path = "http://localhost/tss/public";
if(!$_SESSION['user']['logged_in']??false){
    //redirect login page
    header("Location: $homepage_path");
    exit;
}

$hostname = "localhost:3308";
$username = "root";
$password = "root";
$database = "tss";

$connection = mysqli_connect($hostname, $username, $password, $database);

if(!$connection){
    echo "Database connection failed";
    exit;
}

$klant_id = $_SESSION['user']['id'];

$invalid_form = false;
$validation_error_array = [

];

if($_POST??false){
    //Validate
    // Ongevalideerde ChatGPT regular expression voor wachtwoord
    $password_regex = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^\w\s]).{8,}$/";
//    $password_regex = "";

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

    $wachtwoord = filter_input(INPUT_POST, 'wachtwoord', FILTER_VALIDATE_REGEXP, [
        "options" =>
            [
                "regexp" => $password_regex
            ]
    ]);
    if($wachtwoord === false) {
        $validation_error_array['wachtwoord'] = true;
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

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if($email === false) {
        $validation_error_array['email'] = true;
    }
//    $validation_error_array['email'] = true;
    if(count($validation_error_array) == 0){
        $query =
            "UPDATE klanten SET " .
            "voornaam='" . $voornaam . "', " .
            "tussenvoegsel='" . $tussenvoegsel . "', " .
            "achternaam='" . $achternaam . "', " .
            "straat='" . $straat . "', " .
            "huisnummer='" . $huisnummer . "', " .
            "postcode='" . $postcode . "', " .
            "email='" . $email . "' " .
            "WHERE id='". $klant_id. "'";
//        var_dump($query);exit;
        $result = mysqli_execute_query($connection, $query);
        if(!$result) {
            //Something went wrong
        }
    }
}

$query = "SELECT id, email, voornaam, tussenvoegsel, achternaam, straat, huisnummer, postcode from klanten where id='$klant_id'";
$result = mysqli_execute_query($connection, $query);
$klant = mysqli_fetch_assoc($result);

//var_dump($klant);exit;
mysqli_close($connection);
?>

<!DOCTYPE html>

<html lang="en">
<!--Head-->
<?php include __DIR__ . "/../../application/components/layout/head.php"; ?>

<body class="min-vw-100 vh-100 d-flex flex-column bg-white">
<!--Header-->
<?php include __DIR__ . "/../../application/components/layout/header.php"; ?>


<div class="d-flex flex-row justify-content-start navigation py-3">
    <a class="btn btn-outline-primary mx-3" href="/accountoverzicht" role="button">Accountoverzicht</a>
    <a class="btn btn-outline-primary mx-3" href="/bestellingen" role="button">Bestellingen</a>
    <a class="btn btn-outline-primary mx-3" href="/cadeaubonnenengiftboxes" role="button">Cadeaubonnen en giftboxes</a>
    <a class="btn btn-outline-primary mx-3" href="/klantgegevensaanpassen" role="button">Klantgegevens aanpassen</a>
    <a class="btn btn-outline-primary mx-3" href="/uitloggen" role="button">Uitloggen</a>
</div>

<div class="d-flex flex-grow-1 ">
    <div class="flex-grow-1"></div>
    <form class="form flex-grow-1 d-flex flex-column justify-content-around" action="" method="POST">
        <div class="form-group">
            <label for="voornaam">Voornaam</label>
            <input type="text" class="form-control <?php echo $validation_error_array["voornaam"]??"is_invalid";?> id="voornaam" name="voornaam" placeholder="Voornaam" value="<?php echo $klant['voornaam']; ?>"/>
        </div>

        <div class="form-group">
            <label for="tussenvoegsel">Tussenvoegsel</label>
            <input type="text" class="form-control" id="tussenvoegsel" name="tussenvoegsel" placeholder="Tussenvoegsel" value="<?php echo $klant['tussenvoegsel']; ?>"/>
        </div>
        <div class="form-group">
            <label for="achternaam">Achternaam</label>
            <input type="text" class="form-control" id="achternaam" name="achternaam" placeholder="Achternaam" value="<?php echo $klant['achternaam']; ?>"/>
        </div>
        <div class="form-group">
            <label for="wachtwoord">Wachtwoord</label>
            <input
                type="text"
                class="form-control <?php if(isset($validation_error_array["wachtwoord"]))echo"is-invalid";?>"
                id="wachtwoord"
                name="wachtwoord"
                placeholder="*********"
                aria-describedby="wachtwoordFeedback"/>
            <div id="wachtwoordFeedback" class="invalid-feedback">
                <ul>
                    <li>Het wachtwoord moet minimaal 8 tekens lang zijn.</li>
                    <li>Het wachtwoord moet minstens één hoofdletter, één kleine letter, één cijfer en één speciaal teken bevatten.</li>
                    <ul>
            </div>
        </div>

        <div class="form-group">
            <label for="straat">Straat</label>
            <input type="text" class="form-control" id="straat" name="straat" placeholder="Straatnaam" value="<?php echo $klant['straat']; ?>"/>
        </div>
        <div class="form-group">
            <label for="huisnummer">Huisnummer</label>
            <input type="text" class="form-control" id="huisnummer" name="huisnummer" placeholder="Huisnummer" value="<?php echo $klant['huisnummer']; ?>"/>
        </div>
        <div class="form-group">
            <label for="postcode">Postcode</label>
            <input type="text" class="form-control" id="postcode" name="postcode" placeholder="4 cijfers en 2 letters" value="<?php echo $klant['postcode']; ?>"/>
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

<!--Footer & Scripts-->
<?php include __DIR__ . "/../../application/components/layout/footer.php"; ?>
<?php include __DIR__ . "/../../application/components/layout/scripts.php"; ?>
</body>
</html>