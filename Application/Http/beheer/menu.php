
<?php

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

<html lang="en">

<div class="container-lg flex-grow-1 gx-0 py-4">
    <div class="d-flex justify-content-center">
        <h1 class="mt-0 font-weight-bold mb-5">Beheerdersportaal</h1>
    </div>
    <!--Button overzicht-->
    <div class="mt-2 mb-0 d-flex justify-content-evenly" style="max-width: 75%">
        <a class="btn btn-secondary <?php echo make_active("" ) ?>" href="#" role="button"  >Beheeroverzicht</a>
        <a class="btn btn-secondary <?php echo make_active("" ) ?>" href="#" role="button" >Accountgegevens</a>
        <a class="btn btn-secondary <?php echo make_active("/beheer/productbeheer" ) ?>" href="/beheer/productbeheer" role="button" >Productbeheer</a>
        <a class="btn btn-secondary <?php echo make_active("/beheer/cadeaubonnen" ) ?>" href="/beheer/cadeaubonnen" role="button" >Cadeaubonnen</a>
        <a class="btn btn-secondary <?php echo make_active("" ) ?>" href="#" role="button" >Overzicht bestellingen</a>
        <a class="btn btn-secondary <?php echo make_active("/beheer/klanten" ) ?>" href="/beheer/klanten" role="button" >Klantbeheer</a>
    </div>
</div>
</html>