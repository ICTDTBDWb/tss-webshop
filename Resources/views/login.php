<?php
    $error = false;
    $auth = Auth::getInstance();

    if ($auth->isLoggedIn()) {
        header("Location: /");
    }

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if (isset($_POST['intent']) && !$_POST['intent'] == "user_login") return;

        // Get the credentials from the POST and sanitize them before use.
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password']);

        // Try to log in the user with his credentials.
        if ($auth->attempt([$email, $password])){
            header("Location: /"); // If the credentials match we redirect back to the homepage.
        }

        $error = true;
    }
?>

<div class="d-flex flex-grow-1 justify-content-center">
    <form
            id="user-loginForm" method="POST" action="/login"
            class="w-75 w-lg-50 d-flex flex-column gap-4"
    >
        <?php if ($error) { ?>
            <div class="alert alert-danger" role="alert">
                De ingevoerde gegevens zijn onjuist!
            </div>
        <?php } ?>

        <div>
            <label for="user-emailInput">E-mail</label>
            <input
                    id="user-emailInput" name="email" type="text" placeholder="E-mail"
                    class="form-control"
            >
        </div>

        <div>
            <label for="user-passwordInput">Wachtwoord</label>
            <input
                    id="user-passwordInput" name="password" type="password" placeholder="Wachtwoord"
                    class="form-control"
            >
        </div>

        <button
                name="intent" value="user_login"
                class="btn btn-primary w-100"
        >
            Login
        </button>
        <a
                href="/klant_account_aanmaken"
                class="btn btn-primary w-100"
        >
            Registreren
        </a>
    </form>
</div>