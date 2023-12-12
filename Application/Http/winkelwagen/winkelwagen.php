<?php
include(__DIR__."/../../DatabaseManager.php");
include("functies.php");
session_start();
$databaseManager = new \application\DatabaseManager();

// hard coded true for testing
$path = "http://localhost/tss/public/winkelwagen";
$path_product = "http://localhost/tss/public/product";
//$path_media ="http://localhost/tss/public/winkelwagen";


$placeholder = "/gitaar1.jpg";

//Zet een totaalprijs om op te bouwen met up-to-date productinformatie
$totaal_prijs = 0;

//hardcode logged in
$user_logged_in = $_SESSION['user']['logged_in']??true;
//$_SESSION = [];

updateSessionCartProducts($databaseManager);



// Checkt als verwijderknop is gesubmit en verwijderd bijbehorende product
if(isset($_POST['remove_product'])){
    $id = filter_input(INPUT_POST, 'remove_product', FILTER_SANITIZE_NUMBER_INT);

    $producten = $_SESSION["winkelwagen"]["producten"]??false;

    if($producten && $id){
        foreach($_SESSION["winkelwagen"]["producten"] as $key => $product){
            if($product['id'] == $id) {
                unset($_SESSION["winkelwagen"]["producten"][$key]);
            }
        }
    }
}

// check of wijzigingen opslaan is gebruikt en of er producten post zitten.
if(isset($_POST['wijzigingen_opslaan']) && count($_POST) > 1){

    //unset wijzigingen opslaan, nu zijn de rest van de array opties een "[product_id]_[hoeveelheid]" string.
    unset($_POST['wijzigingen_opslaan']);

    //check if there are products
    $producten = $_SESSION["winkelwagen"]["producten"]??false;

    foreach($_POST as $id => $quantity){
        if(is_numeric($id) && is_numeric($quantity) && $producten){
            foreach ($_SESSION["winkelwagen"]["producten"] as $key => $product){
                if($product['id'] == $id) {
                    if($quantity < 1){
                        unset( $_SESSION["winkelwagen"]["producten"][$key]);
                    }else {
                        $_SESSION["winkelwagen"]["producten"][$key]['hoeveelheid_in_winkelwagen'] = $quantity;
                    }

                }
            }
        } else {
            // Als ID of Quantity geen nummer zijn, dan zijn de velden door klant bewerkt.
            echo "Error: Id, Quantity not numeric or no products in cart.";
            exit;
        }
    }
}

// Testdata: Vul cart met een paar producten, dirty as well, use product_id as key for product
// Todo: Remove before going to production
if ($_GET['addtocart']??false){
        $id = $_GET['addtocart'];

        $query = "SELECT p.id, p.naam as product_naam, p.prijs, m.naam as media_naam, m.pad as media_pad ".
            "FROM producten as p ".
            "JOIN product_media as pm on p.id=pm.product_id ".
            "JOIN media as m on m.id=pm.media_id ".
            "WHERE p.id = :id ".
            "GROUP BY pm.product_id ";

        $result = $databaseManager->query($query, ["id" => $id])->first();
        if(isset($_SESSION["winkelwagen"]["producten"][$id])) {
            $_SESSION["winkelwagen"]["producten"][$id]["hoeveelheid_in_winkelwagen"]++;
        } else {
            $_SESSION["winkelwagen"]["producten"][$id]["hoeveelheid_in_winkelwagen"] = 1;
        }

        $_SESSION["winkelwagen"]["producten"][$id]["id"] = $result['id'];
        $_SESSION["winkelwagen"]["producten"][$id]["product_naam"] = $result['product_naam'];
        $_SESSION["winkelwagen"]["producten"][$id]["prijs"] = $result['prijs'];
        $_SESSION["winkelwagen"]["producten"][$id]["media_naam"] = $result['media_naam'];
        $_SESSION["winkelwagen"]["producten"][$id]["media_pad"] = $result['media_pad'];
}

//Check winkelwagen of set false
if(
    ($_SESSION["winkelwagen"]['producten']??false)
    && count($_SESSION["winkelwagen"]['producten'])
){
    $producten = $_SESSION["winkelwagen"]['producten'];
} else{
    $producten = false;
}

?>