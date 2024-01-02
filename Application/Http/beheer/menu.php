
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
        <a class="btn btn-secondary <?php echo make_active("/beheer/overzicht" ) ?>" href="/beheer/overzicht" role="button"  >Beheeroverzicht</a>
        <a class="btn btn-secondary <?php echo make_active("/beheer/accountgegevens" ) ?>" href="/beheer/accountgegevens" role="button" >Accountgegevens</a>
        <a class="btn btn-secondary <?php echo make_active("/beheer/productbeheer" ) ?>" href="/beheer/productbeheer" role="button" >Productbeheer</a>
        <a class="btn btn-secondary <?php echo make_active("/beheer/cadeaubonnen" ) ?>" href="/beheer/cadeaubonnen" role="button"  >Cadeaubonnen</a>
        <a class="btn btn-secondary <?php echo make_active("/beheer/overzichtbestellingen" ) ?>" href="/beheer/overzichtbestellingen" role="button" >Overzicht bestellingen</a>
        <a class="btn btn-secondary <?php echo make_active("/beheer/klanten" ) ?>" href="/beheer/klanten" role="button" >Klantbeheer</a>
        <a class="btn btn-secondary <?php echo make_active("/beheer/uitloggen" ) ?>" href="/beheer/uitloggen" role="button" >uitloggen</a>
    </div>
</div>
</html>