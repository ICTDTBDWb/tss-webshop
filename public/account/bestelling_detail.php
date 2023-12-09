<?php
// Inclusie van de benodigde PHP-bestanden en sessiebeheer
include __DIR__ . "/../../Application/Http/account/services.php";
$session = \application\SessionManager::getInstance();

$bestellingId = isset($_GET['id']) ? $_GET['id'] : null;

function haalBestellingDetailsOp($bestellingId) {
    $database = new \application\DatabaseManager();

    // Aangepaste query om bestelling_id, betaalprovider_id, prijs, status, productnaam en mediapad op te halen
    $query = "SELECT b.id AS bestelling_id, bt.betalingsprovider, b.totaal AS prijs, 
                     IF(bt.betalingsprovider IS NOT NULL, 'Betaald', 'Niet Betaald') AS status,
                     (SELECT p.naam FROM tss.producten p 
                      JOIN tss.bestelling_regels br ON p.id = br.product_id 
                      WHERE br.bestelling_id = b.id LIMIT 1) AS productnaam,
                     (SELECT pm.pad FROM tss.media pm 
                      JOIN tss.product_media prm ON pm.id = prm.media_id 
                      JOIN tss.bestelling_regels br ON prm.product_id = br.product_id 
                      WHERE br.bestelling_id = b.id LIMIT 1) AS mediapad
              FROM tss.bestellingen b 
              LEFT JOIN tss.betalingen bt ON b.id = bt.bestelling_id
              WHERE b.id = ?";

    return $database->query($query, [$bestellingId])->get();
}

$bestellingDetails = null;
if ($bestellingId) {
    $bestellingDetails = haalBestellingDetailsOp($bestellingId);
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Bestelling Detail</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <?php include __DIR__ . "/../../Resources/components/layout/head.php"; ?>
</head>
<body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
<?php include __DIR__ . "/../../Resources/components/layout/header.php"; ?>
<?php include __DIR__ . '/../../Application/Http/account/menu.php'; ?>

<div class="container mt-5">
    <?php if ($bestellingDetails): ?>
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
                <tr>
                    <td><?php echo htmlspecialchars($detail['bestelling_id']); ?></td>
                    <td><?php echo htmlspecialchars($detail['betalingsprovider']); ?></td>
                    <td>€<?php echo htmlspecialchars(number_format($detail['prijs'], 2, ',', '.')); ?></td>
                    <td><?php echo htmlspecialchars($detail['status']); ?></td>
                    <td><?php echo htmlspecialchars($detail['productnaam']); ?></td>
                    <td>
                        <?php if (!empty($detail['mediapad'])): ?>
                            <img src="<?php echo htmlspecialchars($detail['mediapad']); ?>" alt="Product Afbeelding" style="max-width: 100px; height: auto;">
                        <?php else: ?>
                            Geen afbeelding
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Bestelling niet gevonden.</p>
    <?php endif; ?>
</div>

<?php include __DIR__ . "/../../Resources/components/layout/footer.php"; ?>
<?php include __DIR__ . "/../../Resources/components/layout/scripts.php"; ?>
</body>
</html>
