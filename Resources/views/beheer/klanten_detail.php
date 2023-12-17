<!-- PHP logica -->
<?php include basePath("Application/Http/beheer/klanten.php");

$klantId = isset($_GET['id']) ? $_GET['id'] : null;
$klantDetails = null;
if ($klantId) {
    $klantDetails = queryEnkeleKlant($klantId);
}
?>

<!--Print enkele klant aan de hand van ID-->
<div class="container">
    <h1>Klant details</h1>
    <div class="d-flex justify-content-end mt-2">
        <a class="btn btn-secondary" href="/beheer/klanten" role="button" style="align-content: end">Terug naar klantoverzicht</a>
    </div>
    <br>
    <?php foreach ($klantDetails as $enkeleKlant) {?>
    <div class="table-responsive-md">
        <table class="table align-middle">
            <thead class="table-light">
            <tr>
                <th scope="col">id</th>
                <th scope="col">Email</th>
                <th scope="col">Wachtwoord</th>
                <th scope="col">Voornaam</th>
                <th scope="col">Tussenvoegsel</th>
                <th scope="col">Achternaam</th>
                <th scope="col">Straat</th>
                <th scope="col">Huisnummer</th>
                <th scope="col">Postcode</th>
                <th scope="col">Woonplaats</th>
                <th scope="col">Land</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?php print $enkeleKlant['id'];?></td>
                <td><?php print $enkeleKlant['email'];?></td>
                <td><?php print $enkeleKlant['password']; ?></td>
                <td><?php print $enkeleKlant['voornaam']; ?></td>
                <td><?php print $enkeleKlant['tussenvoegsel'];?></td>
                <td><?php print $enkeleKlant['achternaam'];?></td>
                <td><?php print $enkeleKlant['straat'];?></td>
                <td><?php print $enkeleKlant['huisnummer'];?></td>
                <td><?php print $enkeleKlant['postcode'];?></td>
                <td><?php print $enkeleKlant['woonplaats'];?></td>
                <td><?php print $enkeleKlant['land'];?></td>
            </tr>
            </tbody>
        </table>
    <?php  } ?>
    </div>
</div>
<br>
<br>

<div class="container">
    <h2>Wijzig klant gegevens</h2>
    <br>
    <style>
        input {
            width: 100%;
        }
    </style>
    <br>
    <form method="post" action="/beheer/klanten_detail">
        <div class="mb-3">
            Email: <input type="email" name="email" placeholder="<?php print $enkeleKlant['email'];?>">
        </div>
        <div class="mb-3">
            Wachtwoord: <input type="password" name="password" placeholder="<?php print $enkeleKlant['password'];?>">
        </div>
        <div class="mb-3">
            Voornaam: <input type="text" name="voornaam" placeholder="<?php print $enkeleKlant['voornaam'];?>">
        </div>
        <div class="mb-3">
            Tussenvoegsel: <input type="text" name="tussenvoegsel" placeholder="<?php print $enkeleKlant['tussenvoegsel'];?>">
        </div>
        <div class="mb-3">
            Achternaam: <input type="text" name="achternaam" placeholder="<?php print $enkeleKlant['achternaam'];?>">
        </div>
        <div class="mb-3">
            Straat: <input type="text" name="straat" placeholder="<?php print $enkeleKlant['straat'];?>">
        </div>
        <div class="mb-3">
            Huisnummer: <input type="number" name="huisnummer" placeholder="<?php print $enkeleKlant['huisnummer'];?>">
        </div>
        <div class="mb-3">
            Postcode: <input type="text" name="postcode" placeholder="<?php print $enkeleKlant['postcode'];?>">
        </div>
        <div class="mb-3">
            Woonplaats: <input type="text" name="woonplaats" placeholder="<?php print $enkeleKlant['woonplaats'];?>">
        </div>
        <div class="mb-3">
            Land: <input type="text" name="land" placeholder="<?php print $enkeleKlant['land'];?>">
        </div>
        <br>
        <div class="d-flex justify-content-start mt-2">
            <!--Voeg klant toe met ingevulde gegevens-->
            <button class="btn btn-secondary" type="submit" name="submit">Update klant</button>
        </div>
    </form>
</div>

    <!--set $_POST condities-->
    <?php
    if ('REQUEST_METHOD' == 'POST') {
        $database = new Database();
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
            "UPDATE klanten SET (email, password, voornaam, tussenvoegsel, achternaam, straat, huisnummer, postcode, woonplaats, land) 
                        values ('" . $email . "','" . $password . "','" . $voornaam . "','" . $tussenvoegsel . "','" . $achternaam . "','" . $straat . "','" . $huisnummer . "',
                        '" . $postcode . "','" . $woonplaats . "','" . $land . "')");

        $database->close();

        return $result;
    }
    ?>