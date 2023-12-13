<?php
// Plaats van de benodigde PHP-bestanden en sessiebeheer
include __DIR__ . "/../../Application/Http/account/services.php";
$session = \application\SessionManager::getInstance();

$klantId = 1; // Voorbeeld klantID, vervang door $session->getKlantId();
$zoekterm = isset($_GET['zoekterm']) ? $_GET['zoekterm'] : '';
$bestellingen = zoekBestellingen($klantId, $zoekterm);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Bestelling Overzicht</title>

    <!-- Plaats van andere head-elementen, zoals stylesheets of scripts -->
    <?php include __DIR__ . "/../../Resources/components/layout/head.php"; ?>
</head>
<body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
<!-- Plaats van de website-header -->
<?php include __DIR__ . "/../../Resources/components/layout/header.php"; ?>
<!-- Plaats van het navigatiemenu voor de accountsectie -->
<?php include __DIR__ . '/../../Application/Http/account/menu.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center mb-3">
        <div class="col-md-6">
            <!-- Zoekformulier voor bestellingen -->
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
        <!-- Weergave van bestellingen als deze zijn gevonden -->
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
                <!-- Weergave van elke bestelling in een tabelrij -->
                <tr>
                    <td>
                        <!-- Link naar de gedetailleerde bestellingspagina met het bestellings-ID als parameter -->
                        <a href="bestelling_detail.php?id=<?php echo htmlspecialchars($bestelling['id']); ?>">
                            <?php echo htmlspecialchars($bestelling['id']); ?>
                        </a>
                    </td>
                    <td><?php echo htmlspecialchars($bestelling['besteldatum']); ?></td>
                    <td><?php echo htmlspecialchars($bestelling['productnaam']); ?></td>
                    <td>
                        <!-- Weergave van het totale bedrag in Euro-formaat -->
                        €<?php echo htmlspecialchars(number_format($bestelling['totaal'], 2, ',', '.')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <!-- Weergave van een bericht als er geen bestellingen zijn gevonden -->
        <p>Geen bestellingen gevonden.</p>
    <?php endif; ?>
</div>

<!-- Plaats van de website-footer -->
<?php include __DIR__ . "/../../Resources/components/layout/footer.php"; ?>
<!-- Plaats van scripts of andere JavaScript-bestanden -->
<?php include __DIR__ . "/../../Resources/components/layout/scripts.php"; ?>
</body>
</html>
