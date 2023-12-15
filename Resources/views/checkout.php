<?php include basePath("Application/Http/winkelwagen/winkelwagen.php"); ?> <!--Verander example.php naar jouw gewenste file-->
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
                        <div class="d-flex flex-grow-1"">
                            <div class="d-flex flex-grow-1 flex-row">
                                <div class="flex-grow-1" style="flex-basis: 0;">
                                    Totaal:
                                </div>
                                <div class="flex-grow-1" style="flex-basis: 0;"><?php echo getTotalFromCurrentCart(); ?></div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div> Uw winkelwagen is leeg </div>
                    <?php } ?>
                </div>
            </div>
        <div class="d-flex align-items-center justify-content-center flex-grow-1 flex-column">
            <h1>Betaalmethode</h1>
            <div class="d-flex flex-column">
                <div class="form-check">
                    <label class="form-check-label" for="iDeal">iDeal</label>
                    <input
                            class="form-check-input <?php if(isset($validation_error_array["betaalmethode"]))echo"is-invalid";?>"
                            type="radio"
                    ="betaalmethode"
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