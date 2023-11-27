<?php

use App\Foundation\Support\Facades\Facade;
use App\Foundation\Support\Facades\Router;

// Boostrap the application.
$app = new \App\Foundation\Application();
$app->boot();

// Initialize the application facades.
Facade::clearResolvedInstances();
Facade::setFacadeApplication($app);

try {
    require 'app/routes.php';

    $uri = rtrim(parse_url($_SERVER['REQUEST_URI'])['path'], '/');
    $method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
    
    Router::handle($uri, $method);
} catch (\Exception $e) {
    echo ("Exception in _initRouter: " . $e->getMessage());

    header("HTTP/1.1 500 Internal Server Error");
    echo "An unexpected error occurred. Please try again later.";

    exit;
}