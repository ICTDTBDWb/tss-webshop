<?php
// Plaats van de benodigde PHP-bestanden en sessiebeheer
include basePath("Application/Http/account/services.php");

$klantId = 1; // Voorbeeld klantID, vervang door $session->getKlantId();
$zoekterm = isset($_GET['zoekterm']) ? $_GET['zoekterm'] : '';
$bestellingen = zoekBestellingen($klantId, $zoekterm);
?>

<?php include basePath("Application/Http/account/menu.php"); ?>
<div class="row justify-content-center mb-3">
    <div class="col-md-6">
        <!-- Zoekformulier voor bestellingen -->
        <form action="/account/bestellingen" method="get">
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
                    <a href="/account/bestelling_detail?id=<?php echo htmlspecialchars($bestelling['id']); ?>">
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
