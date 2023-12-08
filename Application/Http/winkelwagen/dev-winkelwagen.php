<?php
include(__DIR__."/../../DatabaseManager.php");
session_start();
$connection = new \application\DatabaseManager();

//session_start();
//$hostname = "localhost:3308";
//$username = "root";
//$password = "root";
//$database = "tss";
//
//$connection = mysqli_connect($hostname, $username, $password, $database);

// hard coded true for testing
$path = "http://localhost/tss/public/winkelwagen";
$path_product = "http://localhost/tss/public/product";
//$path_media ="http://localhost/tss/public/winkelwagen";
$path_media ="/winkelwagen";

$placeholder = "/gitaar1.jpg";

//if(!$connection){
//    echo "Database connection failed";
//    exit;
//}
//


//$_SESSION["winkelwagen"]["producten"] = [];


//todo: validate id's, and perform check if product has been removed since last query

// Update session cart info with most recent data
if(isset($_SESSION["winkelwagen"]["producten"]) && count($_SESSION["winkelwagen"]["producten"])) {

    $product_ids = array_column($_SESSION["winkelwagen"]["producten"], 'id');
    $query = "SELECT p.id, p.naam as product_naam, p.prijs, m.naam as media_naam, m.pad as media_pad ".
        "FROM producten as p ".
        "JOIN product_media as pm on p.id=pm.product_id ".
        "JOIN media as m on m.id=pm.media_id ".
        "WHERE p.id IN ( ". implode(", ", $product_ids) . " ) ".
        "GROUP BY pm.product_id ";

//    var_dump(mysqli_query($connection, $query));exit;
//    $result = mysqli_execute_query($connection, $query);
    $result = $connection->query($query)->get();
//var_dump($result);exit;
//    while($row = mysqli_fetch_assoc($result)) {
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

$totaal_prijs = 0;


//hardcode logged in
$user_logged_in = $_SESSION['user']['logged_in']??true;

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

$count_post = count($_POST);
// check of wijzigingen opslaan is gebruikt en of er producten post zitten.
if(isset($_POST['wijzigingen_opslaan']) && $count_post > 1){

    //unset wijzigingen opslaan, nu zijn de rest van de array opties een "[product_id]_[hoeveelheid]" string.
    unset($_POST['wijzigingen_opslaan']);

//    $id = filter_input(INPUT_POST, 'remove_product', FILTER_SANITIZE_NUMBER_INT);

    //check if there are products
    $producten = $_SESSION["winkelwagen"]["producten"]??false;

    foreach($_POST as $id => $quantity){
//        list($id, $quantity) = explode("_", $id_quantity,2);
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
            // Als ID of Quantity geen nummer zijn, dan zijn deze handmatig bewerkt.
            echo "Error: Id, Quantity not numeric or no products in cart.";
            var_dump($_POST);
            exit;
        }
    }
}




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
//    $_SESSION["winkelwagen"]['producten'] = [
//        [
//            "name" => "Laptop",
//            "price" => 999.99,
//            "image_src" => $path. $placeholder,
//            "id" => "1",
//            "hoeveelheid_in_winkelwagen" => "1",
//            "product_url" => $path_product."/1",
//        ],
//        [
//            "name" => "Smartphone",
//            "price" => 599.50,
//            "image_src" =>$path.  $placeholder,
//            "id" => "2",
//            "hoeveelheid_in_winkelwagen" => "2",
//            "product_url" => $path_product."/2",
//        ],
//        [
//            "name" => "Headphones",
//            "price" => 89.95,
//            "image_src" =>$path.  $placeholder,
//            "id" => "3",
//            "hoeveelheid_in_winkelwagen" => "1",
//            "product_url" => $path_product."/3",
//        ],
//        [
//            "name" => "Camera",
//            "price" => 449.00,
//            "image_src" =>$path.  $placeholder,
//            "id" => "4",
//            "hoeveelheid_in_winkelwagen" => "3",
//            "product_url" => $path_product."/4",
//        ],
//        [
//            "name" => "Tablet",
//            "price" => 349.75,
//            "image_src" =>$path.  $placeholder,
//            "id" => "5",
//            "hoeveelheid_in_winkelwagen" => "1",
//            "product_url" => $path_product."/5",
//        ]
//    ];
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

//mysqli_close($connection);
?>