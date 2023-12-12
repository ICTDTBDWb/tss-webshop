<?php

// Update winkelwagen sessie informatie met up-to-date data
// Hierdoor blijven hoeveelheden intact
/**
 * Updates product information in session to product information in database.
 * And checks for potentially removed products in database, and removes these from session.
 *
 * Returns array with products that have been removed or changed.
 *
 * @param \application\DatabaseManager $databaseManager
 * @return array[
 *  'removed_products' =>  [],
 *  'changed_products' => [],
 * ]
 */
function updateSessionCartProducts(\application\DatabaseManager $databaseManager) {
    $path_media ="/winkelwagen";

    $return = [
        'removed_products' =>  [],
        'changed_products' => [],
    ];
    if(isset($_SESSION["winkelwagen"]["producten"]) && count($_SESSION["winkelwagen"]["producten"])) {

//        $_SESSION["winkelwagen"]["producten"][100]['id'] = 66;

        $product_ids = array_column($_SESSION["winkelwagen"]["producten"], 'id');
        $query = "SELECT p.id, p.naam as product_naam, p.prijs, m.naam as media_naam, m.pad as media_pad ".
            "FROM producten as p ".
            "JOIN product_media as pm on p.id=pm.product_id ".
            "JOIN media as m on m.id=pm.media_id ".
            "WHERE p.id IN ( ". implode(", ", $product_ids) . " ) ".
            "GROUP BY pm.product_id ";

        $result = $databaseManager->query($query)->get();


        // Producten in dit array zijn verwijderd in de database tussen cart updates
        $products_deleted_from_database = array_diff_assoc($product_ids, array_column($result, 'id'));
//        echo"<pre>";
//        var_dump($_SESSION);exit;

        foreach($result as $row) {
            foreach ($_SESSION["winkelwagen"]["producten"] as $key => $product) {
                if (in_array($product['id'],$products_deleted_from_database)) {
                    $return['removed_products'][] = $product;
                    unset($_SESSION["winkelwagen"]["producten"][$key]);
                    continue;
                }

                if(
                    $product['id'] == $row['id'] &&
                    //array diff hoger dan 1, omdat hoeveelheid in winkelwagen altijd anders is dan in database
                    count(array_diff_assoc($product, $row)) > 1
                ) {
                    $return['changed_products'][] = $_SESSION["winkelwagen"]["producten"][$key];
                    $_SESSION["winkelwagen"]["producten"][$key]["id"] = $row['id'];
                    $_SESSION["winkelwagen"]["producten"][$key]["product_naam"] = $row['product_naam'];
                    $_SESSION["winkelwagen"]["producten"][$key]["prijs"] = $row['prijs'];
                    $_SESSION["winkelwagen"]["producten"][$key]["media_naam"] = $row['media_naam'];
                    $_SESSION["winkelwagen"]["producten"][$key]["media_pad"] = $path_media.$row['media_pad'];
                }
            }
        }
    }
    return $return;

}

function getTotalFromCurrentCart(){
    $totaal = 0;
    if( isset($_SESSION['winkelwagen']['producten']) &&
        count($_SESSION['winkelwagen']['producten'])
    ) {
        foreach ($_SESSION["winkelwagen"]["producten"] as $key => $product) {
                $totaal += $_SESSION["winkelwagen"]["producten"][$key]["prijs"]*$_SESSION["winkelwagen"]["producten"][$key]["hoeveelheid_in_winkelwagen"];
        }
    }
    return $totaal;
}