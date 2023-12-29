<?php
$auth->protectAdminPage(['webredacteur']);

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

// Formuliervelden ophalen
    $voornaam = $_POST['voornaam'];
    $tussenvoegsel = $_POST['tussenvoegsel'];
    $achternaam = $_POST['achternaam'];
    $emailadres = $_POST['emailadres'];
    $wachtwoord = $_POST['password'];
    $rol = $_POST['rol'];

    if (empty($voornaam) || empty($achternaam) || empty($emailadres) || empty($wachtwoord) || empty($rol)) {
        $errorMessage = 'Vul alle verplichte velden in.';
    } else {
        try {
            // Verbinding maken met de database
            $db = new Database();


            // Wachtwoord hashen
            $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);

            // Query opstellen om het hoogste ID op te halen en er 1 bij op te tellen
            $queryGetMaxId = "SELECT MAX(id) AS max_id FROM tss.medewerkers";
            $db->query($queryGetMaxId);
            $result = $db->get();

            $maxId = isset($result[0]['max_id']) ? (int)$result[0]['max_id'] : 0;
            $newId = $maxId + 1;

            // Query opstellen en uitvoeren om medewerker toe te voegen
            $query = "INSERT INTO tss.medewerkers 
                  (id, rol, email, password, voornaam, tussenvoegsel, achternaam, straat, huisnummer, postcode, woonplaats, land) 
                  VALUES 
                  ($newId, $rol, '$emailadres', '$hashedPassword', '$voornaam', '$tussenvoegsel', '$achternaam', NULL, NULL, NULL, NULL, NULL)";

            $db->query($query);

            // Sluit de databaseverbinding
            $db->close();

            echo 'Medewerker succesvol toegevoegd.';
        } catch (\Exception $e) {
            // Log de fout of toon een foutmelding
            error_log('Fout bij het toevoegen van de medewerker: ' . $e->getMessage());
            echo 'Er is een fout opgetreden bij het toevoegen van de medewerker. Probeer het later opnieuw.';
        }
    }
}
?>

    <p class="d-flex justify-content-center fs-1 fw-bolder">Beheerdersportaal</p>
    <p class="d-flex justify-content-evenly">
        <a href="/beheer/overzicht" class="btn btn-secondary active">Beheeroverzicht</a>
        <a href="/beheer/accountgegevens" class="btn btn-secondary">Accountgegevens</a>
        <a href="/beheer/productbeheer" class="btn btn-secondary">Productbeheer</a>
        <a href="/beheer/overzichtbestellingen" class="btn btn-secondary">Overzicht bestellingen</a>
        <a href="/beheer/klantbeheer" class="btn btn-secondary">Klantbeheer</a>
    </p>

    <div class="row justify-content-start">
        <div class="col-md-4 mb-4">
            <form class="border p-4" method="post" action="">
                <div class="mb-3">
                    <label for="voornaam" class="form-label">Voornaam</label>
                    <input type="text" class="form-control" id="voornaam" name="voornaam">
                </div>
                <div class="mb-3">
                    <label for="tussenvoegsel" class="form-label">Tussenvoegsel</label>
                    <input type="text" class="form-control" id="tussenvoegsel" name="tussenvoegsel">
                </div>
                <div class="mb-3">
                    <label for="achternaam" class="form-label">Achternaam</label>
                    <input type="text" class="form-control" id="achternaam" name="achternaam">
                </div>
                <div class="mb-3">
                    <label for="emailadres" class="form-label">Emailadres</label>
                    <input type="email" class="form-control" id="emailadres" name="emailadres">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Wachtwoord</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3">
                    <label for="rol" class="form-label">Rol</label>
                    <select class="form-control" id="rol" name="rol">
                        <option value="1">Admin</option>
                        <option value="2">Manager</option>
                        <option value="3">Beheerder</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Account toevoegen</button>
            </form>
        </div>

        <!-- Aangepaste container voor het staafdiagram -->
        <div class="col-md-7 ml-5" style="margin-top: 50px;">
            <div id="chartContainer" style="padding-left: 50px;">
                <canvas id="barChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

<!-- JavaScript en Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var data = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Aantal bezoekers',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
            data: new Array(12).fill(0) // Tijdelijke data
        },
            {
                label: 'Aantal bestellingen',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                data: new Array(12).fill(0) // Tijdelijke data
            }]
    };

    var options = {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };
    // Bestaande Chart.js initialisatie en configuratie
    var ctx = document.getElementById('barChart').getContext('2d');
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });

    function laadBestellingenData() {
        fetch('/../../application/beheer/getData.php')
            .then(response => response.json())
            .then(jsonData => {
                console.log("Opgehaalde data:", jsonData); // Voeg dit toe

                const bestellingenPerMaand = new Array(12).fill(0);
                jsonData.forEach(item => {
                    bestellingenPerMaand[item.maand - 1] = item.aantalBestellingen;
                });

                console.log("Data voor grafiek:", bestellingenPerMaand); // Voeg dit toe

                myBarChart.data.datasets[1].data = bestellingenPerMaand;
                myBarChart.update();
            })
            .catch(error => {
                console.error('Fout bij het ophalen van data:', error);
            });
    }
</script>
