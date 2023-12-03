<?php

use \application\DatabaseManager;

//function test() {
//    $database = new DatabaseManager();
//    $klanten = $database->query("SELECT * FROM klanten WHERE id = ? AND ?", [2, 1])->get();
//
//    $database->close();
//}

function getCustomers() {
    $database = new DatabaseManager();
    $klanten = $database->query("SELECT * FROM klanten")->get();
    $database->close();

    return $klanten;
}