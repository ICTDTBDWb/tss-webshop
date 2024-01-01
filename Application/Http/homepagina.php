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
        WHERE p.id IN ($placeholders) AND p.is_actief = 1 AND p.is_verwijderd = 0
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
        WHERE p.is_actief = 1 AND p.is_verwijderd = 0
        LIMIT 10
    ")->get();
    $db->close();

    return $results === false ? [] : $results;
}