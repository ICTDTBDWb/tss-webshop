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

/**
 * @return array
 */
function aanbevolenProducten(): array
{
    $db = new Database();
    $results = $db->query("
        SELECT 
            p.id, p.naam, p.prijs, p.omschrijving,
            m.pad, m.extensie 
        FROM producten p
        LEFT JOIN media m on p.id = m.product_id
        LIMIT 10
    ")->get();
    $db->close();

    return $results === false ? [] : $results;
}