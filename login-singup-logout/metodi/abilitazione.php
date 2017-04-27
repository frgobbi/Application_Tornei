<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 22/11/2016
 * Time: 19:53
 */
$user = filter_input(INPUT_GET, "utente",FILTER_SANITIZE_STRING);
include "../../connessione.php";
try{
    $connessione->exec("UPDATE `utente` SET `attivo` = '1' WHERE `utente`.`username` = '$user'");
} catch (PDOException $e){
    echo "error: ".$e->getMessage();
}
$connessione = null;
// Inserire la grafica
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Nuova App</title>

        <link href="../../Librerie/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../../Librerie/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
        <link href="../../Librerie/CSS/sb-admin-2.css" rel="stylesheet">
        <link href="../../Librerie/vendor/morrisjs/morris.css" rel="stylesheet">
        <link href="../../Librerie/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

        <script src="../../Librerie/vendor/jquery/jquery.min.js"></script>
        <script src="../../Librerie/vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="../../Librerie/vendor/metisMenu/metisMenu.min.js"></script>
        <script src="../../Librerie/vendor/raphael/raphael.min.js"></script>
        <script src="../../Librerie/vendor/morrisjs/morris.min.js"></script>
        <script src="../../Librerie/Java-script/morris-data.js"></script>
        <script src="../../Librerie/Java-script/sb-admin-2.js"></script>
    </head>
    <body>
    <div class="container">
        <!-- Modal -->
        <div class="modal fade" data-, data-backdrop="static" id="myModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
                        <h4 class="modal-title text-primary">Account abilitato</h4>
                    </div>
                    <div class="modal-body">
                        <p class="h4 text-primary">Ora puoi accedere alla piattaforma.</p>
                        <p class="h6">La pagina si aggiornera tra 5 secondi...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('#myModal').modal('show');
        document.body.disabled = true;
    </script>
    </body>
</html>

<script type="text/javascript">
	setTimeout(function(){ 
		window.location.href="../../index.php";
	 }, 5000);
</script>