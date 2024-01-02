<?php
include basePath("Application/Http/beheer/menu.php");
$auth->protectAdminPage(Auth::BEHEERDER_ROLES);
// Initial variables
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$condition = $searchTerm ? "WHERE id LIKE '%$searchTerm%'" : '';

// Haal alle bestellingen op
try {
    $db = new Database();
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