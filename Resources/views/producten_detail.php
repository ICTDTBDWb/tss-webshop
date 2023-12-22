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
        <a class="btn btn-secondary" href="/producten" role="button" >Terug naar productoverzicht</a>
    </div>
    <br>
    <?php foreach ($productDetails as $enkelProduct) {?>
    <div class="col text-right">
        <h5>
            <?php print $enkelProduct['naam'];?>
        </h5>
        <div>
            <img
                    src="<?php print $enkelProduct['pad'];?>"
                    alt="Banner"
                    class="rounded w-50 h-50"
                    style="max-width: 200px; height: auto;"
            >
        </div>
        <div>
            <?php print "€" . " " . $enkelProduct['prijs']; ?>
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