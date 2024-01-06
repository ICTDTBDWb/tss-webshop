<?php

/**
 * @return false|array
 */
function uitgelichteCategorieen(): false|array
{
    $db = new Database();
    $results = $db->query("SELECT * FROM categorieen where naam not like '%Giftboxen%' LIMIT 3")->get();
    $db->close();

    return $results === false ? [] : $results;
}

/**
 * @return array
 */
function recenteProducten(): array
{
    $recently_viewed = Session::get('recent_bekeken') ?? [];

    if (empty($recently_viewed)) {
        return [];
    }

    $placeholders = implode(',', array_fill(0, count($recently_viewed), '?'));

    $db = new Database();
    $results = $db->query("
        SELECT 
            p.id, p.naam, p.prijs, p.beschrijving,
            m.pad, m.extensie 
        FROM producten p
        LEFT JOIN media m on p.id = m.product_id
        WHERE p.id IN ($placeholders) AND p.is_actief = 1 AND p.is_verwijderd = 0 GROUP by p.id
    ", $recently_viewed)->get();
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
            p.id, p.naam, p.prijs, p.beschrijving,
            m.pad, m.extensie 
        FROM producten p
        LEFT JOIN media m on p.id = m.product_id
        WHERE p.is_actief = 1 AND p.is_verwijderd = 0 and not p.id in (select product_id from product_categorieen inner join categorieen on product_categorieen.categorie_id = categorieen.id and categorieen.naam like '%Giftboxen%') GROUP by p.id
        LIMIT 10
    ")->get();
    $db->close();

    return $results === false ? [] : $results;
}