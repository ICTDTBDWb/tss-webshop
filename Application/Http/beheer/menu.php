
<?php
require_once(basePath("Application/Auth.php"));

     $auth = Auth::getInstance();
     function make_active(string $path)
     {

         $url = strtok($_SERVER["REQUEST_URI"], '?');

         if ($path == $url)
             return "active";
         else
             return "";
     }


     $items = [["ref" => "/beheer/overzicht", "naam" => "Beheeroverzicht"],
         ["ref" => "/beheer/accountgegevens", "naam" => "Accountgegevens"],
         ["ref" => "/beheer/productbeheer", "naam" => "Productbeheer"],
         ["ref" => "/beheer/cadeaubonnen", "naam" => "Cadeaubonnen", "admin" => [AUTH::ADMIN_ROLE, AUTH::WEBREDACTEUR_ROLE]],
         ["ref" => "/beheer/overzichtbestellingen", "naam" => "Overzicht bestellingen", "admin" => [AUTH::ADMIN_ROLE, AUTH::WEBREDACTEUR_ROLE, AUTH::KLANTENSERVICE_ROLE]],
         ["ref" => "/beheer/klanten", "naam" => "Klantbeheer", "admin" => [AUTH::ADMIN_ROLE, AUTH::WEBREDACTEUR_ROLE, AUTH::KLANTENSERVICE_ROLE]],
         ["ref" => "/beheer/uitloggen", "naam" => "uitloggen"]
     ];

     $content = "";
     foreach ($items as $item) {
         $ref = $item['ref'];
         $naam = $item['naam'];
         $active = make_active($ref);
         $admin_gevraagd = $item['admin'] ?? "";

         if (is_array($admin_gevraagd)) {
             $admin = $auth->check_admin_rol($item['admin']);
             $content .= $admin ? "<a class='btn btn-secondary $active' href=$ref role='button'  >$naam</a>" : "";
         }
         else
             $content .= "<a class='btn btn-secondary $active' href=$ref role='button'  >$naam</a>";
     }






?>

<!DOCTYPE html>


<head>
    <!-- Andere head-elementen -->
    <style>
        /* Stijl voor het geselecteerde navigatie-item */
        .btn.active  {
            background: blue; /* Kies hier de gewenste kleur */
        }

        /* Stijl voor de grijze knoppen */
        .navbar-nav .nav-item .nav-link {
            background-color: lightgray; /* Grijze achtergrondkleur */
            color: black; /* Witte tekstkleur */
            margin-right: 30px; /* Voeg wat ruimte tussen de knoppen toe */
            padding: 10px 15px; /* Binnenste vulling van de knoppen */
            border-radius: 5px; /* Afgeronde hoeken */
        }


    </style>
</head>


<html lang="en">


<div class="container-lg flex-grow-1 gx-0 py-4">
    <div class="d-flex justify-content-evenly">
        <h1 class="mt-0 font-weight-bold mb-5">Beheerdersportaal</h1> <br>
        <h3>ingelogd als : <?php echo $auth->user()['rol'] ?? "" ?></h3>
    </div>
    <!--Button overzicht-->
    <div class="d-flex justify-content-evenly" style="max-width: 75%">
        <?php echo $content ?>

    </div>
</div>
</html>