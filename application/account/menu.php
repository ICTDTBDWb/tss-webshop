<?php
// PHP code om het geselecteerde navigatie-item te bepalen
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="container" style="text-align: center;">
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="display: inline-block;">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                    <a class="nav-link mr-3" href="index.php">Accountoverzicht</a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'bestellingen.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="bestellingen.php">Bestellingen</a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'cadeaubonnen.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="cadeaubonnen.php">Cadeaubonnen/Giftboxen</a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'klantgegevens.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="klantgegevens.php">Klantgegevens aanpassen</a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'uitloggen.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="uitloggen.php">Uitloggen</a>
                </li>
            </ul>
        </div>
    </nav>
</div>
