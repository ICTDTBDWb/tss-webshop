<?php

Global $verwijder_icon;
$verwijder_icon = "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' >
                               <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z'></path>
                               <path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z'></path>
                       </svg>";
Global $edit_icon;
$edit_icon  = "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' >
                        <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                    </svg>";






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
        global $edit_icon;
        global $verwijder_icon;
        $categorie_id = $item['id'];
        $categorie_naam = $item['naam'];
        $construct.= "
                        <div class='form-check'>
                            <input class='form-check-input' type='checkbox' name='checkbox_$categorie_id'  id='checkbox_$categorie_id' $checked>
                                <label class='form-check-label' for='checkbox_$categorie_id' style='max-width: 60%; min-width:60%'>
                                $categorie_naam
                            </label>
                           
                         <div class='btn-group' role='group' aria-label='area_$categorie_id' style='height: 4vh; width:2vh' >
                                <button type='button' class='btn btn-outline-primary '  data-bs-toggle='modal' data-bs-target='#categorieaanpassen_$categorie_id'>
                                   $edit_icon
                                </button>
                                <button type='button' class='btn btn-outline-danger' data-bs-toggle='modal' data-bs-target='#categorieverwijder_$categorie_id'>
                                   $verwijder_icon
                                </button>
                            </div>
                      </div>";


    }


    return $construct;

}

function modal_verwijder_categorie($categorie)
{
    $begin_modal= "    <form method='POST' ACTION=''>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title'>Categorie Verwijderen</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='sluiten'></button>
                                </div>
                             <div class='modal-body'>";
   $einde_modal = "          </div>
                             <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Annuleren</button>
                                <button type='submit' class='btn btn-danger' name='opslaan' value='categorie_verwijderen' >verwijderen</button>
                            </div>
                         </div>
                      </div>
                      </form>
                 </div>";

   $construct = "";
   foreach($categorie as $key => $item)
   {
       $producten = "";
       foreach ($item['product'] as $value)
       {
           $naam = $value['naam'];
           $producten .= "<p class='text-center' class> $naam </p> ";
       }


       $inner_text = $producten != "" ? "de volgende producten zijn gelinkt aan de categorie" : "";

       $text = " <div class='mb-3'>
                    <input type='hidden' value='$key' name='categorie_id'> 
                    <p class='text-center fw-bold'> weet u zeker dat u categorie wilt verwijderen? $inner_text</p><br>
                    $producten
                </div>";



       $title = "<div class='modal fade' tabindex='-1' id='categorieverwijder_$key' >";



       $construct .= $title.$begin_modal.$text.$einde_modal;
   }
     return $construct;
}


function modal_edit_categorie($categorie)
{
    $begin_modal= "    <form method='POST' ACTION=''>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title'>Categorie Aanpassen</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='sluiten'></button>
                                </div>
                             <div class='modal-body'>";
    $einde_modal = "          </div>
                             <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Annuleren</button>
                                <button type='submit' class='btn btn-primary' name='opslaan' value='wijzig_categorie'>OK</button>
                            </div>
                         </div>
                      </div>
                      </form>
                 </div>";
    $construct = "";
    foreach($categorie as $key => $item) {
        $categorie_naam = $item['naam'];
        $categorie_beschrijving = $item['beschrijving'];
        $title = "<div class='modal fade' tabindex='-1' id='categorieaanpassen_$key' >";
        $body = "<div class='mb-3'>
                    <input type='hidden' value='$key' name='categorie_id'>
                    <label for='categorie_naam' class='form-label'>Categorie Naam</label>
                    <input type='text' class='form-control' id='categorie_naam' name='categorie_naam'  value='$categorie_naam'>
                    <label for='categorie_beschrijving' class='form-label'>Categorie beschrijving</label>
                    <textarea class='form-control' id='categorie_beschrijving' aria-label='With textarea' name='categorie_beschrijving' style='resize: none; height: 10vh' >$categorie_beschrijving</textarea>
                 </div> ";

        $construct .= $title.$begin_modal.$body.$einde_modal;
    }

    return $construct;
}

function make_option_list($options)
{
    $construct = "";
    foreach($options as $item)
    {
        $merk = $item["merk"];
        $construct .= "<option value='$merk'>";
    }
   return $construct;
}



