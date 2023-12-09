<?php
// Inclusie van de benodigde PHP-bestanden en sessiebeheer
include __DIR__ . "/../../Application/Http/account/services.php";
$session = \application\SessionManager::getInstance();

$klantId = 1; // Voorbeeld klantID, vervang door $session->getKlantId();
$zoekterm = isset($_GET['zoekterm']) ? $_GET['zoekterm'] : '';

function zoekBestellingen($klantId, $zoekterm) {
    $database = new \application\DatabaseManager();
    $zoekterm = '%' . $zoekterm . '%';

    $query = "SELECT b.*, p.naam AS productnaam FROM tss.bestellingen b 
              JOIN tss.bestelling_regels br ON b.id = br.bestelling_id
              JOIN tss.producten p ON br.product_id = p.id
              WHERE b.klant_id = ? AND (b.id LIKE ? OR p.naam LIKE ?)
              GROUP BY b.id";

    return $database->query($query, [$klantId, $zoekterm, $zoekterm])->get();
}

$bestellingen = zoekBestellingen($klantId, $zoekterm);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Bestelling Overzicht</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <?php include __DIR__ . "/../../Resources/components/layout/head.php"; ?>
</head>
<body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
<?php include __DIR__ . "/../../Resources/components/layout/header.php"; ?>
<?php include __DIR__ . '/../../Application/Http/account/menu.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center mb-3">
        <div class="col-md-6">
            <form action="bestellingen.php" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" name="zoekterm" placeholder="Zoeken op bestelling-ID of product">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Zoeken</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php if (!empty($bestellingen)): ?>
        <table class="table">
            <thead>
            <tr>
                <th>Bestelling ID</th>
                <th>Besteldatum</th>
                <th>Product</th>
                <th>Totaal</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($bestellingen as $bestelling): ?>
                <tr>
                    <td><a href="bestelling_detail.php?id=<?php echo htmlspecialchars($bestelling['id']); ?>"><?php echo htmlspecialchars($bestelling['id']); ?></a></td>
                    <td><?php echo htmlspecialchars($bestelling['besteldatum']); ?></td>
                    <td><?php echo htmlspecialchars($bestelling['productnaam']); ?></td>
                    <td>€<?php echo htmlspecialchars(number_format($bestelling['totaal'], 2, ',', '.')); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Geen bestellingen gevonden.</p>
    <?php endif; ?>
</div>

<?php include __DIR__ . "/../../Resources/components/layout/footer.php"; ?>
<?php include __DIR__ . "/../../Resources/components/layout/scripts.php"; ?>
</body>
</html>
