<?php
include basePath("Application/Http/beheer/menu.php");

$auth->protectAdminPage(Auth::BEHEERDER_ROLES);

// Zoek klant wanneer submit gedaan wordt
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $zoekKlantNaam = filter_input(INPUT_POST, 'klantenZoeken');
    $klantenLijst = zoekKlanten($zoekKlantNaam);
} else {
    // Indien geen naam is omgegeven laat alle klanten zien
    $klantenLijst = queryKlanten();
}
?>



<div class="d-flex justify-content-end mt-3">
    <form method="post" action="/beheer/klanten">
        <input class="form-control" list="datalistOptions" name="klantenZoeken" id="klantenZoeken" placeholder="Klanten zoeken..." style="max-width: 75%">
        <datalist id="datalistOptions">
            <option value=""></option>
        </datalist>
        <button type="submit" class="btn btn-secondary">Zoeken</button>
    </form>
</div>
<br>
<div class="table-responsive-md">
    <table class="table align-middle">
        <thead class="table-light">
        <tr>
            <th scope="col">id</th>
            <th scope="col">Voornaam</th>
            <th scope="col">Tussenvoegsel</th>
            <th scope="col">Achternaam</th>
            <th scope="col">Klant wijzigen</th>
            <th scope="col">Klant verwijderen</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($klantenLijst as $klanten) { ?>
            <tr>
                <td><?php echo $klanten['id']; ?></td>
                <td><?php echo $klanten['voornaam']; ?></td>
                <td><?php echo $klanten['tussenvoegsel']; ?></td>
                <td><?php echo $klanten['achternaam']; ?></td>
                <td><a class="btn btn-secondary" href="/beheer/klanten_detail?id=<?php echo $klanten['id']; ?>" role="button">Wijzigen</a></td>
                <td>
                    <form method="post" action="/beheer/klanten" onsubmit="setTimeout(function () { window.location.reload(); }, 100)">
                        <input name="klantId" class="d-none" value="<?php echo $klanten['id']; ?>">
                        <button class="btn btn-secondary" role="button" name="klantVerwijderen" value="verwijderen"
                                onclick="return confirm('Weet u zeker dat u deze klant wilt verwijderen?')">Verwijderen</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<!-- POST om klant te verwijderen-->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['klantVerwijderen'])) {
    $database = new Database();

    $klantIdToDelete = $klanten['id'];

    // Verwijder klant uit database
    $result = $database->query("DELETE klanten FROM klanten WHERE id = ?", [$klantIdToDelete]);

    $database->close();
}

?>
<!--Nieuwe klant aanmaken-->

<div class="container-lg flex-grow-1 gx-o py-4">
    <div class="d-flex justify-content-end">
        <a class="btn btn-secondary" href="klanten_nieuw" role="button">Nieuwe klant aanmaken</a>
    </div>
</div>


