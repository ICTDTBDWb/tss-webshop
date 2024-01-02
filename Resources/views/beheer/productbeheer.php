<?php
    include basePath("Application/Http/beheer/menu.php");
     $auth->protectAdminPage(Auth::BEHEERDER_ROLES);

     $klantenservice = $auth->check_admin_rol([auth::KLANTENSERVICE_ROLE]);
     $seospecialist  = $auth->check_admin_rol([auth::SEOSPECIALIST_ROLE]);


     $disabled = $klantenservice || $seospecialist ? " disabled='disabled' " : "";
     $beschrijving_disabled = $klantenservice  ? " disabled='disabled' " : "";

    //database
    $database = new Database();
    $rootPath = $_SERVER['DOCUMENT_ROOT'];
    $media_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]";
    $afbeelding_path = $rootPath."/assets/afbeeldingen/";
    $product_categorie_post = [];


    $product_id = "";
    $product_naam = "";
    $product_prijs  = "";
    $product_aantal = "";
    $product_beschrijving= "";
    $product_merk  = "";
    $product_actief = "";
    $categorie_id = "";
    $categorie_beschrijving = "";
    $categorie_naam = "";
    $POST_GEWEEST = false;
    $alert = "";
    $alert_type ="";



     //get and post
    if (is_array($_POST) && !empty($_POST))
    {


        //var_dump($_POST);

        if(isset($_POST['opslaan']))
        {

            $POST_GEWEEST = true;
            $opslaan = $_POST['opslaan'];
            $product_id = array_key_exists("product_id", $_POST) ? $_POST['product_id'] : "";
            $product_naam = array_key_exists("product_naam", $_POST) ? $_POST['product_naam'] : "";
            $product_prijs = array_key_exists("product_prijs", $_POST) && is_numeric($_POST['product_prijs']) ? $_POST['product_prijs'] : 0.0;
            $product_aantal = array_key_exists("product_aantal", $_POST) && is_numeric($_POST['product_aantal']) ? $_POST['product_aantal'] : 0;
            $product_beschrijving = array_key_exists("product_beschrijving", $_POST) ? $_POST['product_beschrijving'] : "";
            $product_merk = array_key_exists("product_merk", $_POST) ? $_POST['product_merk'] : "";
            $product_actief = array_key_exists("product_actief", $_POST) ? $_POST['product_actief'] : "";
            $media_id = array_key_exists("media_id", $_POST) ? $_POST['media_id'] : "";
            $hoofd_afbeelding = array_key_exists("hoofd_afbeelding", $_POST) ? $_POST['hoofd_afbeelding'] : "";
            $youtube_url = array_key_exists('upload_url' , $_POST)  ? $_POST['upload_url'] : "";
            $product_categorie = [];



            $file = array_key_exists("upload_picture",$_FILES) ? $_FILES['upload_picture'] : [];
            $filename = array_key_exists("name",$file) ? $file['name'] : "";
            $filetype = array_key_exists("type",$file) ? $file['type']: "";
            $filesize = array_key_exists("size",$file) ? $file['size']: "";
            $filetmp_name = array_key_exists("tmp_name",$file) ? $file['tmp_name'] : "";
            $fileerror = array_key_exists("error",$file) ? $file['error'] : "";



            foreach($_POST as $key => $value) {
                if (str_contains($key, "checkbox_")) {
                    $key = str_replace("checkbox_", "", $key);
                    $product_categorie_post[$key] = $value;

                }

            }

            $categorie_id = array_key_exists("categorie_id", $_POST) ? $_POST['categorie_id'] : "";
            $categorie_beschrijving = array_key_exists("categorie_beschrijving", $_POST) ? $_POST['categorie_beschrijving'] : "";
            $categorie_naam = array_key_exists("categorie_naam",  $_POST) ? $_POST['categorie_naam'] : "";


            switch ($opslaan)
            {
                case "opslaan":
                    if ($product_id == "") {
                        $product_id = $database->query("INSERT INTO producten (`naam`,`beschrijving`, `merk`, `prijs`, `aantal`, `is_actief`, `is_verijderd`) VALUES (?,?,?,?,?,?,?) ", [$product_naam, $product_beschrijving, $product_merk, $product_prijs, $product_aantal, $product_actief, 0])->insert();
                        $alert_type = "success";
                        $alert = "<strong>Success!</strong> Product toegevoegd aan database.";

                    }
                    else
                    {
                        $database->query("UPDATE producten SET naam = ?, beschrijving = ?, merk = ? , prijs = ? , aantal = ?, is_actief = ?, is_verijderd = ? WHERE id = ? ", [$product_naam, $product_beschrijving, $product_merk, $product_prijs, $product_aantal, $product_actief, 0, $product_id]);
                        $data = $database->query("SELECT * FROM media where product_id = ?", [$product_id])->first();

                        $id = is_array($data) and array_key_exists( 'id', $data) ? $data['id'] : "";
                        if ($id != $hoofd_afbeelding and ($hoofd_afbeelding != "" or $id != ""))
                        {
                            $data2 = $database->query("SELECT * FROM media where id = ?", [$hoofd_afbeelding])->first();
                            if(is_array($data2) and array_key_exists("id", $data2)) {
                                $database->query("UPDATE media SET product_id = ?, naam = ? ,pad = ?, extensie = ? where id = ?", [$data2['product_id'], $data2['naam'], $data2['pad'], $data2['extensie'], $data['id']]);
                                $database->query("UPDATE media SET product_id = ?, naam = ? ,pad = ?, extensie = ? where id = ?",[$data['product_id'], $data['naam'], $data['pad'], $data['extensie'], $data2['id'] ] );
                            }
                            else
                            {
                                $alert_type = "warning";
                                $alert = "<strong>Waarschuwing!</strong> Product opgeslagen, maar hoofdafbeelding niet omgezet.";
                            }

                        }
                        else
                        {
                            $alert_type = "warning";
                            $alert = "<strong>Waarschuwing!</strong> Product opgeslagen, kan hoofdafbeelding niet vinden in database.";
                        }
                    }





                    $database->query("DELETE FROM product_categorieen where product_id = ?",[$product_id]);
                    if(count($product_categorie_post)> 0) {
                        // $query = "INSERT INTO product_categorieen ('product_id', 'categorie_id' ) VALUES "
                        // $values ="[";

                        foreach ($product_categorie_post as $key => $value) {
                            $database->query("INSERT INTO product_categorieen (`product_id`, `categorie_id` ) VALUES (?,?) ", [$product_id, $key])->get();

                        }

                    }
                    if($alert != "")
                    {
                        $alert_type = "success";
                        $alert = "<strong>Success!</strong> Product opgeslagen in database.";
                    }


                    $POST_GEWEEST = false;
                    break;


                case "toevoegen":
                    $product_id = $database->query("INSERT INTO producten (`naam`,`beschrijving`, `merk`, `prijs`, `aantal`, `is_actief`, `is_verijderd`) VALUES (?,?,?,?,?,?,?) ", [$product_naam, $product_beschrijving, $product_merk, $product_prijs, $product_aantal, $product_actief,0])->insert();
                    foreach ($product_categorie_post as $key => $value) {
                        $database->query("INSERT INTO product_categorieen (`product_id`, `categorie_id` ) VALUES (?,?) ", [$product_id, $key]);

                    }
                    $data = key($product_categorie_post);
                    var_dump($data);

                    $data = empty($data) ? "overig" : $data;
                    $alert_type = "success";
                    unset($_GET['Product']);
                    var_dump($product_id." ".$data);
                    $_GET['Product'] = $product_id." ".$data;
                    $alert = "<strong>Success!</strong> Product als nieuw product toegevoegd aan database.";
                    //$POST_GEWEEST = false;
                    break;

                case "verwijderen":
                    if ($product_id != "")
                    {
                        $database->query("UPDATE producten SET is_verijderd = ? where id = ?",[1,$product_id]);
                        //$database->query("DELETE FROM product_categorieen where product_id = ?",[$product_id]);
                        //$database->query("DELETE FROM producten where id = ?",[$product_id]);
                        $POST_GEWEEST = false;
                        unset($_GET['Product']);

                    }
                    $alert_type = "success";
                    $alert = "<strong>Success!</strong> Verwijderd uit database.";

                    break;

                case "wijzig_categorie":

                    $database->query("UPDATE categorieen SET naam = ?, beschrijving = ? where `id`= ?", [$categorie_naam, $categorie_beschrijving, $categorie_id])->get();
                    break;

                case "categorie_verwijderen":

                    $database->query("DELETE FROM product_categorieen where categorie_id = ?",[$categorie_id]);
                    $database->query("DELETE FROM categorieen where id = ?",[$categorie_id]);

                    break;

                case "categorie_toevoegen":

                    $database->query("INSERT INTO categorieen (`naam`, `beschrijving`) VALUES(?,?)",[$categorie_naam, $categorie_beschrijving]);

                break;

                case "upload_media" :

                     if( $product_id != "" and $filename != "")
                     {

                         $path_parts = pathinfo($afbeelding_path.$product_id."/".$filename);
                         $extensie = $path_parts['extension'];

                         if (!check_extentie($extensie))
                         {
                             $alert_type = "danger";
                             $alert = "<strong>Niet gelukt</strong> Wat u probeert op te slaan is geen afbeelding of video. afbeelding formaten zijn PNG/JPG/BMP/GIF, video zijn MP4";
                             break;
                         }


                         $gelukt = move_uploaded_file($filetmp_name, $afbeelding_path.$product_id."/".$filename);
                        //var_dump($path_parts);
                         $filename = $path_parts['filename'];

                         if ($gelukt) {
                             $data = $database->query("SELECT COUNT(*) FROM media WHERE product_id = ? and pad = ?", [$product_id, "/assets/afbeeldingen/" . $product_id . "/" . $filename])->get();

                             if ($data[0]['COUNT(*)'] == 0)
                                 $database->query("INSERT INTO media (`product_id`,`naam`,`pad`,`extensie`) VALUES(?,?,?,?)",[$product_id,$filename,"/assets/afbeeldingen/".$product_id."/".$filename,$extensie]);
                             else
                             {
                                 $alert_type = "danger";
                                 $alert = "<strong>Niet gelukt</strong> afbeelding bestaat al.";
                             }
                         }
                           // $database->query("INSERT INTO media (`product_id`,`naam`,`pad`,`extensie`) VALUES(?,?,?,?)",[$product_id,$filename,"/assets/afbeeldingen/".$product_id."/".$filename,$extensie]);

                     }

                     if ($product_id != "" and $youtube_url != "") {

                         if (!filter_var($youtube_url, FILTER_VALIDATE_URL))
                         {
                             $alert_type = "danger";
                             $alert = "<strong>Niet gelukt</strong> Geen valide URL.";
                             break;
                         }

                         if (!strpos($youtube_url, 'www.youtube') > 0)
                         {
                             $alert_type = "danger";
                             $alert = "<strong>Niet gelukt</strong> URL is geen youtube video.";
                             break;
                         }


                         $youtube_url = str_replace("watch?v=", "embed/", $youtube_url);
                         $database->query("INSERT INTO media (`product_id`,`naam`,`pad`,`extensie`) VALUES(?,?,?,?)", [$product_id, "youtube video", $youtube_url, "youtube"]);
                     }

                     if ($product_id == "")
                     {
                         $alert_type = "danger";
                         $alert = "<strong>Niet gelukt</strong> Kan geen afbeelding of video uploaden als product nog niet bestaat, klik eerst op opslaan.";
                     }




                break;

                case "media_verwijderen" :

                    if ($media_id != "")
                       $data = $database->query("SELECT * FROM media where id = ? ", [$media_id])->get();
                        $database->query("DELETE FROM media where id = ? ", [$media_id]);
                        $pad = array_key_exists('pad', $data[0]) ? $data[0]['pad'] : "";
                        $extensie = array_key_exists('extensie', $data[0]) ? $data[0]['extensie'] : "";


                        if( is_writable($rootPath.$pad.".".$extensie)) {
                            unlink($rootPath . $pad . "." . $extensie);

                        }

                break;

            }
        }
    }


     $filter ="";
     $product_select[0] = "";
     $product_select[1] = "";
     $product = "";
     if (is_array($_GET) && !empty($_GET))
     {

         $filter = array_key_exists("filter",$_GET) ? $_GET['filter'] : "";
         $filter = trim($filter);

         if(isset($_GET['Product'])) {
             $product_select = $_GET['Product'];
             $product_select = preg_split("/ /", $product_select);
             //$_POST['id']  = $product_select[0];
             if(!file_exists($afbeelding_path.$product_select[0]))
                 mkdir($afbeelding_path.$product_select[0],0755);


         }
     }

      $product = $database->query("SELECT * FROM producten where id = ?",[$product_select[0]])->get();

     // get categorien
     $categorieen = $database->query("SELECT * FROM categorieen ORDER BY id ASC")->get();


