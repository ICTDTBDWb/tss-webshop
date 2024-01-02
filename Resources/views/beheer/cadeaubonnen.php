<?php

include basePath('Application/Http/beheer/services.php');
include basePath("Application/Http/beheer/menu.php");
$auth->protectAdminPage([Auth::WEBREDACTEUR_ROLE]);



// Verwerk het toevoegen van een cadeaubon
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['toevoegen'])) {
    $code = valideerInput($_POST['code'], 25);
    $pin = valideerInput($_POST['pin'], 11);
    $bedrag = valideerInput($_POST['bedrag'], 12, true);

    if (!isValideLengte($code, 25) || !isValideLengte($pin, 11) || !isValideBedrag($bedrag)) {
        echo "<script>alert('Fout: Onjuiste invoer.');</script>";
    } else {
        $bedrag = number_format((float)$bedrag, 2, '.', '');
        if (!cadeaubonBestaat($code)) {
            queryVoegCadeaubonToe($code, $pin, $bedrag);
            echo "<script>alert('Cadeaubon succesvol toegevoegd.');</script>";
        } else {
            echo "<script>alert('Fout: Een cadeaubon met deze code bestaat al.');</script>";
        }
    }
}

// Verwerk het wijzigen van een cadeaubon
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['wijzigen'])) {
    $cadeaubonId = $_POST['wijzig_cadeaubon_id'];
    $nieuweCode = valideerInput($_POST['nieuwe_code'], 25);
    $nieuwBedrag = valideerInput($_POST['nieuw_bedrag'], 10, true);

    if (!isValideLengte($nieuweCode, 25) || !isValideBedrag($nieuwBedrag)) {
        echo "<script>alert('Fout: Onjuiste invoer.');</script>";
    } else {
        $nieuwBedrag = number_format((float)$nieuwBedrag, 2, '.', '');
        if (!cadeaubonBestaat($nieuweCode)) {
            queryWijzigCadeaubon($cadeaubonId, $nieuweCode, $nieuwBedrag);
            echo "<script>alert('Cadeaubon succesvol gewijzigd.');</script>";
        } else {
            echo "<script>alert('Fout: Een cadeaubon met deze code bestaat al.');</script>";
        }
    }
}

// Verwerkt  het verwijderen van een cadeaubon
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['verwijderen'])) {
    $cadeaubonId = $_POST['cadeaubon_id'];
    queryVerwijderCadeaubon($cadeaubonId);
}

// Haal alle cadeaubonnen op
$cadeaubonnen = queryHaalCadeaubonnenOp();
?>

<!-- Toevoegen Cadeaubon Sectie -->
<div class="card mb-4">
    <div class="card-header">
        Toevoegen Cadeaubon
    </div>
    <div class="card-body">
        <form method="post">
            <div class="mb-3">
                <label for="code" class="form-label">Code:</label>
                <input type="text" class="form-control" id="code" name="code" required>
            </div>
            <div class="mb-3">
                <label for="pin" class="form-label">PIN:</label>
                <input type="text" class="form-control" id="pin" name="pin" required>
            </div>
            <div class="mb-3">
                <label for="bedrag" class="form-label">Bedrag:</label>
                <input type="number" class="form-control" id="bedrag" name="bedrag" step="0.01" required>
            </div>
            <button type="submit" name="toevoegen" class="btn btn-primary">Voeg Toe</button>
        </form>
    </div>
</div>

<!-- Wijzig Cadeaubon Sectie -->
<div class="card mb-4">
    <div class="card-header">
        Wijzig Cadeaubon
    </div>
    <div class="card-body">
        <form method="post">
            <div class="mb-3">
                <label for="wijzig_cadeaubon_id" class="form-label">Kies een Cadeaubon om te Wijzigen:</label>
                <select class="form-select" id="wijzig_cadeaubon_id" name="wijzig_cadeaubon_id" required>
                    <option value="">Selecteer een Cadeaubon</option>
                    <?php foreach ($cadeaubonnen as $cadeaubon) {
                        echo "<option value='{$cadeaubon['id']}'>{$cadeaubon['code']} - €{$cadeaubon['bedrag']}</option>";
                    } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="nieuwe_code" class="form-label">Nieuwe Code:</label>
                <input type="text" class="form-control" id="nieuwe_code" name="nieuwe_code" required>
            </div>
            <div class="mb-3">
                <label for="nieuw_bedrag" class="form-label">Nieuw Bedrag:</label>
                <input type="number" class="form-control" id="nieuw_bedrag" name="nieuw_bedrag" step="0.01" required>
            </div>
            <button type="submit" name="wijzigen" class="btn btn-warning">Wijzig</button>
        </form>
    </div>
</div>

<!-- Verwijder Cadeaubon Sectie -->
<div class="card">
    <div class="card-header">
        Verwijder Cadeaubon
    </div>
    <div class="card-body">
        <form method="post">
            <div class="mb-3">
                <label for="cadeaubon_id" class="form-label">Kies een Cadeaubon om te Verwijderen:</label>
                <select class="form-select" id="cadeaubon_id" name="cadeaubon_id" required>
                    <option value="">Selecteer een Cadeaubon</option>
                    <?php foreach ($cadeaubonnen as $cadeaubon) {
                        echo "<option value='{$cadeaubon['id']}'>{$cadeaubon['code']} - €{$cadeaubon['bedrag']}</option>";
                    } ?>
                </select>
            </div>
            <button type="submit" name="verwijderen" class="btn btn-danger" onclick="return confirm('Weet u zeker dat deze cadeaubon verwijderd moet worden?');">Verwijder</button>
        </form>
    </div>
</div>
