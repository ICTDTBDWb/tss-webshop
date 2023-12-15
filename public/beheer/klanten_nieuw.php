<!-- PHP logica -->
<?php include __DIR__ . '/../../Application/Http//beheer/klanten.php'; ?>
<?php $session = \application\SessionManager::getInstance()?>

<!DOCTYPE html>

<html lang="en">

<!--Head-->
<?php include __DIR__ . "/../../Resources/components/layout/head.php"; ?>

    <body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
<!--Header-->
<?php include __DIR__ . "/../../Resources/components/layout/header.php"; ?>

<style>
    input {
        width: 100%;
    }
</style>

    <!--Invul velden om klant toe te voegen-->
    <div class="container-lg flex-grow-1 gx-0 py-4">
        <h3>Klant toevoegen</h3>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <div class="mb-3">
            Email: <input type="email" name="email" placeholder="email">
            </div>
            <div class="mb-3">
            Wachtwoord: <input type="password" name="password" placeholder="password">
            </div>
            <div class="mb-3">
            Voornaam: <input type="text" name="voornaam" placeholder="voornaam">
            </div>
            <div class="mb-3">
            Tussenvoegsel: <input type="text" name="tussenvoegsel" placeholder="tussenvoegsel">
            </div>
            <div class="mb-3">
            Achternaam: <input type="text" name="achternaam" placeholder="achternaam">
            </div>
            <div class="mb-3">
            Straat: <input type="text" name="straat" placeholder="straat">
            </div>
            <div class="mb-3">
            Huisnummer: <input type="number" name="huisnummer" placeholder="huisnummer">
            </div>
            <div class="mb-3">
            Postcode: <input type="text" name="postcode" placeholder="postcode">
            </div>
            <div class="mb-3">
            Woonplaats: <input type="text" name="woonplaats" placeholder="woonplaats">
            </div>
            <div class="mb-3">
            Land: <input type="text" name="land" placeholder="land">
            </div>
            <br>
            <div class="mb-3">
                <!--Voeg klant toe met ingevulde gegevens-->
                <button class="btn btn-secondary" type="submit" name="submit">Toevoegen</button>
            </div>
        </form>
    </div>

    <!--set $_POST condities-->
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $database = new application\DatabaseManager();
        $email = ($_POST['email']);
        $password = ($_POST['password']);
        $voornaam = ($_POST['voornaam']);
        $tussenvoegsel = ($_POST['tussenvoegsel']);
        $achternaam = ($_POST['achternaam']);
        $straat = ($_POST['straat']);
        $huisnummer = ($_POST['huisnummer']);
        $postcode = ($_POST['postcode']);
        $woonplaats = ($_POST['woonplaats']);
        $land = ($_POST['land']);

    // Voeg gegevens toe aan de database
        $result = $database->query(
            "INSERT INTO klanten (email, password, voornaam, tussenvoegsel, achternaam, straat, huisnummer, postcode, woonplaats, land) 
                        values ('".$email."','".$password."','".$voornaam."','".$tussenvoegsel."','".$achternaam."','".$straat."','".$huisnummer."',
                        '".$postcode."','".$woonplaats."','".$land."')");

        $database->close();

        return $result;

    }
    ?>
</div>



</body>
</html>



<!--Footer & Scripts-->
<?php include __DIR__ . "/../../Resources/components/layout/footer.php"; ?>
<?php include __DIR__ . "/../../Resources/components/layout/scripts.php"; ?>
    </body>
</html>
