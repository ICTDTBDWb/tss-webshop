<!-- PHP logica -->
<?php include __DIR__ . '/../../Application/Http/beheer/klanten.php'; ?>

<!DOCTYPE html>

<html lang="en">
<!--Head-->
<?php include __DIR__ . "/../../Resources/components/layout/head.php"; ?>

<body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
<!--Header-->
<?php include __DIR__ . "/../../Resources/components/layout/header.php"; ?>

<!--Menu-->
<?php include __DIR__ . "/../../Application/Http/beheer/menu.php"; ?>

<!--Zoekbalk rechts-->
<div class="container-lg flex-grow-1 gx-o py-4">
    <div class="d-flex justify-content-end mt-3">
        <input class="form-control" list="datalistOptions" id="klantenZoeken" placeholder="Klanten zoeken..." style="max-width: 25%">
        <datalist id="datalistOptions">
            <option value=""></option>
            <option value=""></option>
        </datalist>
    </div>
    <div class="d-flex justify-content-start mt-5">
        <h1>Overzicht klanten</h1>
    </div>
    <br>
    <div class="table-responsive-md">
        <?php foreach (queryKlanten() as $klanten) {?>
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
            <tr>
                <td><?php print $klanten['id'];?></td>
                <td><?php print $klanten['voornaam'];?></td>
                <td><?php print $klanten['tussenvoegsel']; ?></td>
                <td><?php print $klanten['achternaam']; ?></td>
                <td><a class="btn btn-secondary" href="klanten_detail.php?id=<?php echo ($klanten['id']); ?>" role="button">Wijzigen</a></td>
                <td>
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                        <input name="klantId" class="d-none" value="<?php echo ($klanten['id']);?>">
                        <button class="btn btn-secondary" onclick="" role="button" name="klantVerwijderen" value="verwijderen">Verwijderen</button>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
            <?php
        }
        ?>
    </div>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $database = new application\DatabaseManager();

        // Verwijder klant uit database
        $result = $database->query("DELETE klanten FROM klanten WHERE id={$klanten['id']}");

        $database->close();

        return $result;

    }
    ?>
</div>
<br>
<div class="container-lg flex-grow-1 gx-o py-4"">
    <div class="d-flex justify-content-end">
        <a class="btn btn-secondary" href="klanten_nieuw.php" role="button">Nieuwe klant aanmaken</a>
    </div>
</div>
    <!--Plaats hier de pagina elementen-->

<!--Footer & Scripts-->
<?php include __DIR__ . "/../../Resources/components/layout/footer.php"; ?>
<?php include __DIR__ . "/../../Resources/components/layout/scripts.php"; ?>
</body>
</html><?php
