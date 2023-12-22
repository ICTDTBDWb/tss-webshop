<?php
include_once __DIR__ . '/../../application/DatabaseManager.php';

header('Content-Type: application/json');

try {
    $db = new \application\DatabaseManager();

    $query = "SELECT MONTH(besteldatum) AS maand, COUNT(*) AS aantalBestellingen 
          FROM tss.bestellingen 
          GROUP BY MONTH(besteldatum)";

    $db->query($query);
    $resultaten = $db->get();

    echo json_encode($resultaten);
} catch (\Exception $e) {
    // Log de fout of toon een foutmelding
    error_log('Fout bij het ophalen van de bestellingen: ' . $e->getMessage());
    echo json_encode(["error" => "Er is een fout opgetreden bij het ophalen van de bestellingen."]);
}
?>
