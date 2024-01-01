<?php
    //database
    $database = new Database();
    // get categorien
    $categorieen = $database->query("SELECT * FROM categorieen ORDER BY id ASC")->get();



    $product_id = "";
    $product_naam = "";
    $product_prijs  = "";
    $product_aantal = "";
    $product_beschrijving= "";
    $product_merk  = "";

     //get and post
    if (is_array($_POST) && !empty($_POST))
    {

        if(isset($_POST['opslaan']))
        {
            $opslaan = $_POST['opslaan'];
            $product_id = array_key_exists("product_id", $_POST) ? $_POST['product_id'] : "";
            $product_naam = array_key_exists("product_naam", $_POST) ? $_POST['product_naam'] : "";
            $product_prijs = array_key_exists("product_prijs", $_POST) ? $_POST['product_prijs'] : 0;
            $product_aantal = array_key_exists("product_aantal", $_POST) ? $_POST['product_aantal'] : 0;
            $product_beschrijving = array_key_exists("product_beschrijving", $_POST) ? $_POST['product_beschrijving'] : "";
            $product_merk = array_key_exists("product_merk", $_POST) ? $_POST['product_merk'] : "";
            $product_categorie = [];

            foreach($_POST as $key => $value) {
                if (str_contains($key, "checkbox_")) {
                    $key = str_replace("checkbox_", "", $key);
                    $product_categorie[$key] = $value;

                }

            }


            if ($opslaan == "opslaan")
            {
<<<<<<< Updated upstream
                if ($product_id == "")
                   $product_id = $database->query("INSERT INTO producten (`naam`, `prijs`, `aantal`) VALUES (?,?,?) ", [$product_naam, $product_prijs, $product_aantal])->insert();
                else
                    $database->query("UPDATE producten SET naam = ? , prijs = ? , aantal = ? WHERE id = ? ", [$product_naam, $product_prijs, $product_aantal, $product_id]);
=======
                case "opslaan":
                    if ($product_id == "")
                        $product_id = $database->query("INSERT INTO producten (`naam`,`beschrijving`, `merk`, `prijs`, `aantal`, `is_actief`, `is_verwijderd`) VALUES (?,?,?,?,?,?,?) ", [$product_naam, $product_beschrijving, $product_merk, $product_prijs, $product_aantal, $product_actief,0])->insert();
                    else
                        $database->query("UPDATE producten SET naam = ?, beschrijving = ?, merk = ? , prijs = ? , aantal = ?, is_actief = ?, is_verwijderd = ? WHERE id = ? ", [$product_naam, $product_beschrijving, $product_merk, $product_prijs, $product_aantal, $product_actief, 0, $product_id]);
>>>>>>> Stashed changes


                $database->query("DELETE FROM product_categorieen where product_id = ?",[$product_id]);
                if(count($product_categorie)> 0) {
                   // $query = "INSERT INTO product_categorieen ('product_id', 'categorie_id' ) VALUES "
                   // $values ="[";

<<<<<<< Updated upstream
                    foreach ($product_categorie as $key => $value) {
                       $database->query("INSERT INTO product_categorieen (`product_id`, `categorie_id` ) VALUES (?,?) ", [$product_id, $key])->get();
=======
                        foreach ($product_categorie_post as $key => $value) {
                            $database->query("INSERT INTO product_categorieen (`product_id`, `categorie_id` ) VALUES (?,?) ", [$product_id, $key])->get();

                        }

                    }
                    $POST_GEWEEST = false;
                    break;


                case "toevoegen":
                    $product_id = $database->query("INSERT INTO producten (`naam`,`beschrijving`, `merk`, `prijs`, `aantal`, `is_actief`, `is_verwijderd`) VALUES (?,?,?,?,?,?,?) ", [$product_naam, $product_beschrijving, $product_merk, $product_prijs, $product_aantal, $product_actief,0])->insert();
                    foreach ($product_categorie as $key => $value) {
                        $database->query("INSERT INTO product_categorieen (`product_id`, `categorie_id` ) VALUES (?,?) ", [$product_id, $key])->get();

                    }
                    $POST_GEWEEST = false;
                    break;

                case "verwijderen":
                    if ($product_id != "")
                    {
                        $database->query("UPDATE producten SET is_verwijderd = ? where id = ?",[1,$product_id]);
                        //$database->query("DELETE FROM product_categorieen where product_id = ?",[$product_id]);
                        //$database->query("DELETE FROM producten where id = ?",[$product_id]);
                        $POST_GEWEEST = false;
                        unset($_GET['Product']);
>>>>>>> Stashed changes

                    }

                }

            }
            elseif ($opslaan == "toevoegen")
            {

                $product_id = $database->query("INSERT INTO producten (`naam`, `prijs`, `aantal`) VALUES (?,?,?) ", [$product_naam, $product_prijs, $product_aantal])->insert();
                foreach ($product_categorie as $key => $value) {
                    $database->query("INSERT INTO product_categorieen (`product_id`, `categorie_id` ) VALUES (?,?) ", [$product_id, $key])->get();

                }

            }
            elseif ($opslaan == "verwijderen")
            {
                if ($product_id != "")
                {
                    $database->query("DELETE FROM product_categorieen where product_id = ?",[$product_id]);
                    $database->query("DELETE FROM producten where id = ?",[$product_id]);

                }



            }
        }
    }

     $filter ="";
     $product_select[0] = "";
     $product_select[1] = "";
     if (is_array($_GET) && !empty($_GET))
     {

         $filter = array_key_exists("filter",$_GET) ? $_GET['filter'] : "";
         $filter = trim($filter);

         if(isset($_GET['Product'])) {
             $product_select = filter_input(INPUT_GET, 'Product', FILTER_SANITIZE_SPECIAL_CHARS);
             $product_select = preg_split("/ /", $product_select);
             $_POST['id']  = $product_select[0];

         }
     }

      $product = $database->query("SELECT * FROM producten where id = ?",[$product_select[0]])->get();


        // filter products in categories
      $producten_categorie = [];
      foreach ($categorieen as $categorie)
      {
          $categorie_id = $categorie['id'];
<<<<<<< Updated upstream
          $producten_categorie[$categorie_id]['product'] = $database->query("SELECT * FROM producten where naam like ? and id IN (SELECT `product_id` from product_categorieen where categorie_id  = ? ) ORDER BY naam ASC", ["%".$filter."%",$categorie_id] )->get();
=======
          $producten_categorie[$categorie_id]['product'] = $database->query("SELECT * FROM producten where naam like ? and not is_verwijderd = ? and id IN (SELECT `product_id` from product_categorieen where categorie_id  = ? ) ORDER BY naam ASC", ["%".$filter."%",1,$categorie_id] )->get();
>>>>>>> Stashed changes
          $producten_categorie[$categorie_id]['naam'] = $categorie['naam'];
      }
      //var_dump($producten_categorie);
        //filter prodcut with no categorie
