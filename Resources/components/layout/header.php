<?php
    global $session;
?>
<header class="container-fluid h-fit px-4 d-flex justify-content-center shadow-sm bg-white">
    <div class="container-lg mx-auto py-3 row gx-0 items-center">
        <!--Logo-->
        <div class="col d-flex align-items-center">
            <a href="/" class="text-decoration-none">
                <p class="m-0 fw-bold text-dark">
                    The Sixt String
                </p>
            </a>
        </div>

        <!--Zoekbalk-->
        <div class="col-6 d-flex justify-content-center d-none d-md-block">
            <div class="input-group">
                <input type="text" name="search" id="header-search"
                       placeholder="Product zoeken."
                       aria-label="Product zoeken."
                       aria-describedby="addon-wrapping"
                       class="form-control border"
                >
                <button class="btn btn-outline-light border text-dark" type="button">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>

        <!--Knoppen rechts-->
        <div class="col d-flex align-items-center justify-content-end">
            <button class="btn btn-link text-dark d-block d-md-none" type="button">
                <i class="fa fa-search"></i>
            </button>
            <?php if (empty($_SESSION['logged-in'])) { ?>
                <a href="/login.php" class="btn btn-link me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Inloggen">
                    <i class="fa fa-arrow-right-to-bracket fa-lg text-dark"></i>
                </a>
            <?php } else { ?>
                <a href="/profiel.php" class="btn btn-link me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Profiel">
                    <i class="fa fa-user fa-lg text-dark"></i>
                </a>
            <?php } ?>
            <a href="/winkelwagen.php" class="btn btn-link position-relative" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Winkelwagen">
                <i class="fa fa-cart-shopping fa-lg text-dark"></i>
                <?php if ($session->exists('winkelwagen.producten')) { ?>
                        <span class="position-absolute start-100 translate-middle badge rounded-pill bg-light text-dark border" style="top: 5px;">
                            <?php echo count($session->get('winkelwage.producten')); ?>
                        </span>
                <?php } ?>
            </a>
        </div>
    </div>
</header>
