
<?php include __DIR__ . "/../../Application/DatabaseManager.php"?>
<?php include __DIR__ . "/../../Application/SessionManager.php"?>



<?php include __DIR__ . '/../../Application/Http/beheer/productbeheer.php'; ?> <!--Verander example.php naar jouw gewenste file-->
<?php
     // sessie
     $session = \application\SessionManager::getInstance();


     //get and post

    if (is_array($_POST) && !empty($_POST))
    {
        var_dump($_POST);
    }

     $filter ="";
     $product_select[0] = "";
     $product_select[1] = "";
     if (is_array($_GET) && !empty($_GET))
     {
         $filter = filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_SPECIAL_CHARS);
         $filter = trim($filter);

         if(isset($_GET['Product'])) {
             $product_select = filter_input(INPUT_GET, 'Product', FILTER_SANITIZE_SPECIAL_CHARS);
             $product_select = preg_split("/ /", $product_select);
         }
     }



      //database
      use \application\DatabaseManager;
      $database = new DatabaseManager();
        // get categorien
      $categorieen = $database->query("SELECT * FROM categorieen ORDER BY id ASC")->get();
        // filter products in categories
      $producten_categorie = [];
      foreach ($categorieen as $categorie)
      {
          $categorie_id = $categorie['id'];
          $producten_categorie[$categorie_id]['product'] = $database->query("SELECT * FROM producten inner join product_categorieen where product_id = producten.id and categorie_id  = ? and naam like ? ORDER BY naam ASC", [$categorie_id, "%".$filter."%"] )->get();
          $producten_categorie[$categorie_id]['naam'] = $categorie['naam'];
      }
        //filter prodcut with no categorie
      $producten_categorie['overig']['product'] = $database->query("SELECT * FROM producten WHERE naam like ? and NOT EXISTS ( SELECT * FROM product_categorieen where product_categorieen.product_id = producten.id) ORDER BY naam ASC " , ["%".$filter."%"])->get();
      $producten_categorie['overig']['naam'] = "overig";

      $product = $database->query("SELECT * FROM producten where id = ?",[$product_select[0]])->get();
      $product_naam = "";
      $product_prijs  = "";
      $product_aantal = "";
      $product_beschrijving= "";
      $product_merk  = "";


      if (is_array($product) and array_key_exists("0", $product))
      {
          $product[0]["categorie"] = $database->query("SELECT * FROM tss.categorieen inner join tss.product_categorieen where tss.categorieen.id = tss.product_categorieen.categorie_id and tss.product_categorieen.product_id = ?",[$product[0]['id']])->get();
          $product_naam = array_key_exists("naam", $product[0]) ? $product[0]['naam'] : "";
          $product_prijs = array_key_exists("prijs", $product[0]) ? $product[0]['prijs'] : "";
          $product_aantal = array_key_exists("aantal", $product[0]) ? $product[0]['aantal'] : "";
          $product_beschrijving = array_key_exists("beschrijving", $product[0]) ? $product[0]['beschrijving'] : "";
          $product_merk = array_key_exists("merk", $product[0]) ? $product[0]['beschrijving'] : "";

      }

      //close database;
      $database->close();

      //check selected or filter
      foreach  ($producten_categorie as $key => &$item)
      {
          //button pressed
          foreach($item['product'] as $_key => &$value) {
              $value['show'] = $filter != "" ? "" : "show";
              if ($value['id'] == $product_select[0] && $item['naam'] == $product_select[1]) {
                  $value['active'] = "active";
                  $item['show'] = "";
              } else
                  $value['active'] = "";


          }
          //filter on categorie
          $item['show'] = ($filter != "" && count($item) > 0) || array_key_exists("show", $item) ? "" : "collapsed";
          //if categorie is shown, make all buttons show up
          foreach($item['product'] as $_key => &$value)
          {
              if( $item['show'] = "")
              {
                  $value['show'] = "";
              }


          }

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



<html lang="en">
    <!--Head-->

    <?php include __DIR__ . "/../../Resources/components/layout/head.php"; ?>



    <body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
        <!--Header-->
        <?php include __DIR__ . "/../../Resources/components/layout/header.php"; ?>


        <!--Pagina content container-->
        <div class="container-lg flex-grow-1 gx-0 py-4" >
            <main>
                <form method='POST' action=''>
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
                                <input type="text" class="form-control" id="product_naam" aria-describedby="product_help" value='<?php echo $product_naam ?>'>
                                <div id="product_help" class="form-text">verander of geef naam van product op.</div><br>


                                <div class="row">
                                    <div class="col" style='min-width: 50%'>
                                        <label for="product_merk" class="form-label" >Product Merk:</label>
                                        <input type="text" class="form-control" id="product_Merk"  list="merknamen" >
                                        <datalist id="merknamen">
                                            <option value="Boston">
                                            <option value="Cambridge">
                                        </datalist>
                                    </div>
                                    <div class="col" >
                                        <label for="product_aantal" class="form-label" >aantal:</label>
                                        <input type="number" class="form-control" id="product_aantal" min="0" value='<?php echo $product_aantal ?>'>
                                    </div>
                                    <div class="col">
                                        <label for="product_prijs" class="form-label">prijs</label>
                                        <div class="input-group mb-3">
                                        <span class="input-group-text" id="product_prijs">€</span>
                                        <input type="number" class="form-control" id="product_prijs" min="0" value='<?php echo $product_prijs ?>'>
                                        </div>
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
                               <?php echo checkbox_constructor($categorieen, $product) ?>
                            </card><br>
                            <button type="button" class="btn btn-outline-secondary" style="width: 100%">Categorie beheer</button>
                        </div>
                        <div class="col">
                            <label for="beschrijving" class="form-label">Beschrijving</label>
                            <textarea class="form-control" id="beschrijving" aria-label="With textarea" style="resize: none; height: 50vh" ><?php echo $product_beschrijving?> </textarea>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-outline-secondary" id="opslaan" name="opslaan" value="toevoegen" style="width: 100%">Toevoegen als nieuw</button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-outline-secondary" id="opslaan"  name="opslaan" value="opslaan"  style="width: 100%">Opslaan</button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-outline-secondary" id="opslaan"  name="opslaan" value="verwijderen"  style="width: 100%">Verwijderen</button>
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



        </div>

        <!--Footer & Scripts-->
    <?php include __DIR__ . "/../../Resources/components/layout/footer.php"; ?>
    <?php include __DIR__ . "/../../Resources/components/layout/scripts.php"; ?>
    </body>
</html>