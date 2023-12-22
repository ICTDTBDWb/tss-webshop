<?php
use application\DatabaseManager;

require_once __DIR__ . '/../../application/DatabaseManager.php';

// Voer eerst een query uit om de gegevens van de ingelogde medewerker op te halen
// Zorg ervoor dat je de $loggedInUserId variabele hebt ingesteld met de juiste gebruikers-ID.

$query = "SELECT 
    rol,
    email,
    IFNULL(password, 'n.v.t.') AS password,
    IFNULL(voornaam, 'n.v.t.') AS voornaam,
    IFNULL(tussenvoegsel, 'n.v.t.') AS tussenvoegsel,
    IFNULL(achternaam, 'n.v.t.') AS achternaam,
    IFNULL(straat, 'n.v.t.') AS straat,
    IFNULL(huisnummer, 'n.v.t.') AS huisnummer,
    IFNULL(postcode, 'n.v.t.') AS postcode,
    IFNULL(woonplaats, 'n.v.t.') AS woonplaats,
    IFNULL(land, 'n.v.t.') AS land
FROM tss.medewerkers WHERE id = :id";

// Fetch data from the database
$dbManager = new DatabaseManager();
$medewerkers = $dbManager->getMedewerkers(); // Assuming getMedewerkers() is a method that returns employee data
?>

<!DOCTYPE html>
<html lang="en">
<?php include __DIR__ . "/../../application/components/layout/head.php"; ?>
<body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
<?php include __DIR__ . "/../../application/components/layout/header.php"; ?>

<div class="container-lg flex-grow-1 gx-0 py-4">
    <p class="d-flex justify-content-center fs-1 fw-bolder">Beheerdersportaal</p>
    <p class="d-flex justify-content-evenly">
        <a href="beheeroverzicht.php" class="btn btn-secondary active">Beheeroverzicht</a>
        <a href="accountgegevens.php" class="btn btn-secondary">Accountgegevens</a>
        <a href="productbeheer.php" class="btn btn-secondary">Productbeheer</a>
        <a href="overzichtbestellingen.php" class="btn btn-secondary">Overzicht bestellingen</a>
        <a href="klantbeheer.php" class="btn btn-secondary">Klantbeheer</a>
    </p>

    <!-- Table for displaying medewerkers data -->
    <div style="overflow-x: auto;">
        <table class="table" style="width: 80%; margin: 0 auto;">
            <thead>
            <tr>
                <th>Rol</th>
                <th>Email</th>
                <th>Wachtwoord</th>
                <th>Voornaam</th>
                <th>Tussenvoegsel</th>
                <th>Achternaam</th>
                <th>Straat</th>
                <th>Huisnummer</th>
                <th>Postcode</th>
                <th>Woonplaats</th>
                <th>Land</th>
                <th>Acties</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($medewerkers as $medewerker): ?>
                <tr>
                    <td><?php echo htmlspecialchars($medewerker['rol']); ?></td>
                    <td><?php echo htmlspecialchars($medewerker['email']); ?></td>
                    <td>••••••••</td> <!-- Password is not displayed for security reasons -->
                    <td><?php echo htmlspecialchars($medewerker['voornaam']); ?></td>
                    <td><?php echo htmlspecialchars($medewerker['tussenvoegsel']); ?></td>
                    <td><?php echo htmlspecialchars($medewerker['achternaam']); ?></td>
                    <td><?php echo htmlspecialchars($medewerker['straat']); ?></td>
                    <td><?php echo htmlspecialchars($medewerker['huisnummer']); ?></td>
                    <td><?php echo htmlspecialchars($medewerker['postcode']); ?></td>
                    <td><?php echo htmlspecialchars($medewerker['woonplaats']); ?></td>
                    <td><?php echo htmlspecialchars($medewerker['land']); ?></td>
                    <td>
                        <a href="edit_medewerker.php?id=<?php echo $medewerker['id']; ?>" class="btn btn-primary">Wijzigen</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
<?php include __DIR__ . "/../../application/components/layout/footer.php"; ?>
<?php include __DIR__ . "/../../application/components/layout/scripts.php"; ?>
</body>
</html>
