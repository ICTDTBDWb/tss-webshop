<!DOCTYPE html>


<form>
    <div class="row  align-items-top ">
    <!-- Carousel -->
    <div id="demo" class="carousel slide col" data-bs-ride="carousel" style="max-width:20vh; max-height:20vh">

        <!-- Indicators/dots -->


        <!-- The slideshow/carousel -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://th.bing.com/th/id/OIP.AfML_m2qzeq-Pmrwh6H5jwHaHa?w=164&h=180&c=7&r=0&o=5&pid=1.7" alt="Los Angeles" class="d-block w-100">
            </div>
            <div class="carousel-item">
                <img src="https://th.bing.com/th/id/OIP.AfML_m2qzeq-Pmrwh6H5jwHaHa?w=164&h=180&c=7&r=0&o=5&pid=1.7" alt="Chicago" class="d-block w-100" >
            </div>
            <div class="carousel-item">
                <img src="https://th.bing.com/th/id/OIP.AfML_m2qzeq-Pmrwh6H5jwHaHa?w=164&h=180&c=7&r=0&o=5&pid=1.7" alt="New York" class="d-block w-100" >
            </div>
        </div>

        <!-- Left and right controls/icons -->
        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev" style="opacity: 50%; background-color: lightgray" >
            <span class="carousel-control-prev-icon" ></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next" style="opacity: 50%; background-color: lightgray">
            <span class="carousel-control-next-icon" ></span>
        </button>
    </div>





        <div class="col">
            <div class="mb-3">
                <label for="product_naam" class="form-label">Product Naam:</label>
                <input type="text" class="form-control" id="product_naam" aria-describedby="product_help" style=>
                <div id="product_help" class="form-text">We'll never share your email with anyone else.</div>

                <label for="product_merk" class="form-label">Product Merk:</label>
                <input type="text" class="form-control" id="product_Merk" aria-describedby="product_help_merk" list="cityname">
                <datalist id="cityname">
                    <option value="Boston">
                    <option value="Cambridge">
                </datalist>
                <div id="product_help_merk" class="form-text">We'll never share your email with anyone else.</div>
            </div>
        </div>
    </div>
</form>







<?php


