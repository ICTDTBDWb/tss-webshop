<!-- PHP logica -->
<?php include basePath("Application/Http/beheer/klanten.php");
$auth->protectAdminPage(Auth::BEHEERDER_ROLES);
?>

<h1>Klant toevoegen</h1>
<div class="d-flex justify-content-end mt-2">
    <a class="btn btn-secondary" href="/beheer/klanten" role="button" style="align-content: end">Terug naar klantoverzicht</a>
</div>
<br>
<style>
    input {
        width: 100%;
    }
</style>
<form method="post" action="/beheer/klanten_nieuw">
    <div class="mb-3">
    Email: <input type="email" name="email" placeholder="email">
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
    <div class="d-flex justify-content-start mt-2">
        <!--Voeg klant toe met ingevulde gegevens-->
        <button class="btn btn-secondary" type="submit" name="submit">Toevoegen</button>
    </div>
</form>


<!--set $_POST condities-->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $email = ($_POST['email']);
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
                    values ('" . $email . "','" . "','" . $voornaam . "','". $tussenvoegsel . "','" . $achternaam . "','" . $straat . "','" . $huisnummer . "',
                    '" . $postcode . "','" . $woonplaats . "','" . $land . "')");

    $database->close();

    return $result;


}

?>

