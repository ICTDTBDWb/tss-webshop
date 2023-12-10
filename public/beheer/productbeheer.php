
<?php include __DIR__ . "/../../Application/DatabaseManager.php"?>
<?php include __DIR__ . "/../../Application/SessionManager.php"?>



<?php include __DIR__ . '/../../Application/Http/beheer/productbeheer.php'; ?> <!--Verander example.php naar jouw gewenste file-->
<?php
     $session = \application\SessionManager::getInstance();
     $filter = $session->exists("POST_FILTER_BEHEERITEM") ? $session->get("POST_FILTER_BEHEERITEM") : "" ;
     if (is_array($_POST) && !empty($_POST))
     {
         $filter = filter_input(INPUT_POST, 'filter', FILTER_SANITIZE_SPECIAL_CHARS);
     }
     $session->set("POST_FILTER_BEHEERITEM", $filter);
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
                 <form method="Post" action=''>
                     <input type="search" value='<?php echo $filter ?> ' class="form-control border" id="test" name="filter"/>
                 </form>
                 <?php include __DIR__ . "/../../Application/Http/beheer/productbeheer_items.php" ?>
             </aside>



        </div>

        <!--Footer & Scripts-->
    <?php include __DIR__ . "/../../Resources/components/layout/footer.php"; ?>
    <?php include __DIR__ . "/../../Resources/components/layout/scripts.php"; ?>
    </body>
</html>