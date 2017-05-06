<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 11/04/2017
 * Time: 12:28
 */
session_start();
if (!$_SESSION['login']) {
    header("Location:../index.php");
}
if (!($_SESSION['tipo_utente'] == 1 || $_SESSION['tipo_utente'] == 4)) {
    header("Location:../Home/home.php");
}
?>
<html>
    <head>
        <?php
        include '../Componenti_Base/Head.php';
        LibrerieLogin();
        ?>
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
            <div class="row" style="padding-top: 30px;">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">I miei tornei</div>
                        <div class="panel-body" style="height: 550px; overflow-y: auto">
                            <?php
                                include "../connessione.php";
                                try{
                                    $user_u = $_SESSION['username'];
                                    $sql = "SELECT tipo_sport.colore, torneo.id_torneo, torneo.nome_torneo, squadra.id_sq, tipo_sport.descrizione, tipo_sport.logo FROM `squadra` "
                                    ."INNER JOIN sq_utente ON squadra.id_sq = sq_utente.id_sq "
                                    ."INNER JOIN utente ON utente.username = sq_utente.username "
                                    ."INNER JOIN torneo ON squadra.id_torneo = torneo.id_torneo "
                                    ."INNER JOIN tipo_sport ON torneo.id_sport = tipo_sport.id_tipo_sport "
                                    ."WHERE utente.username = '$user_u' AND squadra.eliminata = 0 AND torneo.finished = 0";
                                    foreach ($connessione->query($sql) as $row){
                                        $colore = $row['colore'];
                                        $icona = $row['logo'];
                                        $nome_torneo = $row['nome_torneo'];
                                        $tipo_sport = $row['descrizione'];
                                        $id_sq = $row['id_sq'];
                                        $id_t = $row['id_torneo'];
                                        echo "<a href='adminMyTornei.php?id_sq=$id_sq&id_t=$id_t'>";
                                        echo "<div class=\"panel panel-$colore\">"
                                            ."<div class=\"panel-heading\">"
                                                ."<div class='row'>"
                                                    ."<div class='col-lg-3 col-md-3 col-sm-12 col-xs-12'><i class=\"fa $icona fa-5x\" aria-hidden=\"true\"></i></div>"
                                                    ."<div class='col-lg-9 col-md-9 col-sm-12 col-xs-12 text-right'>"
                                                        ."<h3>$nome_torneo <smal>$tipo_sport</smal></h3>"
                                                    ."</div>"
                                                ."</div>"
                                            ."</div>"
                                        ."</div>";
                                        echo "</a>";
                                    }
                                } catch (PDOException $e){
                                    echo $e->getMessage();
                                }
                                $connessione = null;
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">I miei tornei conclusi</div>
                        <div class="panel-body" style="height: 550px; overflow-y: auto">
                            <?php
                            include "../connessione.php";
                            try{
                                $user_u = $_SESSION['username'];
                                $sql = "SELECT tipo_sport.colore, torneo.id_torneo, torneo.nome_torneo, squadra.id_sq, tipo_sport.descrizione, tipo_sport.logo FROM `squadra` "
                                    ."INNER JOIN sq_utente ON squadra.id_sq = sq_utente.id_sq "
                                    ."INNER JOIN utente ON utente.username = sq_utente.username "
                                    ."INNER JOIN torneo ON squadra.id_torneo = torneo.id_torneo "
                                    ."INNER JOIN tipo_sport ON torneo.id_sport = tipo_sport.id_tipo_sport "
                                    ."WHERE utente.username = '$user_u' AND squadra.eliminata = 0 AND torneo.finished = 1";
                                foreach ($connessione->query($sql) as $row){
                                    $colore = $row['colore'];
                                    $icona = $row['logo'];
                                    $nome_torneo = $row['nome_torneo'];
                                    $tipo_sport = $row['descrizione'];
                                    $id_sq = $row['id_sq'];
                                    $id_t = $row['id_torneo'];
                                    echo "<a href='adminMyTornei.php?id_sq=$id_sq&id_t=$id_t'>";
                                    echo "<div class=\"panel panel-$colore\">"
                                        ."<div class=\"panel-heading\">"
                                        ."<div class='row'>"
                                        ."<div class='col-lg-3 col-md-3 col-sm-12 col-xs-12'><i class=\"fa $icona fa-5x\" aria-hidden=\"true\"></i></div>"
                                        ."<div class='col-lg-9 col-md-9 col-sm-12 col-xs-12 text-right'>"
                                        ."<h3>$nome_torneo <smal>$tipo_sport</smal></h3>"
                                        ."</div>"
                                        ."</div>"
                                        ."</div>"
                                        ."</div>";
                                    echo "</a>";
                                }
                            } catch (PDOException $e){
                                echo $e->getMessage();
                            }
                            $connessione = null;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    </body>
</html>