<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 29/04/2017
 * Time: 12:19
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
    <script style="text/javascript" src="Java-script/myTornei.js"></script>
    <style type="text/css">
    </style>
    <script type="text/javascript">
        function apriPopup(id_p, id_torneo){
            creaPopup(id_p, id_torneo);
            $('#partita').modal('show')
        }
    </script>
</head>
<body>
<div id="wrapper">
    <?php
    require '../Componenti_Base/Nav-SideBar.php';
    navLogin();
    $torneo = filter_input(INPUT_GET, "id_t", FILTER_SANITIZE_STRING);
    $id_sq = filter_input(INPUT_GET, "id_sq", FILTER_SANITIZE_STRING);
    $id_u = $_SESSION['username'];
    include "../connessione.php";
    try {
        $sql = "SELECT `id_torneo`,`nome_torneo`,`min_sq`,`max_sq`,`num_giocatori_min`,`num_giocatori_max`, DATE_FORMAT(data_inizio,'%d-%m-%Y') AS inizio, `data_inizio`, DATE_FORMAT(data_f_iscrizioni,'%d-%m-%Y') AS Fiscirizioni,`data_f_iscrizioni`, DATE_FORMAT(data_fine,'%d-%m-%Y') AS fine,`data_fine`,`info`,tipo_sport.descrizione AS sport, `min_anno`, `max_anno`, `fase_finale`,`finished` "
            . "FROM `torneo` INNER JOIN tipo_sport ON tipo_sport.id_tipo_sport = torneo.id_sport WHERE id_torneo= '$torneo'";
        $oggTorneo = $connessione->query($sql)->fetch(PDO::FETCH_OBJ);
        $oggSQ = $connessione->query("SELECT * FROM squadra WHERE id_sq = '$id_sq'")->fetch(PDO::FETCH_OBJ);
        $num_giocatori = $connessione->query("SELECT * FROM `sq_utente` WHERE `id_sq` = '$id_sq'")->rowCount();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $connessione = null;
    ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <?php
                echo "<h1 class=\"page-header\"> $oggSQ->nome_sq <small> $oggTorneo->nome_torneo</small></h1>"
                    . "<ol class=\"breadcrumb\">"
                    . "<li>"
                    . "<i class=\"fa fa-dashboard\"></i>  <a href=\"../Home/home.php\">Dashboard</a>"
                    . "</li>"
                    . "<li>"
                    . "<i class=\"fa fa-cog\"></i>  <a href=\"My_Tornei.php\">I miei tornei</a>"
                    . "</li>"
                    . "<li class=\"active\">"
                    . "<i class=\"fa fa-trophy\" aria-hidden=\"true\"></i>  $oggTorneo->nome_torneo"
                    . "</li>"
                    . "</ol>";
                ?>
            </div>
        </div>
        <?php
        if($oggSQ->iscritta == 0){
            echo "<div class=\"row\">"
            . "<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs12\">"
                . "<div class=\"alert alert-warning alert-dismissable\">"
                    . "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>"
                    . "<strong>Attenzione!</strong> Non hai completato l'iscrizione!! Aggiungi i giocatori mancati!"
                . "</div>"
            . "</div>"
            . "</div>";
        }

        if($oggSQ->eliminata == 1){
            echo "<div class=\"row\">"
                . "<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs12\">"
                . "<div class=\"alert alert-danger alert-dismissable\">"
                . "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>"
                . "La squadra è stata eliminata dal torneo!"
                . "</div>"
                . "</div>"
                . "</div>";
        }
        ?>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs12">
                    <?php
                    echo "<div class=\"panel panel-primary\">"
                        . "<div style='padding: 0px; height:225px; overflow-y: auto' class=\"panel-body table-responsive\">";
                    $sql = "SELECT partita.id_partita, partita.luogo,"
                        . "DATE_FORMAT(partita.data_partita,'%d-%m-%Y') AS data,"
                        . "DATE_FORMAT(partita.ora_partita,'%H:%i') AS ora "
                        . "FROM `partita` INNER JOIN sq_partita ON sq_partita.id_partita = partita.id_partita "
                        . "INNER JOIN squadra ON sq_partita.id_sq = squadra.id_sq "
                        . "WHERE id_torneo = '$torneo' AND squadra.id_sq = '$id_sq' GROUP BY(partita.id_partita)";

                    echo "<table class=\"table table-bordered table-hover\">"
                        . "<thead>"
                        . "<tr>"
                        . "<th>Squadra 1</th>"
                        . "<th>  </th>"
                        . "<th>Squadra 2</th>"
                        . "<th>Data</th>"
                        . "<th>Ora</th>"
                        . "<th>Luogo</th>"
                        . "</tr>"
                        . "</thead>"
                        . "<body>";
                    include "../connessione.php";
                    try {
                        foreach ($connessione->query($sql) as $row) {
                            $ora = $row['ora'];
                            $data = $row['data'];
                            $luogo = $row['luogo'];
                            $id_p = $row['id_partita'];
                            $sq = array();
                            foreach ($connessione->query("SELECT squadra.id_sq, squadra.nome_sq FROM `sq_partita` INNER JOIN squadra ON sq_partita.id_sq = squadra.id_sq WHERE id_partita = $id_p") as $riga) {
                                $sq[] = array($riga['id_sq'], $riga['nome_sq']);
                            }

                            echo "<tr onclick=\"apriPopup($id_p, $torneo)\">"
                                . "<td>" . $sq[0][1] . "</td>"
                                . "<td>VS</td>"
                                . "<td>" . $sq[1][1] . "</td>"
                                . "<td>$data</td>"
                                . "<td>$ora</td>"
                                . "<td>$luogo</td>"
                                . "</tr>";
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    $connessione = null;
                    echo "</body>"
                        . "</table>";
                    echo "</div>"
                        . "</div>";
                    ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="text-center" style="font-size: 24px;">Info</div>
                </div>
                <div style="padding: 0" class="panel-body">
                    <div class=\"list-group\">
                        <?php
                        $oggi = date("d-m-Y");
                        $oggiTime = strtotime($oggi);
                        $dataTime = strtotime($oggTorneo->Fiscirizioni);
                        if($num_giocatori>$oggTorneo->num_giocatori_max){
                            echo "<a href=\"#\" onclick=\"alert('Hai già inserito il numero di giocatori massimo!!')\" class=\"list-group-item\"><i class=\"fa fa-plus\" aria-hidden=\"true\"></i> Aggiungi giocatore </a>";
                        } else {
                            if ($oggiTime > $dataTime) {
                                echo "<a href=\"#\" onclick=\"alert('Le iscrizioni sono chiuse')\" class=\"list-group-item\"><i class=\"fa fa-plus\" aria-hidden=\"true\"></i> Aggiungi giocatore </a>";
                            } else{
                                echo "<a href=\"#\" onclick=\"$('#aggGiocatore').modal('show')\" class=\"list-group-item\"><i class=\"fa fa-plus\" aria-hidden=\"true\"></i> Aggiungi giocatore </a>";
                            }
                        }
                        ?>
                        <a href="#" onclick="" class="list-group-item"> Lista squadra</a>
                        <a href="#" onclick="" class="list-group-item"> Gol-Cartellini di squadra</a>
                        <a href="#" onclick="" class="list-group-item"> Classifica generale torneo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade" role="dialog" id="aggGiocatore">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id='titoloPartita' class="modal-title">Nuovo Giocatore</h4>
            </div>
            <div class="modal-body">
                <?php
                echo "<form method='post' action='metodi/new_giocatore.php?id_t=$torneo&id_sq=$id_sq'>"
                ?>
                    <div class="form-group col-xs-6">
                        <label for="usr">Nome:</label>
                        <input type="text" placeholder="Nome"  id='nome' name='nome' class="form-control">
                    </div>

                    <div class="form-group col-xs-6">
                        <label for="usr">Cognome:</label>
                        <input type="text" placeholder="Cognome"  id='cognome' name='cognome' class="form-control">
                    </div>

                    <div class="form-group col-xs-6">
                        <label for="usr">Data di nascita:</label>
                        <input type="date" id='data' name='data' class="form-control">
                    </div>

                    <div class="form-group col-xs-6">
                        <label for="usr">Luogo di nascita:</label>
                        <input type="text" placeholder="Luogo di nascita" id='luogo' name='luogo' class="form-control">
                    </div>

                    <div class="form-group col-xs-6">
                        <label for="usr">Codice Fiscale:</label>
                        <input type="text" placeholder="Codice Fiscale" id='cod' name='cod' class="form-control" onkeyup="this.value = this.value.toLocaleUpperCase();">
                    </div>

                    <div class="form-group col-xs-6">
                        <label for="usr">Residenza:</label>
                        <input type="text" placeholder="Via" id='res' name='res' class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="usr">Sesso:</label>
                        <select class="form-control" id="sesso" name="sesso">
                            <option value='M' selected>M</option>
                            <option value='F'>F</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary btn-block">Aggiungi Giocatore</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="listaG">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id='titoloPartita' class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="gol-cartelliniSq">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id='titoloPartita' class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="classificaG">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id='titoloPartita' class="modal-title">fuhfuif</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
//modal gestione partita
echo "<div class=\"modal fade\" id=\"partita\" role=\"dialog\">"
    ."<div class=\"modal-dialog modal-lg\">"
    ."<div class=\"modal-content\">"
    ."<div class=\"modal-header\" id='headerPartita'>"
    ."<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>"
    ."<h4 id='titoloPartita' class=\"modal-title\">Modal Header</h4>"
    ."</div>"
    ."<div style='overflow-y: hidden;' class=\"modal-body\" id='bodyPartita'>"
    ."</div>"
    ."<div class=\"modal-footer\" id='footerPartita'>"
    ."<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>"
    ."</div>"
    ."</div>"
    ."</div>"
    ."</div>";
?>

</body>
</html>