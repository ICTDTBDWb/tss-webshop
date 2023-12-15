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

<!--Haal de klant ID op-->
<?php
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
        <a class="btn btn-secondary" href="klanten.php" role="button" style="align-content: end">Terug naar klantoverzicht</a>
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
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="<?php print $enkeleKlant['email'];?>" aria-label="<?php print $enkeleKlant['email'];?>" aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary" type="button" id="button-addon2" value="">Wijzig</button>
        </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="<?php print $enkeleKlant['password'];?>" aria-label="<?php print $enkeleKlant['password'];?>" aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary" type="button" id="button-addon2" value="">Wijzig</button>
        </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="<?php print $enkeleKlant['voornaam'];?>" aria-label="<?php print $enkeleKlant['voornaam'];?>" aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary" type="button" id="button-addon2" value="">Wijzig</button>
        </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="<?php print $enkeleKlant['tussenvoegsel'];?>" aria-label="<?php print $enkeleKlant['tussenvoegsel'];?>" aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary" type="button" id="button-addon2" value="">Wijzig</button>
        </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="<?php print $enkeleKlant['achternaam'];?>" aria-label="<?php print $enkeleKlant['achternaam'];?>" aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary" type="button" id="button-addon2" value="">Wijzig</button>
        </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="<?php print $enkeleKlant['straat'];?>" aria-label="<?php print $enkeleKlant['straat'];?>" aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary" type="button" id="button-addon2" value="">Wijzig</button>
        </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="<?php print $enkeleKlant['huisnummer'];?>" aria-label="<?php print $enkeleKlant['huisnummer'];?>" aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary" type="button" id="button-addon2" value="">Wijzig</button>
        </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="<?php print $enkeleKlant['postcode'];?>" aria-label="<?php print $enkeleKlant['postcode'];?>" aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary" type="button" id="button-addon2" value="">Wijzig</button>
        </div>
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="<?php print $enkeleKlant['woonplaats'];?>" aria-label="<?php print $enkeleKlant['woonplaats'];?>" aria-describedby="button-addon2">
        <button class="btn btn-outline-secondary" type="button" id="button-addon2" value="">Wijzig</button>
    </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="<?php print $enkeleKlant['land'];?>" aria-label="<?php print $enkeleKlant['land'];?>" aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary" type="button" id="button-addon2" value="">Wijzig</button>
        </div>
</div>
<!--Footer & Scripts-->
<?php include __DIR__ . "/../../Resources/components/layout/footer.php"; ?>
<?php include __DIR__ . "/../../Resources/components/layout/scripts.php"; ?>
</body>
</html>