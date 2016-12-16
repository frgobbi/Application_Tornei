<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 02/12/2016
 * Time: 20:21
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
        function downloadPDF(id, nome_torneo) {
            $.ajax({
                // definisco il tipo della chiamata
                type: "GET",
                // specifico la URL della risorsa da contattare
                url: "metodi/generaPDF.php",
                // passo dei dati alla risorsa remota
                data: "id="+id+"&nomeT="+nome_torneo,
                // definisco il formato della risposta
                dataType: "html",
                // imposto un'azione per il caso di successo
                success: function(risposta){
                    //console.log(risposta);
                    window.location.href = "metodi/files/download_file.php?file="+risposta;
                },
                // ed una per il caso di fallimento
                error: function(){
                    alert("Chiamata fallita!!!");
                }
            });
        }

        function elimina_torneo(id, data_inizio) {
            var domanda = confirm("Eliminando il toreno, eliminerai anche tutti i suoi dati");
            if (domanda === true) {
                $.ajax({
                    // definisco il tipo della chiamata
                    type: "GET",
                    // specifico la URL della risorsa da contattare
                    url: "metodi/cancella_torneo.php",
                    // passo dei dati alla risorsa remota
                    data: "id="+id+"&data="+data_inizio,
                    // definisco il formato della risposta
                    dataType: "html",
                    // imposto un'azione per il caso di successo
                    success: function(risposta){
                        if(risposta == 0) {
                            //console.log(risposta);
                            window.location.href = "Torneo.php";
                        } else{
                            alert("Non si puo' eliminare il torneo perchè \n la data di inizio e' passata ")
                        }
                    },
                    // ed una per il caso di fallimento
                    error: function(){
                        alert("Chiamata fallita!!!");
                    }
                });
            }
        }
    </script>
