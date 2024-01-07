<?php

// Controleer of het HTTP-verzoek een POST-verzoek is
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gegevens uit het formulier halen
    $email = $_POST['email'];
    $password = $_POST['password'];
    $voornaam = $_POST['voornaam'];
    $tussenvoegsel = $_POST['tussenvoegsel'];
    $achternaam = $_POST['achternaam'];
    $straat = $_POST['straat'];
    $huisnummer = $_POST['huisnummer'];
    $postcode = $_POST['postcode'];
    $woonplaats = $_POST['woonplaats'];
    $land = $_POST['land'];

    // Valideer de verplichte velden
    $errorMessage = '';

    if (empty($email) || empty($password) || empty($voornaam) || empty($achternaam) || empty($straat) || empty($huisnummer) || empty($postcode) || empty($woonplaats) || empty($land)) {
        $errorMessage = 'Vul alle verplichte velden in.';
    }

    if (empty($errorMessage)) {
        // Hash het wachtwoord voordat het in de database wordt opgeslagen
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Als er geen fouten zijn, voer dan de registratielogica uit
        try {
            // Maak een databaseverbinding
            $db = new Database();
            $db->getConnection()->beginTransaction();

            // Query opstellen om het hoogste ID op te halen en er 1 bij op te tellen
            $queryGetMaxId = "SELECT MAX(id) AS max_id FROM tss.klanten";
            $db->query($queryGetMaxId);
            $result = $db->get();

            $maxId = isset($result[0]['max_id']) ? (int)$result[0]['max_id'] : 0;
            $newId = $maxId + 1;

            if ($db->getConnection()) {
                $sql = "INSERT INTO tss.klanten 
                        (id, email, password, voornaam, tussenvoegsel, achternaam, straat, huisnummer, postcode, woonplaats, land) 
                        VALUES (:id, :email, :password, :voornaam, :tussenvoegsel, :achternaam, :straat, :huisnummer, :postcode, :woonplaats, :land)";

                $stmt = $db->getConnection()->prepare($sql);

                // Bind parameters aan de prepared statement
                $stmt->bindParam(':id', $newId);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashedPassword); // Wachtwoord hashen
                $stmt->bindParam(':voornaam', $voornaam);
                $stmt->bindParam(':tussenvoegsel', $tussenvoegsel);
                $stmt->bindParam(':achternaam', $achternaam);
                $stmt->bindParam(':straat', $straat);
                $stmt->bindParam(':huisnummer', $huisnummer);
                $stmt->bindParam(':postcode', $postcode);
                $stmt->bindParam(':woonplaats', $woonplaats);
                $stmt->bindParam(':land', $land);

                // Uitvoeren van de prepared statement
                $stmt->execute();

                // Haal het automatisch gegenereerde ID op
                $lastInsertId = $db->getConnection()->lastInsertId();

                // Commit de transactie
                $db->getConnection()->commit();

                echo "Account succesvol aangemaakt";
            }
        } catch (PDOException $e) {
            echo "Er is een fout opgetreden: " . $e->getMessage();
        }
    } else {
        // Er zijn fouten, toon ze aan de gebruiker
        echo $errorMessage;
    }
}
?>


<h1>Account aanmaken</h1>
<div class="d-flex justify-content-end mt-2">
    <a class="btn btn-secondary" href="/login" role="button" style="align-content: end">Terug naar login</a>
</div>
<br>
<style>
    input {
        width: 100%;
    }
</style>
<form method="post" action="/klant_account_aanmaken">
    <div class="fw-bold">* = verplicht veld</div>
    <div class="mb-3">
        *Email: <input type="email" name="email" placeholder="email">
    </div>
    <div class="mb-3">
        *Wachtwoord: <input type="password" name="password" placeholder="wachtwoord">
    </div>
    <div class="mb-3">
        *Voornaam: <input type="text" name="voornaam" placeholder="voornaam">
    </div>
    <div class="mb-3">
        Tussenvoegsel: <input type="text" name="tussenvoegsel" placeholder="tussenvoegsel">
    </div>
    <div class="mb-3">
        *Achternaam: <input type="text" name="achternaam" placeholder="achternaam">
    </div>
    <div class="mb-3">
        *Straat: <input type="text" name="straat" placeholder="straat">
    </div>
    <div class="mb-3">
        *Huisnummer: <input type="number" name="huisnummer" placeholder="huisnummer">
    </div>
    <div class="mb-3">
        *Postcode: <input type="text" name="postcode" placeholder="postcode">
    </div>
    <div class="mb-3">
        *Woonplaats: <input type="text" name="woonplaats" placeholder="woonplaats">
    </div>
    <div class="mb-3">
        *Land: <input type="text" name="land" placeholder="land">
    </div>
    <br>
    <div class="d-flex justify-content-start mt-2">
        <!--Voeg klant toe met ingevulde gegevens-->
        <button class="btn btn-secondary" type="submit" name="submit">Account aanmaken</button>
    </div>
</form>


