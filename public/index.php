<?php
function basePath($path): string { return __DIR__ . "/../$path"; }

// Start the browser session.
session_start();

// Trim / at the start of the request URI. If it is empty default to "homepagina".
$uri = trim($_SERVER["REQUEST_URI"], "/");
$page = (empty($uri) ? "homepagina" : ($uri == "beheer" ? "beheer/overzicht" : $uri));
$url = explode('?', $page);
$page = $url[0];
$params = $url[1] ?? "";

// Include the base imports.
require_once basePath('Application/includes.php');

// Include the PHP file containing the view logic if it exists.
if (file_exists($logic_file = basePath("Application/Http/$page.php"))) {
    require_once $logic_file;
}

// Get the path to the page view and include the variable inside the layout.
if (!file_exists($content = basePath("Resources/views/$page.php"))) {
    $content = basePath("Resources/views/errors/404.php");
}

// Include the base layout using the __DIR__ constant
require_once basePath("Resources/layout/layout.php");