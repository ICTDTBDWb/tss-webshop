<?php

use App\Foundation\Support\Facades\Router;

Router::get('/welkom', static function () {
    print("working");
    exit;
});