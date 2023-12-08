<?php


use \application\DatabaseManager;




function get_products($var)
{
    $var = "'%".$var."%'";
    $database = new DatabaseManager();
    $products = $database->query("SELECT * FROM producten where naam like". $var)->get();
    $database->close();
    return $products;
}


function encode($var)
{
    $var = "'". $var."'";
    return $var;
}

function create_buttons($var)
{
    try
    {
        $products = get_products($var);
        $button = '';
        foreach ($products as $item)
        {


            $button.= "<input type='button' value=".encode($item['naam'])."name='btn_".$item['id']."' id=".encode($item['id']).
                "class='button' /><br/>";
        }

        for ($i=50; $i< 800; $i++)
        {
            $button.= "<input type='button' value=".encode("test".$i)."name='btn_".$i."' id=".encode($i).
                "class='button' /><br/>";
        }
    }
    catch(\mysql_xdevapi\Exception $e )
    {
        $button = '';
    }

    return $button;
}


