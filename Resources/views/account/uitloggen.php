<?php
require_once('/var/www/tss-webshop/Application/Session.php');



function logout() {
    // Start de sessie
    session_start();


    // Authenticatie uit de sessie halen
    unset($_SESSION['auth']['logged_in'],$_SESSION['auth']['user_id']);

    // Omleiden naar de inlogpagina
    header("Location:/");
    exit;
}


logout();

?>