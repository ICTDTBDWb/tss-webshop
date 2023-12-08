







<!DOCTYPE html>

<style>
    .button
    {
        width: 100%;
        margin-outside: 1%;
    }

</style>

<div class="accordion" id="accordionPanelsStayOpenExample">

    <?php echo get_arcordion_items() ?>




</div>


<?php

//include __DIR__ . "/../../application/DatabaseManager.php";
//include __DIR__ . "/../../application/account/models.php";
use \application\DatabaseManager;

$filter = "%%";
if (is_array($_POST) && !empty($_POST)) {

    var_dump($_POST);
    //echo ("<script>alert('$test');</script>");
}


function arcordion_constructer($categorieen)
    {
        $contruct = "";
        foreach ($categorieen as $categorie) {
            $contruct .= "<div class='accordion-item'>
                            <h2 class='accordion-header' id=".encode("accordion-header".$categorie['id']).">
                                <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target=" . encode("#accordion-collapse" . $categorie['id']) . " aria-expanded='false' aria-controls=".encode("accordion-collapse" . $categorie['id']). ">"
                                    . $categorie['naam'] .
                                "</button>
                            </h2>"
                            . arcordion_item_constructor($categorie,false, )." 
                        </div>";
        }

        $producten = get_overige_producten();
        if(!empty($producten))
        {
            $contruct .= "<div class='accordion-item'>
                            <h2 class='accordion-header' id=".encode("accordion-headeroverig").">
                                <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#accordion-collapseoverig' aria-expanded='false' aria-controls='accordion-collapseoverig'>"
                                    . "Overig" .
                                "</button>                          
                            </h2>"
                                . arcordion_item_constructor($producten, true,)." 
                         </div>";
        }



        return $contruct;
    }

    function arcordion_item_constructor($categorie,$overig,)
    {
        if (!$overig) {
            $ID = $categorie['id'];
            $producten = get_producten($categorie['id']);
        }
        else {
            $ID = "overig";
            $producten = $categorie;
        }


        $contruct = "<div id=".encode("accordion-collapse".$ID)."class='accordion-collapse collapse ' aria-labelledby=".encode("accordion-header".$ID).">
                            <div class='accordion-body'>";

        if(empty($producten))
        {
            $contruct .= "<strong></strong>";
        }

        foreach($producten as $product)
        {
            $contruct .= "<form action='' method='get'> 
                            <button class='btn btn-light' style='width: 100%; margin-top: 2%' id=".encode("btn_product_".$product['id'])." name='Product' value=".encode($product['id']).">
                                <strong>".$product['naam']."</strong>
                            </button>
                          </form>";


        }

        $contruct .= "</div>
                     </div>";

        return $contruct;
    }

    function get_arcordion_items()
    {
        $categorieen = get_categorieen();
        return arcordion_constructer($categorieen);
    }

    function get_categorieen()
    {
        $database = new DatabaseManager();
        $categorieen = $database->query("SELECT * FROM categorieen ORDER BY id ASC")->get();
        $database->close();
        return $categorieen;
    }

    function get_producten($categorie_id)
    {
        $filter = $_SESSION['POST_FILTER_BEHEERITEM'];
        if (is_array($_POST) && !empty($_POST))
            $filter = filter_input(INPUT_POST,'filter', FILTER_SANITIZE_SPECIAL_CHARS );

        $database = new DatabaseManager();
        $producten = $database->query("SELECT * FROM producten inner join product_categorieen where product_id = producten.id and categorie_id  = ? and naam like ? ORDER BY naam ASC", [$categorie_id, "%".$filter."%"] )->get();
        $database->close();

        return $producten;
    }

    function get_overige_producten()
    {
        $database = new DatabaseManager();
        $producten = $database->query("SELECT * FROM producten WHERE NOT EXISTS ( SELECT * FROM product_categorieen where product_categorieen.product_id = producten.id) ORDER BY naam ASC ")->get();
        $database->close();

        return $producten;
    }

?>