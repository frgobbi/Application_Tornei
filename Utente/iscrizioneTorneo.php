<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 13/04/2017
 * Time: 13:04
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
    <script src="Java-script/form_iscrizione.js" type="text/javascript"></script>
    <style type="text/css">

    </style>
    <script type="text/javascript">
        $('.loghi').hide();
        function info_t(id) {
            torneo(id);
            $('#modal_info_T').modal('show');
        }
        function num_g(min,max) {
            num_g_a = min-2;
            max_g = max-2;
            min_g =  min-2;
            for(var i=min-1; i<max-1;i++){
                var key = "#giocatore"+i;
                $(key).hide();
            }
        }
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
        <?php
        include "../connessione.php";
        $id_u = $_SESSION['username'];
        try {
            $oggAd = $connessione->query("SELECT * FROM `utente` WHERE username = '$id_u'")->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $connessione = null;

        echo "<div class=\"row\">"
            . "<div class=\"col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-xs-12\">"
            . "<div class=\"panel panel-primary\">"
            . "<div class=\"panel-body\">"
            . "<form method=\"post\" action=\"metodi/nuova_sq.php?user_ad=\">"
            . "<div id=\"resp_sq\">"
            . "<div id='Fnome_sq' class=\"form-group\">"
            . "<label for=\"nome_sq\">Nome Squadra:</label>"
            . "<input  type=\"text\" onblur='ControllaNome($torneo)' class=\"form-control\" id=\"nome_sq\" name=\"nome_sq\">"
            . "<span id='LOKnome_sq' class=\"loghi glyphicon glyphicon-ok form-control-feedback\" aria-hidden=\"true\"></span>"
            . "<span id='LEnome_sq' class=\"loghi glyphicon glyphicon-remove form-control-feedback\" aria-hidden=\"true\"></span>"
            . "</div>"

            . "<div class=\"form-group col-xs-6\">"
            . "<label for=\"name_ad\">Nome responsabile:</label>"
            . "<input type=\"text\" value=\"$oggAd->nome\" class=\"form-control\" id=\"name_ad\" name=\"name_ad\"
                                           readonly>"
            . "</div>"

            . "<div class=\"form-group col-xs-6\">"
            . "<label for=\"cognome_ad\">Cognome responsabile:</label>"
            . "<input type=\"text\" value=\"$oggAd->cognome\" class=\"form-control\" id=\"cognome_ad\"
                                           name=\"cognome_ad\" readonly>"
            . "</div>"

            . "<div class=\"form-group col-xs-6\">"
            . "<label for=\"data_ad\">Data di nascita responsabile:</label>"
            . "<input type=\"date\" value=\"$oggAd->data_nascita\" class=\"form-control\" id=\"data_ad\"
                                           name=\"data_ad\" readonly>"
            . "</div>"

            . "<div class=\"form-group col-xs-6\">"
            . "<label for=\"luogo_ad\">Luogo di nascita responsabile:</label>"
            . "<input type=\"text\" value=\"$oggAd->luogo_nascita\" class=\"form-control\" id=\"luogo_ad\" name=\"luogo_ad\"
                                           readonly>"
            . "</div>"

            . "<div class=\"form-group col-xs-6\">"
            . "<label for=\"cod_ad\">Codice Fiscale responsabile:</label>"
            . "<input type=\"text\" value=\"$oggAd->codice_fiscale\" class=\"form-control\" id=\"cod_ad\"
                                           name=\"cod_ad\" readonly>"
            . "</div>"

            . "<div class=\"form-group col-xs-6\">"
            . "<label for=\"res_ad\">Residenza responsabile:</label>"
            . "<input type=\"text\" value=\"$oggAd->residenza\" class=\"form-control\" id=\"res_ad\" name=\"res_ad\"
                                           readonly>"
            . "</div>"

            . "<div class=\"form-group container-fluid\">"
            . "<label for='gioco'>Vuoi partecipare come giocatore?   </label>"

            . "<div class=\"form-group\">"
            . "<label class=\"radio-inline\">"
            . "<input type=\"radio\" name=\"gioco\" checked id=\"gioco\" value=\"si\"> Si "
            . "</label>"
            . "<label class=\"radio-inline\">"
            . "<input type=\"radio\" name=\"gioco\" id=\"gioco\" value=\"no\"> No "
            . "</label>"
            . "</div>"
            . "</div>"

            . "<div class=\"alert alert-warning\">"
            . "<strong>Attenzione!</strong> Se rispondi No non potrai giocare le partite!! "
            . "</div>"

            . "<div class=\"row\">"
            . "<ul class=\"pager\">"
            . "<li>"
            . "<a href=\"#\" onclick='nextPag($torneo)'>Avanti <i class=\"fa fa-arrow-right\" aria-hidden=\"true\"></i></a></li>"
            . "</ul>"
            . "</div>"

            . "</div>"
            . "<div id=\"g_sq\">"
            . "<div class='row'>"
            . "<div class='col-lg-12 text-center'><h3>Dati Giocatori</h3></div>"
            . "</div>"
            . "<div class=\"alert alert-info\">"
            . "<strong>Importante!</strong> Inserisci i dati dei giocatori tranne i dati del responsabile di squadra!"
            . "</div>"
            . "<div class='table-responsive'>"
            . "<table class=\"table table-hover\">"
            . "<thead>"
            . "<tr>"
            . "<th>Nome</th>"
            . "<th>Cognome</th>"
            . "<th>Data di nascita</th>"
            . "<th>Luogo di nascita</th>"
            . "<th>Codice Fiscale</th>"
            . "<th>Residenza</th>"
            . "<th>Sesso</th>"
            . "</tr>"
            . "</thead>"
            . "<tbody>";
        for ($i = 0; $i < ($oggTorneo->num_giocatori_max - 1); $i++) {
            echo "<tr id='giocatore$i'>"
                . "<td><input type=\"text\" placeholder=\"Nome\" onblur='cercaUtenti($torneo,$i)' id='nome$i' name='nome$i' onblur=\"\" class=\"form-control\"></td>"
                . "<td><input type=\"text\" placeholder=\"Cognome\" onblur='cercaUtenti($torneo,$i)' id='cognome$i' name='cognome$i' onblur=\"\" class=\"form-control\"></td>"
                . "<td><input type=\"date\" id='data$i' name='data$i' class=\"form-control\"></td>"
                . "<td><input type=\"text\" placeholder=\"Luogo di nascita\"id='luogo$i' name='luogo$i' class=\"form-control\"></td>"
                . "<td><input type=\"text\" placeholder=\"Codice Fiscale\" onblur='giocatoreGiaIscritto($torneo,$i)' id='cod$i' name='cod$i' class=\"form-control\" onkeyup=\"this.value = this.value.toLocaleUpperCase();\"></td>"
                . "<td><input type=\"text\" placeholder=\"Via\" id='res$i' name='res$i' class=\"form-control\"></td>"
                . "<td><select style='width:80px;' class=\"form-control\" id=\"sesso$i\" name=\"sesso$i\"><option value='M' selected>M</option><option value='F'>F</option></select></td>"
                . "</tr>"
                . "<tr class='alertG' id='alert$i'><td colspan='6'><div class='alert alert-danger'><strong>Errore</strong> L'utente e' gia' iscritto con un'altra squadra</div></td></tr>";
        }
        echo "</tbody>"
            . "</table>"
            . "</div>";
        echo "<div class='row container-fluid'>"
            ."<div class='col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12'>"
            ."<div class=\"btn-group btn-group-justified\">"
            ."<a href=\"#\" onclick='removeGiocatore()' class=\"btn btn-danger btn-lg\">Rimuovi Giocatore</a>"
            ."<a href=\"#\" onclick='addGiocatore()' class=\"btn btn-primary btn-lg\">Aggiungi Giocatore</a>"
            ."</div>"
            ."</div>"
            ."</div>";

        echo "<div style='padding-top: 30px;' class='row container-fluid'>"
            ."<button type='button' onclick='invia(\"$oggAd->username\",$torneo)' class='btn btn-primary btn-block'>Iscriviti al torneo</button>"
            ."</div>"
            ."<div id='ruota' style=\"padding-top:30px;\" class=\"row container-fluid\">"
            ."<div class='col-lg-4 col-md-4 col-lg-offset-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-12 text-center'>"
            ."<i class=\"fa fa-spinner fa-pulse fa-3x fa-fw\"></i>"
            ."<span class=\"sr-only\">Loading...</span>"
            ."</div>"
            ."</div>";

        echo "<div class=\"row\">"
            . "<ul class=\"pager\">"
            . "<li>"
            . "<a href=\"#\" onclick='indietro()'><i class=\"fa fa-arrow-left\" aria-hidden=\"true\"></i> Indietro</a></li>"
            . "</ul>"
            . "</div>"
            . "</div>"
            . "</form>"

            . "</div>"
            . "</div>"
            . "</div>";

        echo "<script type='text/javascript'>"
            ."num_g($oggTorneo->num_giocatori_min,$oggTorneo->num_giocatori_max)"
            ."</script>";
        ?>
    </div>
</div>
</div>
<script type="text/javascript">
    $('.loghi').hide();
    $('#g_sq').hide();
    $('.alertG').hide();
    $('#ruota').hide();
</script>

<!-- Modal -->
<div id="modal_utenti" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Utenti</h4>
            </div>
            <div id="body_utenti" class="modal-body">
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

</body>
</html>