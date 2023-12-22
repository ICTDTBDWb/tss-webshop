<?php
include_once __DIR__ . '/../../application/DatabaseManager.php';

// Initial variables
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$condition = $searchTerm ? "WHERE id LIKE '%$searchTerm%'" : '';

// Haal alle bestellingen op
try {
    $db = new \application\DatabaseManager();
    $query = "SELECT * FROM tss.bestellingen $condition";
    $db->query($query);
    $bestellingen = $db->get();
    $db->close();
} catch (\Exception $e) {
    // Log de fout of toon een foutmelding
    error_log('Fout bij het ophalen van bestellingen: ' . $e->getMessage());
    echo 'Er is een fout opgetreden bij het ophalen van bestellingen. Probeer het later opnieuw. Foutdetails: ' . $e->getMessage();
    // Stop de verdere uitvoering van de code om verdere fouten te voorkomen
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include __DIR__ . "/../../application/components/layout/head.php"; ?>
<body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
<?php include __DIR__ . "/../../application/components/layout/header.php"; ?>

<div class="container-lg flex-grow-1 gx-0 py-4">
    <p class="d-flex justify-content-center fs-1 fw-bolder">Beheerdersportaal</p>



    <p class="d-flex justify-content-evenly">
        <a href="beheeroverzicht.php" class="btn btn-secondary">Beheeroverzicht</a>
        <a href="accountgegevens.php" class="btn btn-secondary">Accountgegevens</a>
        <a href="productbeheer.php" class="btn btn-secondary">Productbeheer</a>
        <a href="overzichtbestellingen.php" class="btn btn-secondary active">Overzicht bestellingen</a>
        <a href="klantbeheer.php" class="btn btn-secondary">Klantbeheer</a>
    </p>
    <br>
    <!-- Search bar -->
    <form class="d-flex justify-content-center mb-3" action="" method="GET">
        <input class="form-control me-2" type="text" name="search" placeholder="Zoek op bestelnummer" value="<?php echo $searchTerm; ?>">
        <button class="btn btn-primary" type="submit">Zoeken</button>
    </form>


    <div class="container mt-4">
        <div class="overflow-auto" style="max-height: 400px;">
            <ul id="bestellingenList" class="list-group">
                <?php
                if ($bestellingen) {
                    foreach ($bestellingen as $bestelling) {
                        echo '<li class="list-group-item">' .
                            '<strong>Bestelnummer:</strong> ' . $bestelling['id'] . '<br>' .
                            '<strong>Klant:</strong> ' . $bestelling['klant_id'] . '<br>' .
                            '<strong>Datum:</strong> ' . $bestelling['besteldatum'] .
                            '</li>';
                    }
                } else {
                    echo '<li class="list-group-item">Geen bestellingen gevonden.</li>';
                }
                ?>
            </ul>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../../application/components/layout/footer.php"; ?>
<?php include __DIR__ . "/../../application/components/layout/scripts.php"; ?>
</body>
</html>
