<?php

include basePath("Application/Http/beheer/menu.php");
$auth->protectAdminPage(Auth::BEHEERDER_ROLES);

$loggedInUser = $auth->user();

// Query om de accountgegevens van de ingelogde gebruiker op te halen
$query = "SELECT 
    id,
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
FROM tss.medewerkers WHERE id = ?";

// Voeg de parameter voor de gebruikers-ID toe aan de query
$dbManager = new Database();
$medewerker = $dbManager->query($query, [$loggedInUser['id']])->first();; // Haal één medewerker op

// Controleer of er gegevens zijn gevonden voor de ingelogde gebruiker
if (!$medewerker) {
    // Geen gegevens gevonden voor de ingelogde gebruiker, toon een foutmelding of neem andere stappen
    echo 'Geen accountgegevens gevonden voor de ingelogde gebruiker.';
    exit;
}
?>

<!-- Nu kun je de accountgegevens van de ingelogde gebruiker weergeven -->
<p class="d-flex justify-content-center fs-1 fw-bolder">Beheerdersportaal</p>

<!-- Toon de accountgegevens van de ingelogde gebruiker -->
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
                <a href="/beheer/edit_medewerker?id=<?php echo $medewerker['id']; ?>" class="btn btn-primary">Wijzigen</a>
            </td>
        </tr>
        </tbody>
    </table>
</div>
