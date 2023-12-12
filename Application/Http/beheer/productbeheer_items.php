







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

//include __DIR__ . "/../../Application/DatabaseManager.php";

use \application\DatabaseManager;


$filter = "%%";
if (is_array($_POST) && !empty($_POST)) {

    var_dump($_POST);
    //echo ("<script>alert('$test');</script>");
}




function arcordion_constructer($categorieen)
    {


        $show_categorie = "collapsed";
        $show_product = "collapse";
        if (is_array($_GET) && !empty($_GET['Product'])) {
            $product = filter_input(INPUT_GET, 'Product', FILTER_SANITIZE_SPECIAL_CHARS);
            $product = preg_split("/ /", $product);
            var_dump($product);
        }

        $contruct = "";
        foreach ($categorieen as $categorie) {

            if (!empty($product[1]) && $categorie['id'] == $product[1])
            {
                $show_categorie = "collapsed";
                $show_product = "collapse";
            }
            else
            {
                $show_categorie = "collapsed";
                $show_product = "collapse";
            }


            $contruct .= "<div class='accordion-item'>
                            <h2 class='accordion-header' id=".encode("accordion-header".$categorie['id']).">
                                <button class='accordion-button $show_categorie ' type='button' data-bs-toggle='collapse' data-bs-target=" . encode("#accordion-collapse" . $categorie['id']) . " aria-expanded='false' aria-controls=".encode("accordion-collapse" . $categorie['id']). ">"
                                    . $categorie['naam'] .
                                "</button>
                            </h2>"
                            . arcordion_item_constructor($categorie,false,  $show_product)." 
                        </div>";
        }

        $producten = get_overige_producten();

            if (!empty($product[1]) && "overig" == strtolower($product[1]))
            {
                $show_categorie = "";
                $show_product = "collapse show";
            }
            else
            {
                $show_categorie = "collapsed";
                $show_product = "collapse";
            }


            $contruct .= "<div class='accordion-item'>
                            <h2 class='accordion-header' id=".encode("accordion-headeroverig").">
                                <button class='accordion-button $show_categorie' type='button' data-bs-toggle='collapse' data-bs-target='#accordion-collapseoverig' aria-expanded='false' aria-controls='accordion-collapseoverig'>"
                                    . "Overig" .
                                "</button>                          
                            </h2>"
                                . arcordion_item_constructor($producten, true,  $show_product)." 
                         </div>";




        return $contruct;
    }

    function arcordion_item_constructor($categorie,$overig,$show)
    {
        if (!$overig) {
            $ID = $categorie['id'];
            $producten = get_producten($categorie['id']);
        }
        else {
            $ID = "overig";
            $producten = $categorie;
        }


        $contruct = "<div id=".encode("accordion-collapse".$ID)."class='accordion-collapse $show ' aria-labelledby=".encode("accordion-header".$ID).">
                            <div class='accordion-body'>";

        if(empty($producten))
        {
            $contruct .= "<strong></strong>";
        }

        foreach($producten as $product)
        {
            $contruct .= "
                            <button class='btn btn-light' style='width: 100%; margin-top: 2%' id=".encode("btn_product_".$product['id'])." name='Product' value=".encode($product['id']." ".$ID).">
                                <strong>".$product['naam']."</strong>
                            </button>
                          ";


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

        if (is_array($_GET) && !empty($_GET))
            $filter = filter_input(INPUT_GET,'filter', FILTER_SANITIZE_SPECIAL_CHARS );

        $database = new DatabaseManager();
        $producten = $database->query("SELECT * FROM producten inner join product_categorieen where product_id = producten.id and categorie_id  = ? and naam like ? ORDER BY naam ASC", [$categorie_id, "%".$filter."%"] )->get();
        $database->close();

        return $producten;
    }

    function get_overige_producten()
    {
        if (is_array($_GET) && !empty($_GET))
            $filter = filter_input(INPUT_GET,'filter', FILTER_SANITIZE_SPECIAL_CHARS );

        $database = new DatabaseManager();
        $producten = $database->query("SELECT * FROM producten WHERE naam like ? and NOT EXISTS ( SELECT * FROM product_categorieen where product_categorieen.product_id = producten.id) ORDER BY naam ASC " , ["%".$filter."%"])->get();
        $database->close();

        return $producten;
    }

?>