// filter products in categories
      $producten_categorie = [];
      foreach ($categorieen as $categorie)
      {
          $categorie_id = $categorie['id'];
          $producten_categorie[$categorie_id]['product'] = $database->query("SELECT * FROM producten where naam like ? and not is_verijderd = ? and id IN (SELECT `product_id` from product_categorieen where categorie_id  = ? ) ORDER BY naam ASC", ["%".$filter."%",1,$categorie_id] )->get();
          $producten_categorie[$categorie_id]['naam'] = $categorie['naam'];
          $producten_categorie[$categorie_id]['beschrijving'] = $categorie['beschrijving'];
      }
      //var_dump($producten_categorie);
        //filter prodcut with no categorie
      $producten_categorie['overig']['product'] = $database->query("SELECT * FROM producten WHERE naam like ? and not is_verijderd = ? and NOT EXISTS ( SELECT * FROM product_categorieen where product_categorieen.product_id = producten.id) ORDER BY naam ASC " , ["%".$filter."%",1])->get();
      $producten_categorie['overig']['naam'] = "overig";
      $producten_categorie['overig']['beschrijving'] = "";
      $producten_categorie['verwijderd']['naam'] = "verwijderd";
      $producten_categorie['verwijderd']['beschrijving'] = "";
      $producten_categorie['verwijderd']['product'] = $database->query("SELECT * FROM producten where naam like ? and is_verijderd = ?",["%".$filter."%",1])->get();





      if (is_array($product) and array_key_exists("0", $product)) {

          $product[0]["media"] = $database->query("SELECT * FROM media where product_id = ?", [$product[0]['id']])->get();
          $product[0]["categorie"] = $database->query("SELECT * FROM categorieen where id IN (SELECT `categorie_id` from product_categorieen where product_id = ?)",[$product[0]['id']])->get();
      }
          $product[0]["merken"] = $database->query("SELECT DISTINCT merk FROM producten")->get();
          if( !$POST_GEWEEST ) {
              $product_id = array_key_exists("id", $product[0]) ? $product[0]['id'] : "";
              $product_naam = array_key_exists("naam", $product[0]) ? $product[0]['naam'] : "";
              $product_prijs = array_key_exists("prijs", $product[0]) ? $product[0]['prijs'] : "";
              $product_aantal = array_key_exists("aantal", $product[0]) ? $product[0]['aantal'] : "";
              $product_beschrijving = array_key_exists("beschrijving", $product[0]) ? $product[0]['beschrijving'] : "";
              $product_merk = array_key_exists("merk", $product[0]) ? $product[0]['merk'] : "";
              $product_actief = array_key_exists("is_actief", $product[0]) ? $product[0]['is_actief'] : 0;
          }
          else
          {
              $query = "(";
              $query_items ="(";
              $gevonden_items = false;
              foreach ($product_categorie_post as $key => $item)
              {
                  if ($item == "true" or $item == "on"){
                      $query .= "?,";
                      $query_items .= "$key".",";
                      $gevonden_items = true;
                  }
              }

              $query = trim($query,',');
              $query_items = trim($query_items,',');
              $query .= ")";
              $query_items .=")";

              if ($gevonden_items)
                $product[0]["categorie"] = $database->query("SELECT * FROM categorieen where id IN " . $query_items)->get();

          }





     // }
      if ($product_id == "")
          $product[0]["media"] = "";








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

      unset($item);


