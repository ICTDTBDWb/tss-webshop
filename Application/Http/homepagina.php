<?php

/**
 * @return false|array
 */
function uitgelichteCategorieen(): false|array
{
    $db = new Database();
    $results = $db->query("SELECT * FROM categorieen LIMIT 3")->get();
    $db->close();

    return $results === false ? [] : $results;
}

function aanbevolenProducten()
{
    $db = new Database();
    $results = $db->query("SELECT * FROM producten LIMIT 10")->get();
    $db->close();

    return $results === false ? [] : $results;
}