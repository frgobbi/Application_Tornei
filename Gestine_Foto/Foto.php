<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 30/11/2016
 * Time: 21:46
 */
session_start();

function mese($mese)
{
    $StringMese = "";
    //$mese = ltrim($mese, '0');
    switch ($mese) {
        case 1:
            $StringMese = "GEN";
            break;
        case 2:
            $StringMese = "FEB";
            break;
        case 3:
            $StringMese = "MAR";
            break;
        case 4:
            $StringMese = "APR";
            break;
        case 5:
            $StringMese = "MAG";
            break;
        case 6:
            $StringMese = "GIU";
            break;
        case 7:
            $StringMese = "LUG";
            break;
        case 8:
            $StringMese = "AGO";
            break;
        case 9:
            $StringMese = "SET";
            break;
        case 10:
            $StringMese = "OTT";
            break;
        case 11:
            $StringMese = "NOV";
            break;
        case 12:
            $StringMese = "DIC";
            break;
    }
    return $StringMese;
}


if (!$_SESSION['login']) {
    header("Location:../index.php");
}
if (!($_SESSION['tipo_utente'] == 1 || $_SESSION['tipo_utente'] == 2)) {
    header("Location:../Home/home.php");
}
?>
<html>
<head>
    <?php
    include '../Componenti_Base/Head.php';
    LibrerieLogin();
    ?>
    <link rel="stylesheet" href="../Librerie/CSS/event-list.css">
    <style type="text/css">
    </style>
    <script type="text/javascript">
    </script>
</head>
<body>
<div id="wrapper">
    <?php
    require '../Componenti_Base/Nav-SideBar.php';
    navLogin();
    ?>
    <div id="page-wrapper">
        <div style="padding-top: 30px; " class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-3">
                                <i class="fa fa-picture-o fa-5x" aria-hidden="true"></i>
                            </div>
                            <div class="col-md-9 text-right">
                                <h3>Foto Homepage</h3>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer"></div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"></div>
        </div>
    </div>
</div>
</body>
</html>