<<<<<<< Updated upstream
      $producten_categorie['overig']['product'] = $database->query("SELECT * FROM producten WHERE naam like ? and NOT EXISTS ( SELECT * FROM product_categorieen where product_categorieen.product_id = producten.id) ORDER BY naam ASC " , ["%".$filter."%"])->get();
      $producten_categorie['overig']['naam'] = "overig";
=======
      $producten_categorie['overig']['product'] = $database->query("SELECT * FROM producten WHERE naam like ? and not is_verwijderd = ? and NOT EXISTS ( SELECT * FROM product_categorieen where product_categorieen.product_id = producten.id) ORDER BY naam ASC " , ["%".$filter."%",1])->get();
      $producten_categorie['overig']['naam'] = "overig";
      $producten_categorie['overig']['beschrijving'] = "";
      $producten_categorie['verwijderd']['naam'] = "verwijderd";
      $producten_categorie['verwijderd']['beschrijving'] = "";
      $producten_categorie['verwijderd']['product'] = $database->query("SELECT * FROM producten where naam like ? and is_verwijderd = ?",["%".$filter."%",1])->get();
>>>>>>> Stashed changes





      if (is_array($product) and array_key_exists("0", $product))
      {
          $product[0]["categorie"] = $database->query("SELECT * FROM categorieen where id IN (SELECT `categorie_id` from product_categorieen where product_id = ?)",[$product[0]['id']])->get();

          $product_id = array_key_exists("id", $product[0]) ? $product[0]['id'] : "";
          $product_naam = array_key_exists("naam", $product[0]) ? $product[0]['naam'] : "";
          $product_prijs = array_key_exists("prijs", $product[0]) ? $product[0]['prijs'] : "";
          $product_aantal = array_key_exists("aantal", $product[0]) ? $product[0]['aantal'] : "";
          $product_beschrijving = array_key_exists("beschrijving", $product[0]) ? $product[0]['beschrijving'] : "";
          $product_merk = array_key_exists("merk", $product[0]) ? $product[0]['merk'] : "";

      }

      //close database;
      $database->close();

      //check selected or filter
      foreach  ($producten_categorie as $key => &$item)
      {
          $active = false;
          //button pressed
          foreach($item['product'] as $_key => &$value) {


              if ($value['id'] == $product_select[0] && $key == $product_select[1]) {
                  $value['active'] = "active";
                  $active = true;
              } else
                  $value['active'] = "";


          }
          //filter on categorie
          $item['show'] = ($filter != "" && count($item['product']) > 0) || $active == true  ? "" : "collapsed";
      }


?>







<!DOCTYPE html>

