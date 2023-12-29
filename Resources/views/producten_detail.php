<!-- PHP logica -->
<?php include basePath("Application/Http/producten.php"); ?>

<!--Haal de product ID op-->
<?php
$getProductId = isset($_GET['id']) ? $_GET['id'] : null;
$productDetails = null;
if ($getProductId) {
    $productDetails = queryEnkelProduct($getProductId);

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
        <div class="col-4 text-right">
            <a>
                <?php print $enkelProduct['omschrijving'];?>
            </a>
        </div>
        <br>
        <div>
            <?php print "€" . " " . $enkelProduct['prijs']; ?>
            <br>
            <!--POST informatie ophalen-->
            <?php

            // Verwerken van productgegevens
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['id'], $_POST['productaantal'])) {

                    // Ophalen van de POST data
                    $productId = $_POST['id'];
                    $productaantal = $_POST['productaantal'];

                    voegProductToeAanBestelling($productId, $productaantal);

                }
            }

            ?>
            <br>
            <form method="post" onsubmit="setTimeout(function () { window.location.reload(); }, 10)">
                <label for="productaantal">Aantal</label>
                <input type="number" id="productaantal" name="productaantal" min="1">
                <input type="hidden" id="id" name="id" value="<?php echo ($enkelProduct['id']); ?>">
                <input type="submit" value="In winkelwagen">
            </form>
        </div>
        <br>
        <br>
    </div>
    <?php  } ?>
</div>