<?php
    $categorieen = uitgelichteCategorieen();
?>

<!--Banner-->
<section class="row gx-0 mb-5">
    <a href="/categorieen?id=<?php echo $categorieen[0]['id'] ?>" class="col-8 pe-2 bg-image">
        <img
            src="https://img.freepik.com/free-photo/guy-playing-acoustic-guitar_169016-2126.jpg?w=1380&t=st=1701540133~exp=1701540733~hmac=7522639adac31beacdcfcb3c31df1aeb3666b4d6547be7ad761153305b7025f8"
            alt="<?php echo $categorieen[0]['naam'] ?>"
            class="rounded w-100 h-100"
            style="object-fit: cover"
        >
    </a>
    <div class="col-4 d-flex flex-column gap-2">
        <a href="/categorieen?id=<?php echo $categorieen[1]['id'] ?>" class="container-fluid bg-image">
            <img
                src="https://img.freepik.com/free-photo/guy-playing-acoustic-guitar_169016-2126.jpg?w=1380&t=st=1701540133~exp=1701540733~hmac=7522639adac31beacdcfcb3c31df1aeb3666b4d6547be7ad761153305b7025f8"
                alt="<?php echo $categorieen[1]['naam'] ?>"
                class="rounded w-100 h-100"
                style="object-fit: cover"
            >
        </a>
        <a href="/categorieen?id=<?php echo $categorieen[2]['id'] ?>" class="container-fluid bg-image">
            <img
                src="https://img.freepik.com/free-photo/guy-playing-acoustic-guitar_169016-2126.jpg?w=1380&t=st=1701540133~exp=1701540733~hmac=7522639adac31beacdcfcb3c31df1aeb3666b4d6547be7ad761153305b7025f8"
                alt="<?php echo $categorieen[2]['naam'] ?>"
                class="rounded w-100 h-100"
                style="object-fit: cover"
            >
        </a>
    </div>
</section>

<section class="d-flex flex-column mb-5">
    <h5>Laatst bekeken</h5>

    <div class="d-flex">
        <div class="card me-2 text-white" style="width: 200px; height: 200px">
            <img
                src="https://img.freepik.com/free-photo/guy-playing-acoustic-guitar_169016-2126.jpg?w=1380&t=st=1701540133~exp=1701540733~hmac=7522639adac31beacdcfcb3c31df1aeb3666b4d6547be7ad761153305b7025f8"
                alt="Product"
                class="rounded w-100 h-100"
                style="object-fit: cover"
            >
            <div class="w-100 h-100 position-absolute left-0 top-0 rounded bg-dark" style="opacity: .4"></div>
            <div class="card-img-overlay">
                <h5 class="card-title">Product naam</h5>
                <p class="card-text">Product Price</p>
            </div>
        </div>
    </div>
</section>

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
                    <p class="text-truncate text-wrap"><?php echo $product['omschrijving']; ?></p>
                </div>
                <div class="col-sm-12 d-flex flex-sm-row justify-content-between align-items-end">
                    <p class="fw-semibold m-0">&euro; <?php echo $product['prijs']; ?></p>
                    <button class="btn btn-primary text-nowrap">Product bekijken</button>
                </div>
            </div>
        </a>
    <?php } ?>
</section>