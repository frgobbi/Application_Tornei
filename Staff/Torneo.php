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
            <div class="col-lg-6 col-md-6 col sm-12 col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="h4 text-center">Nuovo Torneo</div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="metodi/new_torneo.php">
                            <div class="form-group">
                                <label for="nome_torneo">Nome Torneo:</label>
                                <input type="text" class="form-control" name="nome_torneo" id="nome_torneo" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="data_inizio">Data Inizio Torneo:</label>
                                <input type="date" class="form-control" name="data_inizio" id="data_inizio" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="data_fine">Data Fine Torneo:</label>
                                <input type="date" class="form-control" name="data_fine" id="data_fine" required>
                            </div>
                            <div class="form-group">
                                <label for="data_fine_iscrizioni">Data Fine Iscrizioni:</label>
                                <input type="date" class="form-control" name="data_fine_iscrizioni" id="data_fine_iscrizioni" required>
                            </div>
                            <hr>
                            <div class="form-group col-md-6">
                                <label for="min_sq">Numero Minimo Squadre:</label>
                                <input type="number" class="form-control" name="min_sq" id="min_sq" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="max_sq">Numero Massimo Squadre:</label>
                                <input type="number" class="form-control" name="max_sq" id="max_sq" required>
                            </div>
                            <div class="form-group">
                                <label for="giocatori_sq">Numero Giocatori Per Squadra:</label>
                                <input type="number" class="form-control" name="giocatori_sq" id="giocatori_sq" required>
                            </div>

                            <div class="alert alert-warning">Se non ci sono vincoli di et&agrave;, non inserire nulla!</div>

                            <div class="form-group col-md-6">
                                <label for="eta_min">Anno di nascita minimo (et&agrave; pi&ugrave; piccola):</label>
                                <input type="number" class="form-control" name="eta_min" id="eta_min">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="eta_max">Anno di nascita minimo (et&agrave; pi&ugrave; grande):</label>
                                <input type="number" class="form-control" name="eta_max" id="eta_max">
                            </div>

                            <div class="form-group">
                                <label for="Sport">Tipo Sport:</label>
                                <!-- Select -->
                                <select class="form-control" name="Sport" id="Sport">
                                    <?php
                                    include "../connessione.php";
                                    try{
                                        foreach ($connessione->query("SELECT * FROM tipo_sport WHERE 1") as $row){
                                            $id = $row['id_tipo_sport'];
                                            $sport = $row['descrizione'];
                                            echo "<option value='$id'>$sport</option>";
                                        }
                                    }catch (PDOException $e){
                                        echo "error: ".$e->getMessage();
                                    }
                                    $connessione = null;
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="info">Comment <small>(Massimo 500 caratteri)</small>:</label>
                                <textarea maxlength="500" style="height: 100px; resize:none; overflow-y: auto;" class="form-control"  id="info" name="info"></textarea>
                            </div>
                            <hr>
                            <div class="form-group col-md-6">
                                <button type="submit" class="btn btn-success btn-block">Crea Torneo</button>
                            </div>
                            <div class="form-group col-md-6">
                                <button type="reset" class="btn btn-danger btn-block">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="h4 text-center">Tornei Attivi</div>
                    </div>
                    <div style="overflow-y: auto;  height: 245px;" class="panel-body">
                        <ul class="event-list">
                            <?php
                            include "../connessione.php";
                            try {
                                foreach ($connessione->query("SELECT `id_torneo`,`nome_torneo`,`id_sport`,`data_inizio`,`data_fine`, DATE_FORMAT(data_inizio,'%d-%c-%Y') AS inizio, DATE_FORMAT(data_fine,'%d-%m-%Y') AS fine FROM `torneo` WHERE `finished` = 0 ORDER BY(data_inizio)") as $row) {
                                    $id = $row['id_torneo'];
                                    $nome = $row['nome_torneo'];
                                    $dataI = $row['data_inizio'];
                                    $dataF = $row['data_inizio'];
                                    $id_sport = $row['id_sport'];
                                    $dataI_F = $row['inizio'];
                                    $dataF_F = $row['fine'];
                                    $componentiDataI = explode("-", $dataI_F);
                                    $meseI = mese($componentiDataI[1]);
                                    $componentiDataF = explode("-", $dataF_F);
                                    $meseF = mese($componentiDataF[1]);
                                    $tipoSport = $connessione->query("SELECT * FROM tipo_sport WHERE id_tipo_sport = '$id_sport'")->fetch(PDO::FETCH_OBJ);
                                    echo "<li>"
                                        . "<a href=\"Admin_Torneo.php?id=$id\">"
                                        . "<time class='i' datetime=\"$dataI\">"
                                        . "<span class=\"day\">" . $componentiDataI[0] . "</span>"
                                        . "<span class=\"month\">$meseI</span>"
                                        . "<span class=\"year\">" . $componentiDataI[2] . "</span>"
                                        . "<span class=\"time\">ALL DAY</span>"
                                        . "</time>"
                                        . "<time class='f' datetime=\"$dataF\">"
                                        . "<span class=\"day\">" . $componentiDataF[00] . "</span>"
                                        . "<span class=\"month\">$meseF</span>"
                                        . "<span class=\"year\">" . $componentiDataF[2] . "</span>"
                                        . "<span class=\"time\">ALL DAY</span>"
                                        . "</time>"
                                        . "<div class=\"info\">"
                                        . "<h2 class=\"title\">$nome</h2>"
                                        . "<p class=\"desc\">$tipoSport->descrizione</p>"
                                        . "</div>"
                                        . "</a>"
                                        . "</li>";
                                }
                            } catch (PDOException $e) {
                                echo "error: " . $e->getMessage();
                            }
                            $connessione = null;
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="h4 text-center">Tornei Conclusi</div>
                    </div>
                    <div style="overflow-y:auto; height: 245px;" class="panel-body">
                        <ul class="event-list">
                            <?php
                            include "../connessione.php";
                            try {
                                foreach ($connessione->query("SELECT `id_torneo`,`nome_torneo`,`id_sport`,`data_inizio`,`data_fine`, DATE_FORMAT(data_inizio,'%d-%m-%Y') AS inizio, DATE_FORMAT(data_fine,'%d-%m-%Y') AS fine FROM `torneo` WHERE `finished` = 1") as $row) {
                                    $id = $row['id_torneo'];
                                    $nome = $row['nome_torneo'];
                                    $dataI = $row['data_inizio'];
                                    $dataF = $row['data_inizio'];
                                    $id_sport = $row['id_sport'];
                                    $dataI_F = $row['inizio'];
                                    $dataF_F = $row['fine'];
                                    $componentiDataI = explode("-", $dataI_F);
                                    $meseI = mese($componentiDataI[1]);
                                    $componentiDataF = explode("-", $dataF_F);
                                    $meseF = mese($componentiDataF[1]);
                                    $tipoSport = $connessione->query("SELECT * FROM tipo_sport WHERE id_tipo_sport = '$id'")->fetch(PDO::FETCH_OBJ);
                                    echo "<li>"
                                        . "<a href=\"Admin_Torneo.php?id=$id\">"
                                        . "<time class=\"i\" datetime=\"$dataI\">"
                                        . "<span class=\"day\">" . $componentiDataI[0] . "</span>"
                                        . "<span class=\"month\">$meseI</span>"
                                        . "<span class=\"year\">" . $componentiDataI[2] . "</span>"
                                        . "<span class=\"time\">ALL DAY</span>"
                                        . "</time>"
                                        . "<time class=\"f\" datetime=\"$dataF\">"
                                        . "<span class=\"day\">" . $componentiDataF[00] . "</span>"
                                        . "<span class=\"month\">$meseF</span>"
                                        . "<span class=\"year\">" . $componentiDataF[2] . "</span>"
                                        . "<span class=\"time\">ALL DAY</span>"
                                        . "</time>"
                                        . "<div class=\"info\">"
                                        . "<h2 class=\"title\">$nome</h2>"
                                        . "<p class=\"desc\">$tipoSport->descrizione</p>"
                                        . "</div>"
                                        . "</a>"
                                        . "</li>";
                                }
                            } catch (PDOException $e) {
                                echo "error: " . $e->getMessage();
                            }
                            $connessione = null;
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>