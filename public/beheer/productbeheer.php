

<?php include __DIR__ . '/../../application/beheer/productbeheer.php'; ?> <!--Verander example.php naar jouw gewenste file-->

<!DOCTYPE html>

<style>
    aside {
         width:20%;
         #padding-right: 30px;
         float: left;
         overflow-y: auto;
         min-height: 1080px;
         max-height: 1080px;
         background-color:  lightgray;
         border-radius: 15px;
         text-align: center;




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


</script>


<html lang="en">
    <!--Head-->
    <?php include __DIR__ . "/../../application/components/layout/head.php"; ?>
    <?php $producten = create_buttons("") ?>


    <body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
        <!--Header-->
        <?php include __DIR__ . "/../../application/components/layout/header.php"; ?>


        <!--Pagina content container-->
        <div class="container-lg flex-grow-1 gx-0 py-4" >
             <input type="button" value="test" id="test" class="button" onclick="<?php $producten = create_buttons(""); ?>"    />
             <aside class="max-vh-100 " id="aside">
                 <?php echo $producten ?>



             </aside>





        </div>

        <!--Footer & Scripts-->
    <?php include __DIR__ . "/../../application/components/layout/footer.php"; ?>
    <?php include __DIR__ . "/../../application/components/layout/scripts.php"; ?>
    </body>
</html>