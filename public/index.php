<!-- PHP logica -->
<?php include __DIR__ . '/../application/homepagina.php';?>

<!DOCTYPE html>

<html lang="en">
    <!--Head-->
    <?php include __DIR__ . "/../application/components/layout/head.php"; ?>

    <body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
        <!--Header-->
        <?php include __DIR__ . "/../application/components/layout/header.php"; ?>

        <!--Pagina content container-->
        <div class="container-lg flex-grow-1 gx-0 py-4">
            <!--Banner-->
            <div class="container-fluid mb-5 bg-image" style="height: 275px;">
                <img
                    src="https://img.freepik.com/free-photo/guy-playing-acoustic-guitar_169016-2126.jpg?w=1380&t=st=1701540133~exp=1701540733~hmac=7522639adac31beacdcfcb3c31df1aeb3666b4d6547be7ad761153305b7025f8"
                    alt="Banner"
                    class="rounded w-100 h-100"
                    style="object-fit: cover"
                >
            </div>

            <!--Products-->
            <section class="container-fluid row gx-0">
                <div class="col-12 d-flex mb-2">
                    <h4 class="flex-grow-1">Onze aanbevelingen:</h4>
                    <button class="btn btn-link">Meer bekijken</button>
                </div>
                <div class="col-12 card border-gray rounded-lg shadow-sm" style="height: 200px;">
                    <div class="card-body h-100 p-0 d-flex gap-4">
                        <img
                                src="https://img.freepik.com/free-photo/headstock-classical-fingerboard-wood-fretboard_1172-289.jpg?w=740&t=st=1701540262~exp=1701540862~hmac=7b89b66ac9281587538251b8ba7eca019fdf9dab6c0c2dd30a1149d0e258f674"
                                alt="Product"
                                class="rounded-start col-3"
                                style="width: 200px; height: 200px; object-fit: cover"
                        />

                        <div class="flex-grow-1 p-3 d-flex flex-column">
                            <h5 class="mt-0 font-weight-bold mb-2">Product name</h5>

                            <p class="font-italic text-muted mb-3 small">
                                Sed ut pulvinar felis. Fusce eleifend nunc tempor dolor commodo consectetur. In hac habitasse platea
                                dictumst. Nam elementum volutpat nisi eget sodales. Quisque malesuada suscipit ultricies. Quisque in nibh
                                magna. Morbi vulputate lorem laoreet, cursus nibh eget, ultricies libero. Praesent fringilla, ipsum
                                consectetur lobortis pellentesque, nibh elit placerat erat, eget euismod neque nulla vel diam. Nulla sit
                                amet lectus pellentesque, faucibus lorem sit amet, eleifend ex.
                            </p>

                            <ul class="list-inline m-0 small">
                                <li class="list-inline-item m-0"><i class="fa fa-star text-warning"></i></li>
                                <li class="list-inline-item m-0"><i class="fa fa-star text-warning"></i></li>
                                <li class="list-inline-item m-0"><i class="fa fa-star text-warning"></i></li>
                                <li class="list-inline-item m-0"><i class="fa fa-star text-warning"></i></li>
                                <li class="list-inline-item m-0"><i class="fa fa-star-o text-gray"></i></li>
                            </ul>
                        </div>

                        <div class="w-25 p-3 d-flex flex-column justify-content-between">
                            <h6 class="text-end fw-bold my-2">&euro; 1,09,900</h6>

                            <button class="btn btn-primary">
                                <i class="fa fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!--Footer & Scripts-->
        <?php include __DIR__ . "/../application/components/layout/footer.php"; ?>
        <?php include __DIR__ . "/../application/components/layout/scripts.php"; ?>
    </body>
</html>