<!DOCTYPE html>


<form>
    <div class="row  align-items-top ">
    <!-- Carousel -->
    <div id="demo" class="carousel slide col " data-bs-ride="carousel" style="max-width:20vh; max-height:20vh; min-height: 20vh; min-width: 20vh; margin-left: 2vh; margin-right: 2vh" data-bs-interval="false">

        <!-- Indicators/dots -->


        <!-- The slideshow/carousel -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <iframe src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0"  title="YouTube video" class="d-block w-100 h-100" ></iframe>
                <h5 style="color: black; text-align: center">pic 1</h5>
            </div>
            <div class="carousel-item">
                <img src="https://th.bing.com/th/id/OIP.yllk_6Rnouo_r0aOMnVlTwHaHa?w=176&h=180&c=7&r=0&o=5&pid=1.7" alt="Chicago" class="d-block w-100 h-100" >
                <div class="carousel-caption" style="top:80%; bottom: auto">
                    <h5 style="color: black">pic 2</h5>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://th.bing.com/th/id/OIP.AfML_m2qzeq-Pmrwh6H5jwHaHa?w=164&h=180&c=7&r=0&o=5&pid=1.7" alt="New York" class="d-block w-100 h-100" >
                <div class="carousel-caption " style="top:80%; bottom: auto">
                    <h5 style="color: black">pic 3</h5>
                </div>
            </div>
        </div>

        <!-- Left and right controls/icons -->
        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev" style="opacity: 50%; background-color: lightgray; margin-left: -2vh" >
            <span class="carousel-control-prev-icon" ></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next" style="opacity: 50%; background-color: lightgray; margin-right: -2vh">
            <span class="carousel-control-next-icon" ></span>
        </button>
    </div>





        <div class="col">
            <div class="mb-3" >
                <label for="product_naam" class="form-label">Product Naam:</label>
                <input type="text" class="form-control" id="product_naam" aria-describedby="product_help" style=>
                <div id="product_help" class="form-text">verander of geef naam van product op.</div><br>


                <div class="row">
                    <div class="col" style="min-width: 70%" >
                        <label for="product_merk" class="form-label">Product Merk:</label>
                        <input type="text" class="form-control" id="product_Merk"  list="cityname">
                        <datalist id="cityname">
                            <option value="Boston">
                            <option value="Cambridge">
                        </datalist>
                    </div>
                    <div class="col">
                        <label for="product_aantal" class="form-label">aantal:</label>
                        <input type="number" class="form-control" id="product_aantal">
                    </div>
                </div>
            </div>
        </div>
    </div><br>
    <div class="row">
    <div class="container col" style="max-width: 30%; align-content: flex-start" >
        <label for="hoofd_afbeelding" class="form-label">Hoofd afbeelding </label>
        <select id="hoofd_afbeelding" class="form-select">
                <option selected>pic1</option>
                <option>pic1</option>
                <option>pic2</option>
                <option>pic3</option>
        </select><br>
        <button type="button" class="btn btn-outline-secondary" style="width: 100%">Media beheer</button><br><br>
        <label for="categorie" class="form-label">Categorieen </label>
        <card class="card" style="max-height: 30vh; min-height: 30vh; overflow-y: auto">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Default checkbox
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                <label class="form-check-label" for="flexCheckChecked">
                    Checked checkbox
                </label>
            </div>
        </card><br>
        <button type="button" class="btn btn-outline-secondary" style="width: 100%">Categorie beheer</button>
    </div>
        <div class="col">
            <label for="beschrijving" class="form-label">Beschrijving</label>
            <textarea class="form-control" id="beschrijving" aria-label="With textarea" style="resize: none; height: 50vh"></textarea>
        </div>
    </div><br>

    <div class="row">
        <div class="col">
            <button type="button" class="btn btn-outline-secondary" style="width: 100%">Toevoegen als nieuw</button>
        </div>
        <div class="col">
            <button type="button" class="btn btn-outline-secondary" style="width: 100%">Opslaan</button>
        </div>
        <div class="col">
            <button type="button" class="btn btn-outline-secondary" style="width: 100%">Verwijderen</button>
        </div>

    </div>

</form>







<?php