?>







<!DOCTYPE html>

<style>
    aside {
         width:20%;
         #padding-right: 30px;
         float: left;
         overflow-y: auto;
         min-height: 80vh;
         max-height: 80vh;
         background-color:  lightgray;
         border-radius: 15px;
         text-align: center;




        }
   main{
       width:70%;
       float:right;
   }



    .d-block{
        width: 100%;
        height: 80%;


    }


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

    function afbeelding()
    {
        document.getElementById('selectimage').className = "btn btn-outline-secondary active"
        document.getElementById('selecturl').className = "btn btn-outline-secondary "
        //var mymodal = $('#upload_picture')
        //var selectimage = mymodal.getElementById('selectimage')
        //selectimage.class = "btn btn-outline-secondary"

        document.getElementById('formFile').type = "file"
        document.getElementById('formurl').type = "hidden"
        document.getElementById("labelurl").style.display = 'none';
        document.getElementById("labelfile").style.display = 'block';

        document.getElementById('formurl').value = "";



    }

    function youtube()
    {
        document.getElementById('selectimage').className = "btn btn-outline-secondary"
        document.getElementById('selecturl').className =  "btn btn-outline-secondary active"

        document.getElementById('formFile').type = "hidden"
        document.getElementById('formurl').type = "text"
        document.getElementById("labelurl").style.display = 'block';
        document.getElementById("labelfile").style.display = 'none';

        document.getElementById('formFile').value = "";

    }


    function insert_input(form_id)
    {


        const input = []
        input.push(["input", "hidden", "product_id", document.getElementsByName('product_id')[0].value])
        input.push(["input", "hidden", "product_naam", document.getElementsByName('product_naam')[0].value])
        input.push(["input", "hidden", "product_aantal", document.getElementsByName('product_aantal')[0].value])
        input.push(["input", "hidden", "product_beschrijving", document.getElementsByName('product_beschrijving')[0].value])
        input.push(["input", "hidden", "product_merk", document.getElementsByName('product_merk')[0].value] )
        input.push(["input", "hidden", "product_prijs", document.getElementsByName('product_prijs')[0].value])
        input.push(["input", "hidden", "product_actief", document.getElementsByName('product_actief')[0].value])

        var checkbox = document.querySelectorAll('[name^="checkbox_"]');

        checkbox.forEach((item) =>
        {

            input.push(["input", "hidden", item.name, item.checked])


        })

        input.forEach((item)=>
        {

            var a = document.createElement("input")

            a.setAttribute("type", "hidden")

            a.setAttribute("name", item[2])

            a.setAttribute("value", item[3])

            //append to form element that you want .
            document.getElementById(form_id).appendChild(a)
        })




    }






