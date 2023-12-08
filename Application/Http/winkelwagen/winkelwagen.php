<?php
include(__DIR__."/../../DatabaseManager.php");
session_start();
$connection = new \application\DatabaseManager();

// hard coded true for testing
$path = "http://localhost/tss/public/winkelwagen";
$path_product = "http://localhost/tss/public/product";
//$path_media ="http://localhost/tss/public/winkelwagen";
$path_media ="/winkelwagen";

$placeholder = "/gitaar1.jpg";

$totaal_prijs = 0;

//hardcode logged in
$user_logged_in = $_SESSION['user']['logged_in']??true;

// Update session cart info with most recent data
if(isset($_SESSION["winkelwagen"]["producten"]) && count($_SESSION["winkelwagen"]["producten"])) {

    $product_ids = array_column($_SESSION["winkelwagen"]["producten"], 'id');
    $query = "SELECT p.id, p.naam as product_naam, p.prijs, m.naam as media_naam, m.pad as media_pad ".
        "FROM producten as p ".
        "JOIN product_media as pm on p.id=pm.product_id ".
        "JOIN media as m on m.id=pm.media_id ".
        "WHERE p.id IN ( ". implode(", ", $product_ids) . " ) ".
        "GROUP BY pm.product_id ";

    $result = $connection->query($query)->get();

    foreach($result as $row) {
        foreach ($_SESSION["winkelwagen"]["producten"] as $key => $product){
            if($product['id'] == $row['id']) {
                $_SESSION["winkelwagen"]["producten"][$key]["id"] = $row['id'];
                $_SESSION["winkelwagen"]["producten"][$key]["product_naam"] = $row['product_naam'];
                $_SESSION["winkelwagen"]["producten"][$key]["prijs"] = $row['prijs'];
                $_SESSION["winkelwagen"]["producten"][$key]["media_naam"] = $row['media_naam'];
                $_SESSION["winkelwagen"]["producten"][$key]["media_pad"] = $path_media.$row['media_pad'];
            }
        }
    }
}



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

// Testdata: Vul cart met een paar producten
// Todo: Remove before going to production
if (($_GET['addtocart']??false) == 1){
    $_SESSION['winkelwagen']['producten'] = [
        [
            "id" => 1,
            "product_name" => "Fender Stratocaster",
            "prijs" => 999.99,
            "media_naam" => "Gitaar Afbeelding",
            "media_pad" => "/afbeeldingen/gitaar.jpg",
            "hoeveelheid_in_winkelwagen" => 2,
        ],
        [
            "id" => 2,
            "naam" => "Taylor 214ce Akoestische Gitaar",
            "prijs" => 1499.99,
            "media_naam" => "Gitaar Afbeelding",
            "media_pad" => "/afbeeldingen/gitaar.jpg",
            "hoeveelheid_in_winkelwagen" => 2,
        ],
        [
            "id" => 3,
            "naam" => "Ibanez SR500 Basgitaar",
            "prijs" => 799.99,
            "media_naam" => "Gitaar Afbeelding",
            "media_pad" => "/afbeeldingen/gitaar.jpg",
            "hoeveelheid_in_winkelwagen" => 2,
        ],
        [
            "id" => 4,
            "naam" => "Marshall JVM410H Gitaarversterker",
            "prijs" => 1999.99,
            "media_naam" => "Gitaar Afbeelding",
            "media_pad" => "/afbeeldingen/gitaar.jpg",
            "hoeveelheid_in_winkelwagen" => 2,
        ],
        [
            "id" => 5,
            "naam" => "D'Addario EXL120 Snarenset",
            "prijs" => 9.99,
            "media_naam" => "Gitaar Afbeelding",
            "media_pad" => "/afbeeldingen/gitaar.jpg",
            "hoeveelheid_in_winkelwagen" => 2,
        ]
    ];
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