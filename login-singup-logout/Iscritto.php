<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 29/11/2016
 * Time: 09:55
 */
?>
<html xmlns="http://www.w3.org/1999/html">
    <head>
        <?php
        include '../Componenti_Base/Head.php';
        LibrerieUnLog()
        ?>
</head>
<body>
<div id="wrapper">
    <?php
    require '../Componenti_Base/Nav-SideBar.php';
    navUnLog();
    ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3 col-md-4 col-md-offset-4 col-sm-12 col-xs-12">
                <br>
                <div class="jumbotron">
                        <div style="text-align: center;" class="h2">Iscrizione effettuata con successo</div>
                        <div style="text-align: center;" class="h5">Controlla la tua mail per poter attivare il tuo account!</div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>