<?php
    $categorieen = uitgelichteCategorieen();
?>

<!--Banner-->
<section class="row gx-0 mb-5">
    <a href="/categorieen?id=<?php echo $categorieen[0]['id'] ?>" class="col-8 pe-2 bg-image">
        <img
            src="https://img.freepik.com/free-photo/guy-playing-acoustic-guitar_169016-2126.jpg?w=1380&t=st=1701540133~exp=1701540733~hmac=7522639adac31beacdcfcb3c31df1aeb3666b4d6547be7ad761153305b7025f8"
            alt="Banner"
            class="rounded w-100 h-100"
            style="object-fit: cover"
        >
    </a>
    <div class="col-4 d-flex flex-column gap-2">
        <a href="/categorieen?id=<?php echo $categorieen[1]['id'] ?>" class="container-fluid bg-image">
            <img
                src="https://img.freepik.com/free-photo/guy-playing-acoustic-guitar_169016-2126.jpg?w=1380&t=st=1701540133~exp=1701540733~hmac=7522639adac31beacdcfcb3c31df1aeb3666b4d6547be7ad761153305b7025f8"
                alt="Banner"
                class="rounded w-100 h-100"
                style="object-fit: cover"
            >
        </a>
        <a href="/categorieen?id=<?php echo $categorieen[2]['id'] ?>" class="container-fluid bg-image">
            <img
                src="https://img.freepik.com/free-photo/guy-playing-acoustic-guitar_169016-2126.jpg?w=1380&t=st=1701540133~exp=1701540733~hmac=7522639adac31beacdcfcb3c31df1aeb3666b4d6547be7ad761153305b7025f8"
                alt="Banner"
                class="rounded w-100 h-100"
                style="object-fit: cover"
            >
        </a>
    </div>
    <div class="d-flex container-fluid justify-content-end">
        <a href="/producten" class="my-2 btn btn-secondary">
            Meer Producten >
        </a>
    </div>
</section>