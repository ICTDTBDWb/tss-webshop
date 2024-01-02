<!-- PHP logica -->
<?php include basePath("Application/Http/winkelwagen/winkelwagen.php"); ?> <!--Verander example.php naar jouw gewenste file-->

<style>
    .productimage {
        width: 256px;
        height: auto;
        object-fit: contain;
    }
    .d-block {
        width: 256px;
        height: auto;
        object-fit: contain;
    }
</style>

<div class="d-flex flex-fill flex-column">
    <!-- Navigatie -->
    <div class="d-flex flex-row justify-content-start navigation py-3">
        <a class="btn btn-outline-primary mx-3" href="/homepagina" role="button">Homepagina</a>
        <a class="btn btn-outline-primary mx-3" href="/categorieen" role="button">Categoriepagina</a>
        <a class="btn btn-outline-primary mx-3" href="/contactpagina" role="button">Contactpagina</a>
    </div>

    <!-- Pagina content -->
    <div class="d-flex flex-column flex-grow-1">
        <form action="" method="post" class="d-flex flex-column flex-grow-1">
        <div class="d-flex flex-row wijzigingen">
            <div class="d-flex justify-content-end flex-grow-1">
                <input type="submit" name="wijzigingen_opslaan" class="btn-primary" value="Wijzigingen opslaan"/>
            </div>
            <div class="d-flex flex-grow-1"></div>
        </div>
        <div class="d-flex flex-row flex-grow-1">
            <div class="producten overflow-x-scroll flex-grow-1 d-flex">
                <div class="d-flex flex-column flex-grow-1">
                    <?php if($producten) { ?>
                        <?php foreach($producten as $product) { ?>
                        <?php $totaal_prijs += $product['prijs']*$product['hoeveelheid_in_winkelwagen'] ?>
                        <div class="d-flex border flex-grow-1 p-1 product">
                            <div clas="d-flex">
                                    <a href="/product_details/id=<?php echo $product['id'] ?>">
                                        <?php echo check_media(["naam" => $product['media_naam'], "pad" => $product['media_pad'], "extensie" => $product['media_extensie']]); ?>
                                    </a>
                                </div>
                            <div class="d-flex flex-grow-1 flex-column justify-content-between py-2">
                                <div class="d-flex flex-row">
                                    <div class="productnaam flex-grow-1">
                                        <a href="/product_details/id=<?php echo $product['id'] ?>"><?php echo $product['product_naam'] ?></a>
                                    </div>
                                    <div class="productprijs flex-grow-1">Prijs: <?php echo $product['prijs']*$product['hoeveelheid_in_winkelwagen'] ?></div>
                                </div>
                                <div class="d-flex flex-row justify-content-end ">
                                    <input class="" type="number" name="<?php echo $product['id'] ?>" value="<?php echo $product['hoeveelheid_in_winkelwagen'] ?>"/>
                                    <form action="" method="post">
                                        <button type="submit" name="remove_product" value="<?php echo $product['id'] ?>" class="btn btn-outline-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"></path>
                                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div> Uw winkelwagen is leeg </div>
                    <?php } ?>

                </div>
            </div>
            <div class="totaalencheckout d-flex flex-column flex-grow-1">
                <div class="flex-grow-1">

                </div>
                <div class="d-flex flex-row p-3">
                    <div class="flex-grow-1 d-flex justify-content-center align-items-center ">Totaal:
                        <span>
                            <?php echo $totaal_prijs; ?>
                        </span>
                    </div>
                    <?php if($user_logged_in) { ?>
                        <a href="/checkout" class="btn btn-primary flex-grow-1 <?php if(!$producten){echo "disabled";}?>" role="button">Volgende stap</a>

                    <?php } else { ?>
                        <a href="/login" class="btn-primary flex-grow-1" role="button">Volgende stap</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>