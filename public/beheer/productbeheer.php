
<?php include __DIR__ . "/../../Application/DatabaseManager.php"?>
<?php include __DIR__ . "/../../Application/SessionManager.php"?>



<?php include __DIR__ . '/../../Application/Http/beheer/productbeheer.php'; ?> <!--Verander example.php naar jouw gewenste file-->
<?php
     // sessie
     $session = \application\SessionManager::getInstance();


     //get and post
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
          $producten_categorie[$categorie['naam']] = $database->query("SELECT * FROM producten inner join product_categorieen where product_id = producten.id and categorie_id  = ? and naam like ? ORDER BY naam ASC", [$categorie_id, "%".$filter."%"] )->get();
      }
        //filter prodcut with no categorie
      $producten_categorie['overig'] = $database->query("SELECT * FROM producten WHERE naam like ? and NOT EXISTS ( SELECT * FROM product_categorieen where product_categorieen.product_id = producten.id) ORDER BY naam ASC " , ["%".$filter."%"])->get();
      //close database;
      $database->close();

      //check selected or filter active
      foreach  ($producten_categorie as $key => &$item)
      {
          //button pressed
          foreach($item as $_key => $value) {
              $item[$_key]['show'] = $filter != "" ? "" : "collapse";
              if ($value['id'] == $product_select[0] && $key == $product_select[1]) {
                  $item[$_key]['active'] = "Active";
                  $item['show'] = "";
              } else
                  $item[$_key]['active'] = "";


          }
          //filter on categorie
          $item['show'] = ($filter != "" && count($item) > 0) || array_key_exists("show", $item) ? "" : "collapsed";
          //if categorie is shown, make all buttons show up
          foreach($item as $_key => $value)
          {
              if( $item['show'] = "")
              {
                  $item[$_key]['show'] = "";
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

<script>
    //var auto_refresh = setInterval( function (){$("aside").load("/../productbeheer.php");},1000); })

    function myFunction() {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById("test");
        filter = input.value.toUpperCase();
        ul = document.getElementById("product_item_button");
        li = ul.getElementsByTagName("input");
        for (i = 0; i < li.length; i++) {
            a = li['value']
            txtValue = a.textContent || a.innerText;
            print(txtValue);
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li.style.display = "";
            } else {
                li.style.display = "none";
            }
        }
    }

</script>
<?php $producten = create_buttons(""); ?>

<html lang="en">
    <!--Head-->

    <?php include __DIR__ . "/../../Resources/components/layout/head.php"; ?>



    <body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
        <!--Header-->
        <?php include __DIR__ . "/../../Resources/components/layout/header.php"; ?>


        <!--Pagina content container-->
        <div class="container-lg flex-grow-1 gx-0 py-4" >
            <main>
                <?php include __DIR__ . "/../../Application/Http/beheer/productbeheer_form.php" ?>
            </main>

             <aside class="" id="aside">
                 <form method="GET" action=''>
                  <div class="coll">
                     <div class="row">
                        <input type="search" value='<?php echo $filter ?> ' class="form-control border" id="test" name="filter"/>
                     </div>
                     <div class="row">
                         <select id="Merkselectie" class="form-select">
                             <option selected>Categorie</option>
                             <option>Merk</option>
                         </select>
                     </div>
                  </div>
                     <?php include __DIR__ . "/../../Application/Http/beheer/productbeheer_items.php" ?>
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