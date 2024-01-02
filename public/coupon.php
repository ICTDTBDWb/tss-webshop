<?php
$coupon_result_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include("../Application/Database.php");
    session_start();
    $dbm = new Database();
    $coupon_result_message = "";

    $code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_SPECIAL_CHARS);
    $pin = filter_input(INPUT_POST, 'pin', FILTER_SANITIZE_SPECIAL_CHARS);
    $bedrag = filter_input(INPUT_POST, 'bedrag', FILTER_VALIDATE_FLOAT);
    $method = filter_input(INPUT_POST, 'method', FILTER_SANITIZE_SPECIAL_CHARS);

    $query = "SELECT code, pin, bedrag FROM cadeaubonnen WHERE code=:code AND pin=:pin;";


    // TODO: Zet in functie
    if($method == "remove") {
        if(isset($_SESSION['winkelwagen']['cadeaubonnen'])) {
            foreach($_SESSION['winkelwagen']['cadeaubonnen'] as $key => $coupon) {
                if($coupon['code'] == $code) {
                    unset($_SESSION['winkelwagen']['cadeaubonnen'][$key]);
                    http_response_code(200);
                    $coupon_result_message = '<div class="alert alert-success mt-3" role="alert">Cadeaubon is succesvol verwijderd uit de winkelwagen.</div>';
                    echo $coupon_result_message;
                    exit;
                }

            }
        }
        http_response_code(400);
        $coupon_result_message = '<div class="alert alert-danger mt-3" role="alert">Er is iets mis gegaan.</div>';
        echo $coupon_result_message;
        exit;

    }


    // TODO: Zet in add functie
    if($method == "add") {
        $result = $dbm->query($query, ["code" => $code, "pin" => $pin])->first();

        if($result) {
            if($result['bedrag'] < $bedrag) {
                $isValid = false;
                http_response_code(400 );
                $coupon_result_message = '<div class="alert alert-danger mt-3" role="alert">Niet voldoende saldo.</div>';
            } else {
                $isValid = true;
            }
        } else {
            http_response_code(400 );
            $coupon_result_message = '<div class="alert alert-danger mt-3" role="alert">Coupon is niet geldig.</div>';
            $isValid = false;
        }

        if ($isValid) {
                if (!isset($_SESSION['winkelwagen']['cadeaubonnen'])) {
                $_SESSION['winkelwagen']['cadeaubonnen'] = [];
            }

            // Controleer of de code niet al in de sessie staat
            $existingCodes = array_column($_SESSION['winkelwagen']['cadeaubonnen'], 'code');
            if (!in_array($code, $existingCodes)) {
                $_SESSION['winkelwagen']['cadeaubonnen'][] = [
                'code' => $code,
                'pin' => $pin,
                'bedrag' => $bedrag
                ];
                http_response_code(200);
                $coupon_result_message = '<div class="alert alert-success mt-3" role="alert">Cadeaubon is succesvol toegevoegd aan de winkelwagen.</div>';
            } else {
                http_response_code(400 );
                $coupon_result_message = '<div class="alert alert-danger mt-3" role="alert">Deze cadeauboncode bestaat al in de winkelwagen.</div>';
            }
        }
    }
}
echo $coupon_result_message;
?>