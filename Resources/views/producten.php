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
                        <li class="list-group-item list-group-item-action" style="max-width: 95%">
                            <a style="text-decoration:none; color:black;" href="/categorieen?id=<?php echo ($categorieen['id']); ?>"><?php echo $categorieen['naam'];?></a>
                        </li>

                    <?php  } ?>
                </ul>
            </div>
            <!--Weergave producten-->
            <div class="col-10">
                <div class="row">
                    <?php foreach (queryProductEnAfbeelding() as $productenEnAfbeelding) {?>
                        <div class="col-md-4 text-right">
                            <h5>
                                <a style="text-decoration:none; color:black;" href="/producten_detail?id=<?php echo ($productenEnAfbeelding['id']); ?>">
                                    <?php print $productenEnAfbeelding['naam'];?>
                                </a>
                            </h5>
                            <div>
                                <img
                                        src="<?php print $productenEnAfbeelding['pad'];?>"
                                        alt="Banner"
                                        class="rounded w-50 h-50"
                                        style="object-fit: cover"
                                >
                            </div>
                            <div>
                                <?php print "€" . " " . $productenEnAfbeelding['prijs']; ?>
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
