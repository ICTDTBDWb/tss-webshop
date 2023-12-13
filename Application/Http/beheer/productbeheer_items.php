







<!DOCTYPE html>

<style>
    .button
    {
        width: 100%;
        margin-outside: 1%;
    }

</style>



<?php


function arcordion_constructer($categorieen)
{

    $contruct = "";
    foreach ($categorieen as $key => $categorie) {

        $show_categorie = $categorie['show'];


        $contruct .= "<div class='accordion-item'>
                            <h2 class='accordion-header' id='accordion-header_$key'>
                                <button class='accordion-button $show_categorie ' type='button' data-bs-toggle='collapse' data-bs-target='#accordion-collapse_$key' aria-expanded='false' aria-controls='accordion-collapse_$key' >
                                    $key
                                </button>
                            </h2>"
                                . arcordion_item_constructor($categorie, $key)." 
                        </div>";
    }

    return $contruct;
}


    function arcordion_item_constructor($categorie, $key)
    {
        $show_categorie = $categorie['show'];
        $contruct = "<div id='accordion-collapse_$key' class='accordion-collapse $show_categorie ' aria-labelledby='accordion-header_$key' >
                            <div class='accordion-body'>";


        foreach ($categorie as $_key => $product) {

                if(is_array($product)) {
                    $product_naam = $product['naam'];
                    $product_id = $product['id'];
                    $contruct .= "
                            <button class='btn btn-light' style='width: 100%; margin-top: 2%' id='btn_product_$product_id' name='Product' value='$product_id $key'>
                                <strong>$product_naam</strong>
                            </button>
                          ";
                }
                else
                    $contruct .= "<strong></strong>";

        }



            $contruct .= "</div>
                     </div>";


        return $contruct;
    }






?>