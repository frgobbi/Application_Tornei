<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 19/04/2017
 * Time: 15:36
 */
$esito = filter_input(INPUT_GET, "esito", FILTER_SANITIZE_STRING);
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
    <!--<script src="Java-script/form_iscrizione.js" type="text/javascript"></script>-->
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
    $torneo = filter_input(INPUT_GET, "id_t", FILTER_SANITIZE_STRING);
    include "../connessione.php";
    try {
        $sql = "SELECT `id_torneo`,`nome_torneo`,`min_sq`,`max_sq`,`num_giocatori_min`,`num_giocatori_max`, DATE_FORMAT(data_inizio,'%d-%m-%Y') AS inizio, `data_inizio`, DATE_FORMAT(data_f_iscrizioni,'%d-%m-%Y') AS Fiscirizioni,`data_f_iscrizioni`, DATE_FORMAT(data_fine,'%d-%m-%Y') AS fine,`data_fine`,`info`,tipo_sport.descrizione AS sport, `min_anno`, `max_anno`, `fase_finale`,`finished` "
            . "FROM `torneo` INNER JOIN tipo_sport ON tipo_sport.id_tipo_sport = torneo.id_sport WHERE id_torneo= '$torneo'";
        $oggTorneo = $connessione->query($sql)->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
        echo "error: " . $e->getMessage();
    }
    $connessione = null;
    ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <?php
                echo "<h1 class=\"page-header\"> $oggTorneo->nome_torneo <small> Torneo di $oggTorneo->sport</small></h1>"
                    . "<ol class=\"breadcrumb\">"
                    . "<li>"
                    . "<i class=\"fa fa-dashboard\"></i>  <a href=\"../Home/home.php\">Dashboard</a>"
                    . "</li>"
                    . "<li>"
                    . "<i class=\"fa fa-pencil-square-o\"></i>  <a href=\"Tornei_disp.php\">Tornei disponibili</a>"
                    . "</li>"
                    . "<li class=\"active\">"
                    . "<i class=\"fa fa-trophy\" aria-hidden=\"true\"></i>  $oggTorneo->nome_torneo"
                    . "</li>"
                    . "</ol>";
                ?>
            </div>
        </div>
        <div style="padding-top: 30px;" class="row">
            <div class="col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2 col-sm-12">
                <div class="well">
                    <div class="row container-fluid">
                        <div class="col-lg-12 text-center">
                            <?php
                            switch ($esito) {
                                case 0:
                                    echo "<h3 class='text-primary'>Iscrizione avvenuta con successo</h3>";
                                    break;
                                case 1:
                                    echo "<h3 class='text-danger'>Qualcosa è andato storto... riprova ad'iscriverti</h3>";
                                    break;
                                case 2:
                                    echo "<h3 class='text-primary'>Iscrizione avvenuta con successo</h3>";
                                    break;
                                case 3:
                                    echo "<h3 class='text-danger'>Iscrizione non completata</h3>";
                                    break;
                                case 4:
                                    echo "<h3 class='text-danger'>Iscrizione non completata</h3>";
                                    break;
                            }

                            switch ($esito) {
                                case 0:
                                    echo "<div class=\"alert alert-success\">"
                                        . "<strong>Iscrizione Avvenuta!</strong> La tua iscrizione e' stata completata correttamente<br>"
                                        . "</div>";
                                    break;
                                case 1:
                                    echo "<button type=\"button\" onclick='window.location.href=\"iscriviSquadra.php?id_t=$torneo\"' class=\"btn btn-link\">Pagina di iscrizione</button>";
                                    break;
                                case 2:
                                    echo "<div class=\"alert alert-warning\">"
                                        . "<strong>Attenzione!</strong> Hai inserito giocatori gia' iscritti con altre squadre!<br>"
                                        . "Puoi aggiungere i giocatori mancanti nella tua area del torneo, prima del termine delle iscrizioni!"
                                        . "</div>";
                                    break;
                                case 3:
                                    echo "<div class=\"alert alert-danger\">"
                                        . "<strong>Errore!</strong> Hai inserito un numero di giocatori minore del minimo consentito!<br>"
                                        . "Puoi aggiungere i giocatori mancanti nella tua area del torneo, prima del termine delle iscrizioni o si iscrivano il numero massimo di squadre!"
                                        . "</div>";
                                    break;
                                case 4:
                                    echo "<div class=\"alert alert-danger\">"
                                        . "<strong>Errore!</strong> Hai inserito un numero di giocatori minore del minimo consentito!<br>"
                                        . "Puoi aggiungere i giocatori mancanti nella tua area del torneo, prima del termine delle iscrizioni o si iscrivano il numero massimo di squadre!"
                                        . "</div>";
                                    echo "<div class=\"alert alert-warning\">"
                                        . "<strong>Attenzione!</strong> Hai inserito giocatori gia' iscritti con altre squadre!<br>"
                                        . "Puoi aggiunge i giocatori mancanti nella tua area del torneo, prima del termine delle iscrizioni o si iscrivano il numero massimo di squadre!"
                                        . "</div>";
                                    break;
                            }

                            if ($esito != 1) {
                                echo "<h3 class='text-primary'>Ti abbiamo inviato una mail con i dati per l'accesso al sito per la tua squadra!</h3>"
                                    . "<div class=\"row\">"
                                    . "<div class=\"col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-12 col-xs-12\">"
                                    . "<button onclick=\"window.location.href='../Home/home.php'\" class=\"btn btn-primary btn-block\">Home page</button>"
                                    . "</div>"
                                    . "</div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
</html>