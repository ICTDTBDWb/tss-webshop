<?php
include basePath("Application/Http/beheer/klanten.php");
$auth->protectAdminPage(Auth::BEHEERDER_ROLES);
// Haal klant ID op
$klantId = isset($_GET['id']) ? $_GET['id'] : null;
$klantDetails = null;
if ($klantId) {
    $klantDetails = queryEnkeleKlant($klantId);
}
?>

<!--set $_POST condities-->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();

    // Query en parameters om klantgegevens aan te passen in de database
    $query = "UPDATE klanten SET email=?, voornaam=?, tussenvoegsel=?, achternaam=?, straat=?, huisnummer=?, postcode=?, woonplaats=?, land=? WHERE id=?";
    $params = [
        $_POST['email'],
        $_POST['voornaam'],
        $_POST['tussenvoegsel'],
        $_POST['achternaam'],
        $_POST['straat'],
        $_POST['huisnummer'],
        $_POST['postcode'],
        $_POST['woonplaats'],
        $_POST['land'],
        $_POST['id']
    ];

    $result = $database->query($query, $params);


    $database->close();
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
    <!--Formulier om nieuwe klantgegevens in te vullen-->
    <?php foreach ($klantDetails as $enkeleKlant) {?>
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onSubmit="setTimeout(function(){location.reload(true);},100)" >
        <div class="mb-3">
            Id: <input type="text" name="id" placeholder="id">
        </div>
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
            <button class="btn btn-secondary" type="submit" name="submit">Update klant</button>
        </div>
    </form>
    <?php  } ?>
</div>



