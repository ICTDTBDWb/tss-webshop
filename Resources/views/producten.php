<?php

include basePath("Application/Http/beheer/productbeheer.php");


// Verwerken van productgegevens
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'], $_POST['productaantal'])) {

        // Ophalen van de POST data
        $productId = $_POST['id'];
        $productaantal = $_POST['productaantal'];

        voegProductToeAanBestelling($productId, $productaantal);

        echo "<meta http-equiv='refresh' content='0'>";



    }
}
?>

<style>
    .media
    {
        object-fit: cover;
        height: 50%;
        width: 50%;
        border-radius: 2%;
    }
</style>


<!--Title-->
<div class="container-lg flex-grow-1 gx-0 py-2">
    <div class="d-flex justify-content-center">
        <h1 class="mt-0 font-weight-bold mb-5">Producten</h1>
    </div>
    <!--Filter-->
    <h5 class="font-weight-bold d-flex justify-content-end" style="max-width: 25%"></h5>
    <form method="get" action="/producten" style="display: flex; flex-wrap: wrap;">
        <?php foreach (queryCategorieen() as $categorieen) { ?>
            <div style="margin-left: 10px;">
                <input type="checkbox" name="categorie[]" value="<?php echo $categorieen['id']; ?>">
                <label><?php echo $categorieen['naam']; ?></label>
            </div>
        <?php } ?>
        <input type="submit" value="Filter">
    </form>
    <br>
    <br>
    <div class="container">
        <div class="row">
            <!--Weergave categorieen-->
            <div class="col">
                <ul class="list-group">
                    <h5 class="font-weight-bold d-flex justify-content-start" style="max-width: 25%">Categorieën</h5>
                    <?php foreach (queryCategorieen() as $categorieen) {?>
                        <br>
                        <li class="list-group-item list-group-item-action" style="max-width: 95%">
                            <a style="text-decoration:none; color:black;" href="/categorieen?id=<?php echo ($categorieen['id']); ?>"><?php echo $categorieen['naam'];?></a>
                        </li>

                    <?php  } ?>
                </ul>
            </div>
            <!--Weergave producten-->
            <div class="col-10">
                <div class="row">
                    <?php
                    $filteredCategories = isset($_GET['categorie']) ? $_GET['categorie'] : array();
                    $product_id = [];
                    foreach (queryProductEnAfbeelding() as $productenEnAfbeelding) {
                    // Check if the product belongs to any of the selected categories

                    if (empty($filteredCategories) || in_array($productenEnAfbeelding['categorie_id'], $filteredCategories)) {

                        if(!in_array($productenEnAfbeelding['product_id'], $product_id))
                            $product_id[] = $productenEnAfbeelding['product_id'];
                        else
                            continue;
                    ?>
                        <div class="col-md-4 text-right">
                            <h5>
                                <a style="text-decoration:none; color:black;" href="/producten_detail?id=<?php echo ($productenEnAfbeelding['id']); ?>">
                                    <?php print $productenEnAfbeelding['naam'];?>
                                </a>
                            </h5>
                            <div>
                             <!--   <img
                                        src="<?php print ($productenEnAfbeelding['pad'] . "." . $productenEnAfbeelding['extensie']);?>"
                                        alt="Product afbeelding"
                                        class="rounded w-50 h-50"
                                        style="object-fit: cover"
                                > !-->
                                <?php echo check_media($productenEnAfbeelding, "media") ?>
                            </div>
                            <br>
                            <div>
                                <?php print "€" . " " . $productenEnAfbeelding['prijs']; ?>
                                <br>
                                <!--Producten toevoegen aan winkelwagen en refresh window-->
                                <form method="post" onsubmit="" >
                                    <label for="productaantal">Aantal</label>

                                    <input type="number" id="productaantal" name="productaantal" min="1">
                                    <label for="productprijs"></label>
                                    <input type="hidden" id="id" name="id" value="<?php echo ($productenEnAfbeelding['id']); ?>">
                                    <br>
                                    <br>
                                    <input type="submit" value="In winkelwagen" >
                                </form>
                            </div>
                            <br>
                            <br>
                        </div>
                    <?php  } }?>
                </div>
            </div>
        </div>
    </div>
</div>