<!-- PHP logica -->
<?php
include basePath("Application/Http/producten.php");
?>

<!--Title-->
<div class="container-lg flex-grow-1 gx-0 py-2">
    <div class="d-flex justify-content-center">
        <h1 class="mt-0 font-weight-bold mb-5">Producten</h1>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <!--Weergave categorieen-->
            <div class="col">
                <ul class="list-group">
                    <h5 class="font-weight-bold d-flex justify-content-start" style="max-width: 25%">Categorieën</h5>
                    <?php foreach (queryCategorieen() as $categorieen) {?>
                        <br>
                        <li class="list-group-item list-group-item-action" style="max-width: 95%"><?php print $categorieen['naam'];?></li>
                    <?php  } ?>
                </ul>
            </div>
            <!--Weergave producten-->
            <div class="col-10">
                <div class="row">
                    <?php foreach (queryProducten() as $producten) {?>
                        <div class="col-md-4 text-right">
                            <h5>
                                <a href="producten_detail.php?id=<?php echo ($producten['id']); ?>">
                                    <?php print $producten['naam'];?>
                                </a>
                            </h5>
                            <div>
                                <img
                                        src="https://img.freepik.com/free-photo/guy-playing-acoustic-guitar_169016-2126.jpg?w=1380&t=st=1701540133~exp=1701540733~hmac=7522639adac31beacdcfcb3c31df1aeb3666b4d6547be7ad761153305b7025f8"
                                        alt="Banner"
                                        class="rounded w-50 h-50"
                                        style="object-fit: cover"
                                >
                            </div>
                            <div>
                                <?php print "€" . " " . $producten['prijs']; ?>
                                <br>
                                <form action="/winkelwagen">
                                    <label for="quantity">Aantal</label>
                                    <input type="number" id="quantity" name="quantity" min="1" max="5">
                                    <input type="submit" value="In winkelwagen">
                                </form>
                            </div>
                            <br>
                            <br>
                        </div>
                    <?php  } ?>
                </div>
            </div>
        </div>
    </div>
</div>
