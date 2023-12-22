<?php
// PHP code om het geselecteerde navigatie-item te bepalen
?>

<head>
    <!-- Andere head-elementen -->
    <style>
        /* Stijl voor het geselecteerde navigatie-item */
        .navbar-nav .nav-item.active .nav-link {
            color: blue; /* Kies hier de gewenste kleur */
        }

        /* Stijl voor de grijze knoppen */
        .navbar-nav .nav-item .nav-link {
            background-color: lightgray; /* Grijze achtergrondkleur */
            color: black; /* Witte tekstkleur */
            margin-right: 30px; /* Voeg wat ruimte tussen de knoppen toe */
            padding: 10px 15px; /* Binnenste vulling van de knoppen */
            border-radius: 5px; /* Afgeronde hoeken */
        }


    </style>
</head>

<div class="container" style="text-align: center;">
    <!-- Navigatiebalk met Bootstrap-styling zonder witte achtergrond -->
    <nav class="navbar navbar-expand-lg navbar-light" style="display: inline-block;">
        <!-- Knop voor mobiel menu -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php
        // Haal de naam van het huidige script op
        $current_page = basename($_SERVER['PHP_SELF']);
        ?>

        <!-- Navigatiemenu-items -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item <?php echo ($current_page == 'overzicht.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="/account/overzicht">Accountoverzicht</a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'bestellingen.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="/account/bestellingen">Bestellingen</a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'cadeaubonnen.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="/account/cadeaubonnen">Cadeaubonnen/Giftboxen</a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'klantgegevens.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="/account/klantgegevens">Klantgegevens aanpassen</a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'uitloggen.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="uitloggen">Uitloggen</a>
                </li>
            </ul>
        </div>
    </nav>
</div>
