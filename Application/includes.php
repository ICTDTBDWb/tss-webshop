<?php

require_once(basePath("Application/Session.php"));
require_once(basePath("Application/Database.php"));
require_once(basePath("Application/Auth.php"));

$auth = Auth::getInstance();

if ($page === "producten_detail" && $params !== null)
{
    parse_str($params, $paramsArray);

    $session_items = Session::get("recent_bekeken") ?? [];

    $session_items = array_unique($session_items);
    count($session_items) > 5
        ? array_shift($session_items)
        : array_push($session_items, $paramsArray['id']);

    Session::set("recent_bekeken", $session_items);
}