<?php
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

        // TODO: Handle errors.
    }
?>

<form
    id="user-loginForm" method="POST" action="/login"
    class="d-flex flex-column gap-4 w-50"
>
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
</form>