</head>
<body>
<div id="wrapper">
    <?php
    require '../Componenti_Base/Nav-SideBar.php';
    navLogin();
    $torneo = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
    include "../connessione.php";
    try {
        $sql = "SELECT `id_torneo`,`nome_torneo`,`min_sq`,`max_sq`,`num_giocatori`, DATE_FORMAT(data_inizio,'%d-%m-%Y') AS inizio, `data_inizio`, DATE_FORMAT(data_f_iscrizioni,'%d-%m-%Y') AS Fiscirizioni,`data_f_iscrizioni`, DATE_FORMAT(data_fine,'%d-%m-%Y') AS fine,`data_fine`,`info`,tipo_sport.descrizione AS sport "
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
                    . "<i class=\"fa fa-calendar-o\"></i>  <a href=\"Torneo.php\">Home Tornei</a>"
                    . "</li>"
                    . "<li class=\"active\">"
                    . "<i class=\"fa fa-trophy\" aria-hidden=\"true\"></i>  $oggTorneo->nome_torneo"
                    . "</li>"
                    . "</ol>";
                ?>
            </div>
        </div>
        <div class="row">
            <div class="well">
                <?php
                echo "<ul class=\"nav nav-tabs\">"
                    . "<li class=\"active\"><a href=\"#home\" data-toggle=\"tab\">Home Torneo</a></li>"
                    . "<li><a href=\"#inizio\" data-toggle=\"tab\">Inizio Torneo</a></li>"
                    . "<li><a href=\"#partite\" data-toggle=\"tab\">Partite</a></li>"
                    . "<li><a href=\"#fine\" data-toggle=\"tab\">Fasi Finali</a></li>"
                    . "</ul>"
                    . "<div id=\"myTabContent\" class=\"tab-content\">";

                //PARTE HOME
                echo "<div class=\"tab-pane active in\" id=\"home\">";
                    echo  "<div style=\"padding-top: 20px;\" class=\"row\">";
                        //PRIMO BLOCCO
                        echo "<div class=\"col-lg-4 col-md-4 col-sm-4 col-xs-12\">"
                            . "<ul class=\"list-group\">"
                            . "<li class=\"list-group-item\"><strong>Data Inizio: </strong>$oggTorneo->inizio</li>"
                            . "<li class=\"list-group-item\"><strong>Data Fine: </strong>$oggTorneo->fine</li>"
                            . "<li class=\"list-group-item\"><strong>Data Iscrizioni: </strong>$oggTorneo->Fiscirizioni</li>"
                            . "<li class=\"list-group-item\"><strong>Numero Minimo Squadre: </strong>$oggTorneo->min_sq</li>"
                            . "<li class=\"list-group-item\"><strong>Numero Massimo Squadre: </strong>$oggTorneo->max_sq</li>"
                            . "<li class=\"list-group-item\"><strong>Numero Giocatori per Squadra: </strong>$oggTorneo->num_giocatori</li>"
                            . "</ul>"
                        . "</div>";
                        //FINE PRIMO BLOCCO

                        //SECONDO BLOCCO
                        include "../connessione.php";
                        try {
                            $squadre_iscritte = $connessione->query("SELECT COUNT(*) AS numero FROM `squadra` WHERE id_torneo = '$torneo' AND iscritta = 1")->fetch(PDO::FETCH_OBJ);
                            $proposte_sqaudre = $connessione->query("SELECT COUNT(*) AS numero FROM `squadra` WHERE id_torneo = '$torneo' AND iscritta = 0")->fetch(PDO::FETCH_OBJ);
                            $giocatori = $connessione->query("SELECT COUNT(*) AS numero FROM `sq_utente` INNER JOIN squadra ON sq_utente.id_sq = squadra.id_sq WHERE squadra.iscritta = 1 AND squadra.id_torneo = '$torneo'")->fetch(PDO::FETCH_OBJ);
                        } catch (PDOException $e) {
                            echo "error: " . $e->getMessage();
                        }
                        $connessione = null;

                        echo "<div class=\"col-lg-4 col-md-4 col-sm-4 col-xs-12\">"
                            . "<ul class=\"list-group\">"
                                . "<li class=\"list-group-item\"><strong>Squadre Iscritte: </strong>$squadre_iscritte->numero</li>"
                                . "<li class=\"list-group-item\"><strong>Squadre Incomplete: </strong>$proposte_sqaudre->numero</li>"
                                . "<li class=\"list-group-item\"><strong>Giocatori Iscritti: </strong>$giocatori->numero</li>"
                            . "</ul>"
                            . "<ul class=\"list-group\">"
                                . "<li class=\"list-group-item\"><strong>Info Torneo: </strong>$oggTorneo->info</li>"
                            . "</ul>"
                        . "</div>";
                        //FINE SECONDO BLOCCO

                        //TERZO BLOCCO
                echo "<div class=\"col-lg-4 col-md-4 col-sm-4 col-xs-12\">"
                        . "<div class=\"panel-group\">"
                            . "<div class=\"panel panel-primary\">"
                                . "<div class=\"panel-heading\">"
                                        . "<h4 class=\"panel-title\">"
                                            . "Collapsible panel"
                                        . "</h4>"
                                    ."</div>"
                                    . "<div style=\"padding:0px;\" class=\"panel-body\">"
                                        . "<div class=\"list-group\">"
                                            . "<a href=\"#\" onclick=\"$('#dati').modal('show');\" class=\"list-group-item\"><i class=\"fa fa-cog\" aria-hidden=\"true\"></i> Impostazioni</a>"
                                            . "<a href=\"#\" onclick=\"$('#squadre').modal('show');\" class=\"list-group-item\"><i class=\"fa fa-shield\" aria-hidden=\"true\"></i> Squadre Iscritte</a>"
                                            . "<a href=\"#\" onclick=\"$('#giocatori').modal('show');\" class=\"list-group-item\"><i class=\"fa fa-list\" aria-hidden=\"true\"></i> Lista Giocatori</a>"
                                            . "<a href=\"#\" onclick=\"downloadPDF('".$torneo."','".$oggTorneo->nome_torneo."');\" class=\"list-group-item\"><i class=\"fa fa-file-pdf-o\" aria-hidden=\"true\"></i> Scarica Lista Giocatori</a>"
                                            . "<a href=\"#\" onclick=\"elimina_torneo('".$torneo."','".$oggTorneo->inizio."');\" class=\"list-group-item\"><i class=\"fa fa-calendar-times-o\" aria-hidden=\"true\"></i> Cancella Informatica</a>"
                                        . "</div>"
                                . "</div>"
                            . "</div>"
                        . "</div>"
                    . "</div>";
                    //FINE TERZO BLOCCO

                    //chiusura row
                    echo "</div>";
                //chiusura home
                echo "</div>";

                echo "<div style='padding-top: 30px;' class=\"tab-pane fade\" id=\"inizio\">";
                    echo "<div class='row'>";
                        echo "<div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>";
                            echo "<div class=\"panel panel-primary\">"
                                ."<div class=\"panel-body\">"
                                    ."<form method='post' action='metodi/genera_gironi.php?id=$torneo'>"
                                        ."<div class=\"form-group\">"
                                            ."<label for=\"num_gironi\">Numero di Gironi:</label>"
                                            ."<input type=\"number\" min='1' max='9'  class=\"form-control\" id=\"num_gironi\" name='num_gironi'>"
                                        ."</div>"
                                        ."<div class=\"form-group\">"
                                            ."<label for=\"num_sq\">Numero Squadre per Squadra:</label>"
                                            ."<input type=\"number\" class=\"form-control\" id=\"num_sq\" name='num_sq'>"
                                        ."</div>"
                                        ."<div class=\"form-group\">"
                                            ."<button type='submit' class='btn btn-primary btn-block'>Crea Gironi</button>"
                                        ."</div>"
                                    ."</form>"
                                ."</div>"
                                ."</div>";
                        echo "</div>";
                        echo "<div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'>";
                            echo "<div class=\"panel panel-default\">"
                                ."<div class=\"panel-heading text-center\">"
                                    ."<h4>Partite Gironi</h4>"
                                ."</div>"
                                ."<div class=\"panel-body\">";
                                $sql = "SELECT partita.id_partita,"
                                    ."DATE_FORMAT(partita.data_partita,%d-%m-%Y') AS data,"
                                    ."DATE_FORMAT(partita.ora_partita,'%H:%i') AS ora "
                                    ."FROM `partita` INNER JOIN sq_partita ON sq_partita.id_partita = partita.id_partita"
                                    ."INNER JOIN squadra ON sq_partita.id_sq = squadra.id_sq "
                                    ."WHERE id_torneo = '$torneo' GROUP BY(partita.id_partita)";
                                foreach ($connessione->query($sql) as $row){
                                    
                                }
                                echo"</div>"
                                ."</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                echo "<div class=\"tab-pane fade\" id=\"partite\">"
                    . "</div>";
                echo "<div class=\"tab-pane fade\" id=\"fine\">"
                    . "</div>";
                echo "</div>";
                ?>
            </div>
        </div>
    </div>

    <?php
    //MODALE SQUADRE
    echo "<div id=\"squadre\" class=\"modal fade\" role=\"dialog\">"
        . "<div class=\"modal-dialog\">"
        . "<div class=\"modal-content\">"
        . "<div class=\"modal-header\">"
        . "<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>"
        . "<h4 class=\"modal-title\">Squadre Iscritte</h4>"
        . "</div>"
        . "<div class=\"modal-body\">"
        ."<table class=\"table table-bordered\">"
        ."<thead>"
        ."<tr>"
        ."<th>Nome Squadra</th>"
        ."<th>Creatore</th>"
        ."<th>Iscrizione</th>"
        ."</tr>"
        ."</thead>"
        ."<tbody>";
    include "../connessione.php";
    try{
        foreach ($connessione->query("SELECT * FROM squadra WHERE id_torneo = '$torneo' ORDER BY(iscritta) DESC") as $row){
            $squadra = $row['id_sq'];
            $sql = "SELECT nome,cognome FROM `sq_utente` INNER JOIN utente ON sq_utente.username = utente.username WHERE sq_utente.make = 1 AND sq_utente.id_sq = '$squadra'";
            $oggMake = $connessione->query($sql)->fetch(PDO::FETCH_OBJ);
            $nome = $row['nome_sq'];
            $creatore = $oggMake->nome." ".$oggMake->cognome;
            if($row['iscritta']==1){
                $iscritta = "Confermata";
            }else{
                $iscritta = "Non Confermata";
            }
            echo "<tr>"
                ."<td>$nome</td>"
                ."<td>$creatore</td>"
                ."<td>$iscritta</td>"
                ."</tr>";
        }
    } catch (PDOException $e){
        echo "errore: ".$e->getMessage();
    }
    $connessione = null;
    echo"</tbody>"
        ."</table>"
        . "</div>"
        . "<div class=\"modal-footer\">"
        . "<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>"
        . "</div>"
        . "</div>"
        . "</div>"
        . "</div>";
    //FINE MODAL SQUADRE

    //Modal dati
    echo "<div id=\"dati\" class=\"modal fade\" role=\"dialog\">"
        . "<div class=\"modal-dialog\">"
        . "<div class=\"modal-content\">"
        . "<div class=\"modal-header\">"
        . "<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>"
        . "<h4 class=\"modal-title\">Modifica Torneo</h4>"
        . "</div>"
        . "<div class=\"modal-body\">"
        . "<form method='post' action='metodi/modifica_torneo.php?id=$torneo'>"
        ."<div class=\"form-group\">"
        . "<label for=\"nome\">Name:</label>"
        . "<input type=\"text\" class=\"form-control\" id=\"nome\" name='nome' value='$oggTorneo->nome_torneo' required>"
        . "</div>"
        ."<div class=\"form-group\">"
        . "<label for=\"inizio\">Data Inizio:</label>"
        . "<input type=\"date\" class=\"form-control\" id=\"inizio\" name='inizio' value='$oggTorneo->data_inizio' required>"
        . "</div>"
        ."<div class=\"form-group\">"
        . "<label for=\"iscrizioni\">Data Fine Iscrizioni:</label>"
        . "<input type=\"date\" class=\"form-control\" id=\"iscrizioni\" name='iscrizioni' value='$oggTorneo->data_f_iscrizioni' required>"
        . "</div>"
        ."<div class=\"form-group\">"
        . "<label for=\"fine\">Data Fine:</label>"
        . "<input type=\"date\" class=\"form-control\" id=\"fine\" name='fine' value='$oggTorneo->data_fine' required>"
        . "</div>"
        ."<div class=\"form-group\">"
        . "<label for=\"min_sq\">Numero Minimo Squadre:</label>"
        . "<input type=\"number\" class=\"form-control\" id=\"min_sq\" name='min_sq' value='$oggTorneo->min_sq' required>"
        . "</div>"
        ."<div class=\"form-group\">"
        . "<label for=\"max_sq\">Numero Massimo di Squadre:</label>"
        . "<input type=\"number\" class=\"form-control\" id=\"max_sq\" name='max_sq' value='$oggTorneo->max_sq' required>"
        . "</div>"
        ."<div class=\"form-group\">"
        . "<label for=\"num\">Numero Giocatori Per Squadra:</label>"
        . "<input type=\"number\" class=\"form-control\" id=\"num\" name='num' value='$oggTorneo->num_giocatori' required>"
        . "</div>"
        . "<div class=\"form-group\">"
        . "<label for=\"info\">Comment <small>(Massimo 500 caratteri)</small>:</label>"
        . "<textarea maxlength=\"500\" style=\"height: 100px; resize:none; overflow-y: auto;\" class=\"form-control\"  id=\"info\" name=\"info\">$oggTorneo->info</textarea>"
        . "</div>"
        . "<hr>"
        . "<div class=\"form-group col-md-6\">"
        . "<button type=\"submit\" class=\"btn btn-success btn-block\">Crea Torneo</button>"
        . "</div>"
        . "<div class=\"form-group col-md-6\">"
        . "<button type=\"reset\" class=\"btn btn-danger btn-block\">Reset</button>"
        . "</div>"
        . "</form>"
        . "</div>"
        . "<div class=\"modal-footer\">"
        . "<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>"
        . "</div>"
        . "</div>"
        . "</div>"
        . "</div>";
    //END MODAL DATI

    //MODAL GIOCATORI
    echo "<div id=\"giocatori\" class=\"modal fade\" role=\"dialog\">"
        . "<div class=\"modal-dialog modal-lg\">"
        . "<div class=\"modal-content\">"
        . "<div class=\"modal-header\">"
        . "<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>"
        . "<h4 class=\"modal-title\">Giocatori Iscritti</h4>"
        . "</div>"
        . "<div class=\"modal-body\">";
    include "../connessione.php";
    try{
        foreach ($connessione->query("SELECT * FROM squadra WHERE id_torneo = '$torneo' ORDER BY(iscritta) DESC") as $row){
            $squadra = $row['id_sq'];
            $nome = $row['nome_sq'];
            echo "<table class=\"table table-bordered table-responsive\">"
                ."<thead>"
                    ."<tr><th class='text-center' colspan=\"6\">$nome</th></tr>"
                    ."<tr>"
                        ."<th>Nome</th>"
                        ."<th>Cognome</th>"
                        ."<th>Data di nascita</th>"
                        ."<th>Luogo di Nascita</th>"
                        ."<th>Codice Fiscale</th>"
                        ."<th>Residenza</th>"
                    ."</tr>"
                ."</thead>"
            ."<tbody>";
            foreach ($connessione->query("SELECT nome,cognome,DATE_FORMAT(data_nascita,'%d-%m-%Y') AS data,codice_fiscale,luogo_nascita,residenza FROM `utente` INNER JOIN sq_utente ON utente.username = sq_utente.username WHERE sq_utente.id_sq = '$squadra' ORDER BY(nome) ASC") as $riga){
                $nome_u = $riga['nome'];
                $cognome_u = $riga['cognome'];
                $data = $riga['data'];
                $codice = $riga['codice_fiscale'];
                $luogo_d = $riga['luogo_nascita'];
                $residenza = $riga['residenza'];

                echo"<tr>"
                    ."<td>$nome_u</td>"
                    ."<td>$cognome_u</td>"
                    ."<td>$data</td>"
                    ."<td>$luogo_d</td>"
                    ."<td>$codice</td>"
                    ."<td>$residenza</td>"
                    ."</tr>";
            }
            echo "</tbody>"
        ."</table>";
        }
    } catch (PDOException $e){
        echo "errore: ".$e->getMessage();
    }
    $connessione = null;
        echo "</div>"
        . "<div class=\"modal-footer\">"
        . "<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>"
        . "</div>"
        . "</div>"
        . "</div>"
        . "</div>";
    ?>

</body>
</html>