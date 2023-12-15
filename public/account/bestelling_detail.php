<?php
// Plaats van de benodigde PHP-bestanden en sessiebeheer
include __DIR__ . "/../../Application/Http/account/services.php";
$session = \application\SessionManager::getInstance();

// Haal de bestelling ID op uit de querystring (indien aanwezig)
$bestellingId = isset($_GET['id']) ? $_GET['id'] : null;
$bestellingDetails = null;
if ($bestellingId) {
    // Haal de bestellingdetails op aan de hand van de bestelling ID
    $bestellingDetails = haalBestellingDetailsOp($bestellingId);
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Bestelling Detail</title>
    <!-- Voeg de Bootstrap CSS-stijlen toe -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Plaats van andere head-elementen, zoals stylesheets of scripts -->
    <?php include __DIR__ . "/../../Resources/components/layout/head.php"; ?>
</head>
<body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
<!-- Plaats van de website-header -->
<?php include __DIR__ . "/../../Resources/components/layout/header.php"; ?>
<!-- Plaats van het navigatiemenu voor de accountsectie -->
<?php include __DIR__ . '/../../Application/Http/account/menu.php'; ?>

<div class="container mt-5">
    <?php if ($bestellingDetails): ?>
        <!-- Weergave van bestellingdetails als deze zijn opgehaald -->
        <h2>Bestelling Details (ID: <?php echo $bestellingId; ?>)</h2>
        <table class="table">
            <thead>
            <tr>
                <th>Bestelling ID</th>
                <th>Betaalprovider ID</th>
                <th>Prijs</th>
                <th>Status</th>
                <th>Productnaam</th>
                <th>Afbeelding</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($bestellingDetails as $detail): ?>
                <!-- Weergave van elke bestellingdetail in een tabelrij -->
                <tr>
                    <td><?php echo htmlspecialchars($detail['bestelling_id']); ?></td>
                    <td><?php echo htmlspecialchars($detail['betalingsprovider']); ?></td>
                    <td>€<?php echo htmlspecialchars(number_format($detail['prijs'], 2, ',', '.')); ?></td>
                    <td><?php echo htmlspecialchars($detail['status']); ?></td>
                    <td><?php echo htmlspecialchars($detail['productnaam']); ?></td>
                    <td>
                        <?php if (!empty($detail['mediapad'])): ?>
                            <!-- Weergave van productafbeelding als deze beschikbaar is -->
                            <img src="<?php echo htmlspecialchars($detail['mediapad']); ?>" alt="Product Afbeelding" style="max-width: 100px; height: auto;">
                        <?php else: ?>
                            <!-- Als er geen afbeelding beschikbaar is -->
                            Geen afbeelding
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <!-- Weergave van een bericht als de bestelling niet is gevonden -->
        <p>Bestelling niet gevonden.</p>
    <?php endif; ?>
</div>

<!-- Plaats van de website-footer -->
<?php include __DIR__ . "/../../Resources/components/layout/footer.php"; ?>
<!-- Plaats van scripts of andere JavaScript-bestanden -->
<?php include __DIR__ . "/../../Resources/components/layout/scripts.php"; ?>
</body>
</html>