</script>


<main>
    <?php

    if ($alert !="")
        {
            echo "<div class='alert alert-$alert_type alert-dismissible fade show'>
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                    $alert
                  </div>";
        }

    ?>
    <form method="POST" action='' class="hidden"  enctype="multipart/form-data">
        <div class="row  align-items-top ">
            <!-- Carousel -->
            <div id="demo" class="carousel slide col " data-bs-ride="carousel" style="max-width:20vh; max-height:20vh; min-height: 20vh; min-width: 20vh; margin-left: 2vh; margin-right: 2vh" data-bs-interval="false">

                <!-- Indicators/dots -->

                <!-- The slideshow/carousel -->
                <div class="carousel-inner"  style="height: 100%; width: 100%" data-bs-interval="false"  >


                <?php echo make_media_carousel($product[0]["media"], $media_link, $disabled) ?>

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
                    <div class="row">
                        <div class="col" style='min-width: 70%'>
                            <label for="product_naam" class="form-label">Product Naam:</label>
                            <input type="text" class="form-control" id="product_naam" name="product_naam" aria-describedby="product_help" required="required" maxlength="255" <?php echo $disabled ?> value='<?php echo $product_naam ?>'>
                            <input type="hidden" class="form-control" id="product_id" name="product_id"   value='<?php echo $product_id ?>'>
                            <div id="product_help" class="form-text">verander of geef naam van product op.</div><br>
                        </div>
                        <div class="col">
                            <label for="product_actief" class="form-label">Product zichtbaar </label>
                            <select id="product_actief" class="form-select" name="product_actief" <?php echo $disabled ?>">
                                <?php

                                  if ( $product_actief == 0 )
                                  {
                                      echo  "<option value='1'>Ja</option>";
                                      echo  "<option value='0' selected>Nee</option>";
                                  }
                                  else
                                  {
                                      echo  "<option value='1' selected>Ja</option>";
                                      echo  "<option value='0' >Nee</option>";
                                  }
                                ?>


                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col" style='min-width: 50%'>
                            <label for="product_merk" class="form-label" >Product Merk:</label>
                            <input type="text" class="form-control" id="product_merk" name="product_merk" maxlength="255" <?php echo $disabled ?> value='<?php echo $product_merk ?>'  list="merknamen" >
                            <datalist id="merknamen">
                                <?php
                                echo make_option_list($product[0]["merken"]);
                                ?>
                            </datalist>
                        </div>
                        <div class="col" >
                            <label for="product_aantal" class="form-label" >aantal:</label>
                            <input type="number" class="form-control" id="product_aantal" name="product_aantal" min="0" <?php echo $disabled ?> value='<?php echo $product_aantal ?>'>
                        </div>
                        <div class="col">
                            <label for="product_prijs" class="form-label">prijs</label>
                            <div class="input-group mb-3">
                            <span class="input-group-text" id="product_prijs">€</span>
                            <input type="number" class="form-control" id="product_prijs" name="product_prijs" min="0.00" step="any" <?php echo $disabled ?> value='<?php echo $product_prijs ?>'>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="row">
            <div class="container col" style="max-width: 30%; align-content: flex-start" >
                <label for="hoofd_afbeelding" class="form-label">Hoofd afbeelding </label>
                <select id="hoofd_afbeelding" class="form-select" name="hoofd_afbeelding" <?php echo $disabled ?> >
                    <?php
                    foreach ($product[0]["media"] as $key => $item)
                    {
                        $id = $item['id'];
                        if ($key == 0)
                            echo "<option value='$id' selected >hoofd afbeelding</option>";
                        else
                            echo "<option value='$id' >pic $key</option>";
                    }
                    ?>
                </select><br>
                <!--<a class="btn btn-outline-secondary" href= /beheer/mediacategoriebeheer" style="width: 100%" role="button">Media beheer</a> -->
                <button type="button" class="btn btn-outline-secondary" style="width: 100%"  data-bs-toggle="modal" data-bs-target="#upload_picture" <?php echo $disabled ?>>Media toevoegen</button><br><br>

                <label for="categorie" class="form-label">Categorieen </label>
                <card class="card" style="max-height: 30vh; min-height: 30vh; overflow-y: auto; overflow-x: hidden" >
                   <?php echo checkbox_constructor($categorieen, $product, $disabled) ?>
                </card><br>
                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#categorietoevoegen" <?php echo $disabled ?> style="width: 100%">Categorie toevoegen</button>
            </div>
            <div class="col">
                <label for="beschrijving" class="form-label">Beschrijving</label>
                <textarea class="form-control" id="beschrijving" aria-label="With textarea" name="product_beschrijving" maxlength="4000" <?php echo $beschrijving_disabled ?> style="resize: none; height: 50vh" ><?php echo $product_beschrijving?> </textarea>
            </div>
        </div><br>

        <div class="row">
            <div class="col">
                <button type='submit' <?php echo $product_id == ""? "hidden" : "" ?> class="btn btn-outline-secondary" id="opslaan" name="opslaan" value="toevoegen"  <?php echo $disabled ?> style="width: 100%">Toevoegen als nieuw</button>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-outline-secondary" id="opslaan"  name="opslaan" value='opslaan'  <?php echo $beschrijving_disabled ?> style="width: 100%">Opslaan</button>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-outline-secondary" id="opslaan"  name="opslaan" value="verwijderen"  <?php echo $disabled ?> style="width: 100%">Verwijderen</button>
            </div>

        </div>







    </form>

    <div class="modal fade" tabindex="-1" id="upload_picture" >
        <form method="post" action="" id="form_upload_picture" enctype="multipart/form-data">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Media Uploaden</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Sluiten"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <div class='btn-group' role='group'>
                            <button type="button" class="btn btn-outline-secondary active" id="selectimage" onclick="afbeelding()">afbeelding/video</button>
                            <button type="button" class="btn btn-outline-secondary" id="selecturl" onclick="youtube()">youtube</button>
                        </div>
                        <label for="formFile" class="form-label" id="labelfile">Selecteer een afbeelding of video:</label>
                        <input class="form-control" type="file" accept="image/png, image/gif, image/jpeg, video/mp4" id="formFile" name="upload_picture">
                        <label for="formurl" class="form-label" id="labelurl" style="display: none">Geef URL van video op</label>
                        <input class="form-control" type="hidden"  id="formurl" name="upload_url">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                    <button type="submit" class="btn btn-primary" name="opslaan" value="upload_media"  onclick="insert_input('form_upload_picture')">Upload</button>
                </div>
            </div>
        </div>
        </form>
    </div>

    <div class="modal fade" tabindex="-1" id="categorietoevoegen" >
       <form method="post" action="" id="form_categorietoevoegen">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Categorie Toevoegen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Sluiten"></button>
                </div>
                <div class="modal-body">
                    <label for='categorie_naam' class='form-label'>Categorie Naam</label>
                    <input type='text' class='form-control' id='categorie_naam' required='required' maxlength='255' name='categorie_naam'  value=''>
                    <label for='categorie_beschrijving' class='form-label'>Categorie beschrijving</label>
                    <textarea class='form-control' id='categorie_beschrijving' aria-label='With textarea'  maxlength='255' name='categorie_beschrijving' style='resize: none; height: 10vh' ></textarea>
                </div>
                <div class="modal-footer">
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Annuleren</button>
                    <button type='submit' class='btn btn-primary' name='opslaan' value='categorie_toevoegen' onclick="insert_input('form_categorietoevoegen')">Opslaan</button>
                </div>
            </div>
        </div>
    </form>
    </div>



        <?php echo modal_verwijder_categorie($producten_categorie);
              echo modal_edit_categorie($producten_categorie);
              echo modal_verwijder_media($product[0]["media"])
              ?>



</main>

 <aside class="" id="aside">
     <form method="GET" action=''>
        <input type="search" value='<?php echo $filter ?>' class="form-control border" id="test" name="filter"/>



          <div class="accordion" id="accordionPanelsStayOpenExample">

             <?php echo arcordion_constructer($producten_categorie) ?>

         </div>
     </form>

 </aside>






