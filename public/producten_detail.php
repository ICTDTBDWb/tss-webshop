<!-- PHP logica -->
<?php include __DIR__ . '/../Application/Http/producten.php'; ?>
<?php $session = \application\SessionManager::getInstance()?>

<!DOCTYPE html>

<html lang="en">
<!--Head-->
<?php include __DIR__ . "/../Resources/components/layout/head.php"; ?>

<body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
<!--Header-->
<?php include __DIR__ . "/../Resources/components/layout/header.php"; ?>

<!--Haal de product ID op-->
<?php
$productId = isset($_GET['id']) ? $_GET['id'] : null;
$productDetails = null;
if ($productId) {
    $productDetails = queryEnkelProduct($productId);
}
?>

<!--Print enkel product aan de hand van ID-->
<div class="container">
    <h1>Product details</h1>
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
</div>

<!--Footer & Scripts-->
<?php include __DIR__ . "/../Resources/components/layout/footer.php"; ?>
<?php include __DIR__ . "/../Resources/components/layout/scripts.php"; ?>
</body>
</html>