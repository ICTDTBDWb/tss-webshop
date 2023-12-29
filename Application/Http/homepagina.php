<?php

function uitgelichteCategorieen()
{
    $db = new Database();
    $results = $db->query("SELECT * FROM categorieen LIMIT 3")->get();
    $db->close();

    return $results;
}