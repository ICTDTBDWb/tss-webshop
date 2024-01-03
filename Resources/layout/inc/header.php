<?php
    global $auth;
?>

<header class="container-fluid h-fit px-4 d-flex justify-content-center shadow-sm bg-white">
    <div class="container-lg mx-auto py-3 row gx-0 items-center">
        <!--Logo-->
        <div class="col d-flex align-items-center">
            <a href="<?php echo str_contains($_SERVER['REQUEST_URI'], 'beheer') ? '/beheer/overzicht' : '/' ?>" class="text-decoration-none">
                <p class="m-0 fw-bold text-dark">
                    The Sixt String
                </p>
            </a>
        </div>

        <?php if (!str_contains($_SERVER["REQUEST_URI"], 'beheer')) { ?>
            <!--Zoekbalk-->
            <div class="col-6 d-flex justify-content-center d-none d-md-block">
                <form class="input-group" method="GET" action="/producten">
                    <input type="text" name="zoeken" id="header-search"
                           placeholder="Product zoeken."
                           aria-label="Product zoeken."
                           aria-describedby="addon-wrapping"
                           class="form-control border"
                           formmethod="post"

                    >
                    <button
                        value="producten-zoeken"
                        type="submit"
                        class="btn btn-outline-light border text-dark"
                    >
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>

            <!--Knoppen rechts-->
            <div class="col d-flex align-items-center justify-content-end">
                <button class="btn btn-link text-dark d-block d-md-none" type="button">
                    <i class="fa fa-search"></i>
                </button>
                <?php if (!$auth->isLoggedIn()) { ?>
                    <a href="/login" class="btn btn-link me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Inloggen">
                        <i class="fa fa-arrow-right-to-bracket fa-lg text-dark"></i>
                    </a>
                <?php } else { ?>
                    <a href="/account/overzicht" class="btn btn-link me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Profiel">
                        <i class="fa fa-user fa-lg text-dark"></i>
                    </a>
                <?php } ?>
                <a href="/winkelwagen" class="btn btn-link position-relative" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Winkelwagen">
                    <i class="fa fa-cart-shopping fa-lg text-dark"></i>
                    <?php if (Session::exists('winkelwagen')) { ?>
                            <span class="position-absolute start-100 translate-middle badge rounded-pill bg-light text-dark border" style="top: 5px;">
                                <?php echo count(Session::get('winkelwagen')['producten']); ?>
                            </span>
                    <?php } ?>
                </a>
            </div>
        <?php } ?>
    </div>
</header>