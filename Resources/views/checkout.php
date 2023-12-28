<?php include basePath("Application/Http/checkout/checkout.php"); ?> <!--Verander example.php naar jouw gewenste file-->





<!-- Navigatie -->
<div class="d-flex flex-row justify-content-start navigation py-3">
    <a class="btn btn-outline-primary mx-3" href="/productpagina" role="button">Productpagina</a>
    <a class="btn btn-outline-primary mx-3" href="/contactpagina" role="button">Contactpagina</a>
</div>

<!-- Pagina content -->
<div class="d-flex flex-grow-1 overflow-hidden">
    <form class="d-flex flex-grow-1" method="POST" action="">
        <div class="d-flex flex-column flex-grow-1">
            <h1>Gegevens</h1>
            <div class="d-flex flex-column flex-grow-1 justify-content-around">
                <div class="form-group">
                    <label for="voornaam">Voornaam</label>
                    <input
                            type="text"
                            class="form-control <?php echo $validation_error_array["voornaam"]??"is_invalid";?>"
                            id="voornaam"
                            name="voornaam"
                            placeholder="Voornaam"
                            value="<?php echo $klant['voornaam']; ?>"
                    />
                </div>

                <div class="form-group">
                    <label for="tussenvoegsel">Tussenvoegsel</label>
                    <input
                            type="text"
                            class="form-control"
                            id="tussenvoegsel"
                            name="tussenvoegsel"
                            placeholder="Tussenvoegsel"
                            value="<?php echo $klant['tussenvoegsel']; ?>"
                    />
                </div>
                <div class="form-group">
                    <label for="achternaam">Achternaam</label>
                    <input
                            type="text"
                            class="form-control <?php echo $validation_error_array["achternaam"]??"is_invalid";?>"
                            id="achternaam"
                            name="achternaam"
                            placeholder="Achternaam"
                            value="<?php echo $klant['achternaam']; ?>"
                    />
                </div>

                <div class="form-group">
                    <label for="straat">Straat</label>
                    <input
                            type="text"
                            class="form-control <?php echo $validation_error_array["straat"]??"is_invalid";?>"
                            id="straat"
                            name="straat"
                            placeholder="Straatnaam"
                            value="<?php echo $klant['straat']; ?>"
                    />
                </div>

                <div class="form-group">
                    <label for="huisnummer">Huisnummer</label>
                    <input
                            type="text"
                            class="form-control <?php echo $validation_error_array["huisnummer"]??"is_invalid";?>"
                            id="huisnummer"
                            name="huisnummer"
                            placeholder="Huisnummer"
                            value="<?php echo $klant['huisnummer']; ?>"
                    />
                </div>

                <div class="form-group">
                    <label for="postcode">Postcode</label>
                    <input
                            type="text"
                            class="form-control <?php echo $validation_error_array["postcode"]??"is_invalid";?>"
                            id="postcode"
                            name="postcode"
                            placeholder="4 cijfers en 2 letters"
                            value="<?php echo $klant['postcode']; ?>"
                    />
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-grow-1">
            <div class="d-flex flex-column border mx-5">
                <h2 class="text-center mt-2">Overzicht</h2>
                <div class="d-flex flex-column flex-grow-1 m-5">
                    <?php if($producten) { ?>
                        <?php foreach($producten as $product) { ?>
                                <div class="d-flex flex-grow-1 flex-row my-1">
                                    <div class="flex-grow-1" style="flex-basis: 0;">
                                        <a href="/product/<?php echo $product['id'] ?>"><?php echo $product['product_naam'] ?></a>
                                        <?php echo "x".$product['hoeveelheid_in_winkelwagen'] ?>
                                    </div>
                                    <div class="flex-grow-1" style="flex-basis: 0;"><?php echo $product['prijs']*$product['hoeveelheid_in_winkelwagen'] ?></div>
                                </div>
                        <?php } ?>
                    <div id="addedCouponsSection">
                        <?php if(isset($_SESSION['winkelwagen']['cadeaubonnen']) && count($_SESSION['winkelwagen']['cadeaubonnen']) > 0) {?>
                        <?php foreach($_SESSION['winkelwagen']['cadeaubonnen'] as $coupon) { ?>
                            <div class="d-flex flex-grow-1 flex-row my-1 added-coupon align-items-center" attr-coupon-code="<?php echo $coupon['code'] ?>">
                                <div class="flex-grow-1" style="flex-basis: 0;"><?php echo $coupon['code'] ?></div>
                                <div class="flex-grow-1" style="flex-basis: 0;"><?php echo $coupon['bedrag'] ?></div>
                                <button type="button" class="btn btn-outline-danger added-coupon-remove-button" attr-coupon-code='<?php echo $coupon['code'] ?>' attr-coupon-bedrag='<?php echo $coupon['bedrag'] ?>'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                                    <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z'></path>
                                    <path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z'></path>
                                    </svg>
                                </button>
                            </div>
                           <?php } ?>
                        <?php } ?>
                    </div>
                        <div class="d-flex flex-grow-1"">
                            <div class="d-flex flex-grow-1 flex-row">
                                <div class="flex-grow-1" style="flex-basis: 0;">
                                    Totaal:
                                </div>
                                <div id="totalPrice" class="flex-grow-1" style="flex-basis: 0;"><?php echo getTotalFromCurrentCart() - getCouponBedrag() ; ?></div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div> Uw winkelwagen is leeg </div>
                    <?php } ?>
                </div>
            <?php include("view_coupon.php"); ?>

            </div>
        <div class="d-flex align-items-center justify-content-center flex-grow-1 flex-column">
            <h1>Betaalmethode</h1>
            <div class="d-flex flex-column">
                <div class="form-check">
                    <label class="form-check-label" for="iDeal">iDeal</label>
                    <input
                            class="form-check-input <?php if(isset($validation_error_array["betaalmethode"]))echo"is-invalid";?>"
                            type="radio"
                    name="betaalmethode"
                    id="iDeal"
                    value="iDeal"
                    <?php if(isset($betaalmethode_filtered) && $betaalmethode_filtered == "iDeal") echo "checked"; ?>
                />
                </div>
                <div class="form-check">
                    <label class="form-check-label" for="PayPal">PayPal</label>
                    <input
                            class="form-check-input <?php if(isset($validation_error_array["betaalmethode"]))echo"is-invalid";?>"
                            type="radio"
                            name="betaalmethode"
                            id="PayPal"
                            value="PayPal"
                            <?php if(isset($betaalmethode_filtered) && $betaalmethode_filtered == "PayPal") echo "checked"; ?>
                    />
                    <div class="invalid-feedback">
                        Kies alstublieft een betaalmethode.
                    </div>
                </div>

            </div>
            <h1>Verzendmethode</h1>
            <div class="d-flex flex-column">
                <?php foreach ($verzendmethodes_array as $key => $verzendmethode) { ?>
                    <div class="form-check">
                        <label
                                class="form-check-label"
                                for="verzendmethode_<?php echo $verzendmethode["id"]?>"
                        ><?php echo $verzendmethode["naam"]?>
                        </label>
                        <input
                                class="form-check-input <?php if(isset($validation_error_array["verzendmethode"]))echo"is-invalid";?>"
                                type="radio"
                                name="verzendmethode"
                                id="verzendmethode_<?php echo $verzendmethode["id"]?>"
                                value="<?php echo $verzendmethode["id"]?>"
                                <?php if(isset($verzendmethode_filtered) && $verzendmethode_filtered == $verzendmethode['id']) echo "checked"; ?>
                        />
                        <?php if($key == array_key_last($verzendmethodes_array)) { ?>
                            <div class="invalid-feedback">
                                Kies alstublieft een verzendmethode.
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <div class="">
                <input type="submit" class="btn btn-primary" value="Betalen"/>

            </div>
        </div>
    </form>
</div>