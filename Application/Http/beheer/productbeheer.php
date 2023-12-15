<?php



//make arcordion header
function arcordion_constructer($categorieen)
{

    $contruct = "";
    foreach ($categorieen as $key => $categorie) {


        $show_categorie = $categorie['show'];
        $naam_categorie = $categorie['naam'];


        $contruct .= "<div class='accordion-item'>
                            <h2 class='accordion-header' id='accordion-header_$key'>
                                <button class='accordion-button $show_categorie ' type='button' data-bs-toggle='collapse' data-bs-target='#accordion-collapse_$key' aria-expanded='false' aria-controls='accordion-collapse_$key' >
                                    $naam_categorie
                                </button>
                            </h2>"
            . arcordion_item_constructor($categorie['product'], $key, $show_categorie )." 
                        </div>";
    }

    return $contruct;
}

//make arcordion items
function arcordion_item_constructor($categorie, $key, $show )
{

    $show_categorie = $show != "" ? "" : "show";
    $contruct = "<div id='accordion-collapse_$key' class='accordion-collapse collapse $show_categorie ' aria-labelledby='accordion-header_$key' >
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

    $contruct .= "        </div>
                     </div>";


    return $contruct;
}


function checkbox_constructor($categorie, $product)
{

    $construct = "";
    //check if categorie needs to be checked
    foreach ($categorie as $item)
    {


        $checked = "";
        if (array_key_exists("0", $product))
        {
            foreach ($product[0]['categorie'] as $value)
            {
                $checked = $value['naam'] == $item['naam'] ? "checked" : "";
                if ($checked != "")
                    break;
            }
        }

        //<input class='form-check-input' type='hidden' name='checkbox_$categorie_id' value='off'  id='checkbox_$categorie_id'>
        $categorie_id = $item['id'];
        $categorie_naam = $item['naam'];
        $construct.= "<div class='form-check'>
                        <input class='form-check-input' type='checkbox' name='checkbox_$categorie_id'  id='checkbox_$categorie_id' $checked>
                        <label class='form-check-label' for='checkbox_$categorie_id'>
                            $categorie_naam
                        </label>
                      </div>";


    }


    return $construct;

}