<style>
    aside {
         width:20%;
         #padding-right: 30px;
         float: left;
         overflow-y: auto;
         min-height: 100vh;
         max-height: 100vh;
         background-color:  lightgray;
         border-radius: 15px;
         text-align: center;




        }
   main{
       width:70%;
       float:right;
   }




    .button
    {
        font-size: 16px;
        text-align: center;
        white-space: normal;
        width:95%;
        margin-top: 1%;
        margin-bottom: 1%;
        border-radius: 15px;
        align-content: center;
    }
    .button:hover
    {
        background-color: lightcyan;
    }

</style>

<script>
    //window.onbeforeunload = closingCode;
    function closingCode(){
        alert("u gaat de pagina verlaten");
        //document.getElementById("categoriebeheer").show()
        return  "Are you sure you want to leave this page?"; //<-- this prevents the dialog confirm box
    }
</script>

<main>
    <form method="POST" action='' class="hidden">
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
                    <input type="text" class="form-control" id="product_naam" name="product_naam" aria-describedby="product_help" value='<?php echo $product_naam ?>'>
                    <input type="hidden" class="form-control" id="product_id" name="product_id"   value='<?php echo $product_id ?>'>
                    <div id="product_help" class="form-text">verander of geef naam van product op.</div><br>


                    <div class="row">
                        <div class="col" style='min-width: 50%'>
                            <label for="product_merk" class="form-label" >Product Merk:</label>
                            <input type="text" class="form-control" id="product_merk" name="product_merk"  list="merknamen" >
                            <datalist id="merknamen">
                                <option value="Boston">
                                <option value="Cambridge">
                            </datalist>
                        </div>
                        <div class="col" >
                            <label for="product_aantal" class="form-label" >aantal:</label>
                            <input type="number" class="form-control" id="product_aantal" name="product_aantal" min="0" value='<?php echo $product_aantal ?>'>
                        </div>
                        <div class="col">
                            <label for="product_prijs" class="form-label">prijs</label>
                            <div class="input-group mb-3">
                            <span class="input-group-text" id="product_prijs">€</span>
                            <input type="number" class="form-control" id="product_prijs" name="product_prijs" min="0.00" step="any" value='<?php echo $product_prijs ?>'>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="row">
            <div class="container col" style="max-width: 30%; align-content: flex-start" >
                <label for="hoofd_afbeelding" class="form-label">Hoofd afbeelding </label>
                <select id="hoofd_afbeelding" class="form-select" name="hoofd_afbeelding">
                    <option selected>pic1</option>
                    <option>pic1</option>
                    <option>pic2</option>
                    <option>pic3</option>
                </select><br>
                <a class="btn btn-outline-secondary" href= /beheer/mediacategoriebeheer" style="width: 100%" role="button">Media beheer</a>
               <!-- <button type="button" class="btn btn-outline-secondary" style="width: 100%"  data-bs-toggle="modal" data-bs-target="#exampleModal">Media beheer</button><br><br> -->
                <label for="categorie" class="form-label">Categorieen </label>
                <card class="card" style="max-height: 30vh; min-height: 30vh; overflow-y: auto">
                   <?php echo checkbox_constructor($categorieen, $product) ?>
                </card><br>
                <button type="button" class="btn btn-outline-secondary"  style="width: 100%">Categorie beheer</button>
            </div>
            <div class="col">
                <label for="beschrijving" class="form-label">Beschrijving</label>
                <textarea class="form-control" id="beschrijving" aria-label="With textarea" name="product_beschrijving" style="resize: none; height: 50vh" ><?php echo $product_beschrijving?> </textarea>
            </div>
        </div><br>

        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-outline-secondary" id="opslaan" name="opslaan" value="toevoegen" style="width: 100%">Toevoegen als nieuw</button>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-outline-secondary" id="opslaan"  name="opslaan" value='opslaan'  style="width: 100%">Opslaan</button>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-outline-secondary" id="opslaan"  name="opslaan" value="verwijderen"  style="width: 100%">Verwijderen</button>
            </div>

        </div>

    </form>
</main>

 <aside class="" id="aside">
     <form method="GET" action=''>
        <input type="search" value='<?php echo $filter ?> ' class="form-control border" id="test" name="filter"/>



          <div class="accordion" id="accordionPanelsStayOpenExample">

             <?php echo arcordion_constructer($producten_categorie) ?>

         </div>
     </form>

 </aside>

<div class="modal fade" tabindex="-1" id="exampleModal" >
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Upload Image</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Select an image to upload:</label>
                    <input class="form-control" type="file" id="formFile">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Upload</button>
        </div>
    </div>
</div>
</div>




<div class="modal fade" tabindex="-1" id="categoriebeheer" >
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Categoriebeheer</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Select an image to upload:</label>
                    <input class="form-control" type="file" id="formFile">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Upload</button>
        </div>
    </div>
</div>
</div>