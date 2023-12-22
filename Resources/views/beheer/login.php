<?php
    $auth = Auth::getInstance();

    if ($auth->isLoggedIn()) {
        header("Location: /beheer/overzicht");
    }

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if (isset($_POST['intent']) && !$_POST['intent'] == "admin_login") return;

        // Get the credentials from the POST and sanitize them before use.
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password']);

        // Try to log in the user with his credentials.
        if ($auth->attempt([$email, $password], true)){
            header("Location: /beheer/overzicht"); // If the credentials match we redirect back to the homepage.
        }
    }
?>

<div class="d-flex flex-grow-1 justify-content-center">
    <form
        id="user-loginForm" method="POST" action="/beheer/login"
        class="w-75 w-lg-50 d-flex flex-column gap-4"
    >
        <div>
            <label for="admin-emailInput">E-mail</label>
            <input
                id="admin-emailInput" name="email" type="text" placeholder="E-mail"
                class="form-control"
            >
        </div>

        <div>
            <label for="admin-passwordInput">Wachtwoord</label>
            <input
                id="admin-passwordInput" name="password" type="password" placeholder="Wachtwoord"
                class="form-control"
            >
        </div>

        <button
            name="intent" value="admin_login"
            class="btn btn-primary w-100"
        >
            Login
        </button>
    </form>
</div>