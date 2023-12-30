<?php

function basePath($path): string { return __DIR__ . "/../$path"; }

session_start();

/**
 * Trim / at the start and end of the request URI. If it is empty, default to "homepagina".
 * If the current page contains "beheer" set it to "beheer/overzicht" instead.
 * Retrieve parameters from the request URI if there are any.
 */
$uri = trim($_SERVER["REQUEST_URI"], "/");
list($page, $params) = explode('?', $uri) + [null, null];
$page = $page ?: "homepagina";
$page = ($page == "beheer") ? "beheer/overzicht" : $page;

// Require the base includes for every file.
require_once basePath('Application/includes.php');

// Check if the logic file exist and include it.
if (file_exists($logic_file = basePath("Application/Http/$page.php"))) require_once $logic_file;

// Check if the current view exists else show the 404 page.
$content_file = basePath("Resources/views/$page.php");
$content = file_exists($content_file) ? $content_file : basePath("Resources/views/errors/404.php");

// Require the base page layout.
require_once basePath("Resources/layout/layout.php");
