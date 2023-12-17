<?php
require_once('/var/www/tss-webshop/Application/Session.php');



function logout() {
    // Start de sessie
    session_start();

    // Wis de sessiegegevens
    $_SESSION = array();

    // Vernietig de sessie
    session_destroy();

    // Omleiden naar de inlogpagina
    header("Location:/var/www/tss-webshop//public.index.php");
    exit();
}





?>