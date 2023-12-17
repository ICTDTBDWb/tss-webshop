<!-- PHP logica -->
<?php include basePath("Application/Http/producten.php"); ?>

<!--Haal de product ID op-->
<?php
$productId = isset($_GET['id']) ? $_GET['id'] : null;
$productDetails = null;
if ($productId) {
    $productDetails = queryEnkelProduct($productId);
}
?>

<!--Print enkel product aan de hand van ID-->
<!--Title-->
<div class="container-lg flex-grow-1 gx-0 py-2">
    <div class="d-flex justify-content-center">
        <h1 class="mt-0 font-weight-bold mb-1">Product details</h1>
    </div>
    <div class="d-flex justify-content-end">
        <a class="btn btn-secondary" href="producten.php" role="button" >Terug naar productoverzicht</a>
    </div>
    <br>
    <?php foreach ($productDetails as $enkelProduct) {?>
    <div class="col text-right">
        <h5>
            <?php print $enkelProduct['naam'];?>
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
            <?php print "€" . " " . $enkelProduct['prijs']; ?>
            <br>
            <form action="/winkelwagen.php">
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