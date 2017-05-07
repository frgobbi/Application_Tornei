<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 07/05/2017
 * Time: 21:18
 */
session_start();

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
            <div class="col-xs-12">
                <div class="alert alert-info">
                    <strong>Attenzione!</strong> Funzionalità ancora non disponibile.
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>