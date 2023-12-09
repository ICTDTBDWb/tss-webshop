<?php
include __DIR__ . "/../../Application/Http/account/services.php";
$session = \application\SessionManager::getInstance();
$current_page = basename($_SERVER['PHP_SELF']);

$verificatieResultaat = null;
$verificatieMelding = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['cadeaukaartcode'], $_POST['pincode'])) {
        $code = $_POST['cadeaukaartcode'];
        $pin = $_POST['pincode'];
        $verificatieResultaat = verifieerCadeaubon($code, $pin);

        $verificatieMelding = $verificatieResultaat
            ? "Het saldo van de cadeaubon is: €" . htmlspecialchars($verificatieResultaat['bedrag'])
            : "De ingevoerde cadeauboncode of PIN is ongeldig.";
    }
    // Implementeer hier de logica voor de giftbox
}
?>

<!DOCTYPE html>
<html lang="nl">
<!-- Hoofd -->
<?php include __DIR__ . "/../../Resources/components/layout/head.php"; ?>

<body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
<!-- Kop -->
<?php include __DIR__ . "/../../Resources/components/layout/header.php"; ?>
<!-- Menu -->
<?php include __DIR__ . '/../../Application/Http/account/menu.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <h2>Cadeaubonnen</h2>
            <form action="<?= $current_page ?>" method="post">
                <div class="mb-3">
                    <label for="cadeaukaartcode" class="form-label">Cadeaukaartcode</label>
                    <input type="text" class="form-control" id="cadeaukaartcode" name="cadeaukaartcode" required>
                </div>
                <div class="mb-3">
                    <label for="pincode" class="form-label">PIN</label>
                    <input type="password" class="form-control" id="pincode" name="pincode" required>
                </div>
                <button type="submit" class="btn btn-primary">Cadeaubon Verifiëren</button>
            </form>
            <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cadeaukaartcode'])): ?>
                <p class="alert <?= $verificatieResultaat ? 'alert-success' : 'alert-danger' ?>">
                    <?= $verificatieMelding ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <h2>Giftbox</h2>
            <form action="<?= $current_page ?>" method="post">
                <div class="mb-3">
                    <label for="giftboxbedrag" class="form-label">Giftbox bedrag</label>
                    <input type="number" class="form-control" id="giftboxbedrag" name="giftboxbedrag" required>
                </div>
                <button type="submit" class="btn btn-primary">Toevoegen aan winkelwagen</button>
                <br>
                <br>
            </form>
            <p>De TSS Giftbox, een cadeaukaart die de ontvanger zelf kan inwisselen bij TSS voor een tegoed in de webwinkel, wordt sfeervol verpakt en kosteloos thuisbezorgd.</p>
            <br>
            <!-- Afbeelding -->
            <img src="../afbeeldingen/cadeaubon.jpg" alt="Cadeaubon Afbeelding" style="max-width: 100%; height: auto;">
        </div>
    </div>
</div>

<!-- Voet & Scripts -->
<?php include __DIR__ . "/../../Resources/components/layout/footer.php"; ?>
<?php include __DIR__ . "/../../Resources/components/layout/scripts.php"; ?>
</body>
</html>
