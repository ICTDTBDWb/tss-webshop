<?php
    $categorieen = uitgelichteCategorieen();
    $recente_producten = recenteProducten();
?>

<!--Banner-->
<section class="row gx-0 mb-5">
    <a href="/categorieen?id=<?php echo $categorieen[0]['id'] ?>" class="col-7 col-sm-8 pe-2 text-decoration-none">
        <div
            class="w-100 h-100 position-relative d-flex align-items-center justify-content-center text-white rounded"
            style="
                background-image: url('/assets/afbeeldingen/guitar1.jpg');
                background-size: contain;
                background-repeat: no-repeat;
            "
        >
            <div class="w-100 h-100 position-absolute left-0 top-0 bg-dark rounded" style="opacity: .5;"></div>
            <h4 class="text-center text-sm-start" style="z-index: 999"><?php echo $categorieen[0]['naam'] ?></h4>
        </div>
    </a>
    <div class="col-5 col-sm-4 d-flex flex-column gap-2">
        <a href="/categorieen?id=<?php echo $categorieen[1]['id'] ?>" class="text-decoration-none" style="height: 125px;">
            <div
                class="w-100 h-100 position-relative d-flex align-items-center justify-content-center text-white rounded"
                style="
                    background-image: url('/assets/afbeeldingen/guitar2.jpg');
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                "
            >
                <div class="w-100 h-100 position-absolute left-0 top-0 bg-dark rounded" style="opacity: .5;"></div>
                <h4 class="text-center text-sm-start" style="z-index: 999"><?php echo $categorieen[1]['naam'] ?></h4>
            </div>
        </a>
        <a href="/categorieen?id=<?php echo $categorieen[2]['id'] ?>" class="text-decoration-none" style="height: 125px;">
            <div
                class="w-100 h-100 position-relative d-flex align-items-center justify-content-center text-white rounded"
                style="
                    background-image: url('/assets/afbeeldingen/guitar3.jpg');
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                "
            >
                <div class="w-100 h-100 position-absolute left-0 top-0 bg-dark rounded" style="opacity: .5;"></div>
                <h4 class="text-center text-sm-start" style="z-index: 999"><?php echo $categorieen[2]['naam'] ?></h4>
            </div>
        </a>
    </div>
</section>

<?php if (!empty($recente_producten)) { ?>
    <section class="d-flex flex-column mb-5">
        <h5>Laatst bekeken</h5>

        <div class="d-flex">
            <?php foreach (recenteProducten() as $recente_product) { ?>
                <div class="card me-2 text-white" style="width: 200px; height: 200px">
                    <img
                        src="/assets/afbeeldingen/<?php echo $recente_product['pad'] . '.' . $recente_product['extensie']; ?>"
                        alt="Product"
                        class="rounded w-100 h-100"
                        style="object-fit: cover"
                    >
                    <div class="w-100 h-100 position-absolute left-0 top-0 rounded bg-dark" style="opacity: .4"></div>
                    <div class="card-img-overlay">
                        <h5 class="card-title"><?php echo $recente_product['naam']; ?></h5>
                        <p class="card-text"><?php echo $recente_product['prijs']; ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
<?php } ?>

<!--Uitgelichte Producten-->
<section class="d-flex flex-column mb-5">
<!--    producten_detail?id=1-->
    <div class="d-flex justify-content-between align-items-end">
        <h5>Aanbevolen producten</h5>
        <a href="/producten" class="my-2 btn btn-link text-dark fw-semibold d-none d-sm-block">
            Meer Producten >
        </a>
    </div>

    <?php foreach (aanbevolenProducten() as $product) { ?>
        <a
            href="/producten_detail?id=<?php echo $product['id']; ?>"
            class="w-md-auto card d-flex flex-sm-row text-decoration-none text-dark mb-2"
        >
            <img
                    src="/assets/afbeeldingen/<?php echo $product['pad'] . '.' . $product['extensie']; ?>"
                    alt="<?php echo $product['naam']; ?>"
                    class="rounded"
                    style="width: 200px; height: 200px; object-fit: contain"
            >
            <div class="row-sm w-100 d-flex flex-column p-3">
                <div class="col-sm-12 d-flex flex-column flex-sm-grow-1">
                    <h5><?php echo $product['naam']; ?></h5>
                    <p class="text-truncate text-wrap"><?php echo $product['beschrijving']; ?></p>
                </div>
                <div class="col-sm-12 d-flex flex-sm-row justify-content-between align-items-end">
                    <p class="fw-semibold m-0">&euro; <?php echo $product['prijs']; ?></p>
                    <button class="btn btn-primary text-nowrap">Product bekijken</button>
                </div>
            </div>
        </a>
    <?php } ?>
</section>