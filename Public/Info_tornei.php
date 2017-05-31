<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 08/05/2017
 * Time: 17:00
 */
?>
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
        <?php
            include '../Componenti_Base/Head.php';
            LibrerieUnLog()
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
            navUnLog();
            ?>
            <div id="page-wrapper">
                <div style="padding-top: 30px;" class="row">
                    <?php
                        include "../connessione.php";
                        try{
                            $sql = "SELECT `id_torneo`,`nome_torneo`,`min_sq`,`max_sq`,`num_giocatori_min`,`num_giocatori_max`, DATE_FORMAT(data_inizio,'%d-%m-%Y') AS inizio, `data_inizio`, DATE_FORMAT(data_f_iscrizioni,'%d-%m-%Y') AS Fiscirizioni,`data_f_iscrizioni`, DATE_FORMAT(data_fine,'%d-%m-%Y') AS fine,`data_fine`,`info`,tipo_sport.descrizione, `min_anno`, `max_anno`, `fase_finale`,`finished`, tipo_sport.colore FROM `torneo`"
                                ."INNER JOIN tipo_sport ON tipo_sport.id_tipo_sport = torneo.id_sport "
                                ."WHERE torneo.finished = 0";
                            foreach ($connessione->query($sql) as $row){
                                $id_t = $row['id_torneo'];
                                $squadre_iscritte = $connessione->query("SELECT COUNT(*) AS numero FROM `squadra` WHERE id_torneo = '$id_t' AND iscritta = 1")->fetch(PDO::FETCH_OBJ);
                                $nome_t = $row['nome_torneo'];
                                $tipo_sport = $row['descrizione'];
                                $colore = $row['colore'];
                                $inizio = $row['inizio'];
                                $fine = $row['fine'];
                                $fine_i = $row['Fiscirizioni'];
                                $min_anno = $row['min_anno'];
                                $max_anno = $row['max_anno'];
                                $info = $row['info'];
                                $oggi = date("d-m-Y");
                                $timeOggi = strtotime($oggi);
                                $timeInizio = strtotime($inizio);
                                echo "<div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>"
                                ."<div class=\"panel panel-$colore\">"
                                  ."<div class=\"panel-heading text-center\">"
                                        ."<div class='row'>"
                                            ."<div class='col-xs-12'><h3>$nome_t <small style='color: white;'>Torneo di $tipo_sport</small></h4></div>"
                                        ."</div>"
                                    ."</div>"
                                  ."<div class=\"panel-body\">"
                                    ."<div class='row'>"
                                        ."<div class='col-md-6 col-sm-12' >"
                                            ."<ul class=\"list-group\">"
                                              ."<li class=\"list-group-item\"><strong>Data inizio:</strong> $inizio</li>"
                                              ."<li class=\"list-group-item\"><strong>Data fine Iscrizioni:</strong> $fine_i</li>";
                                            if($min_anno == 0){
                                                echo "<li class=\"list-group-item\"><strong>Anno più piccolo:</strong> Nessun limite</li>";
                                            } else {
                                                echo "<li class=\"list-group-item\"><strong>Anno più piccolo:</strong> $min_anno</li>";
                                            }
                                            echo "</ul>"
                                        ."</div>"
                                        ."<div class='col-md-6 col-sm-12' >"
                                            ."<ul class=\"list-group\">"
                                                ."<li class=\"list-group-item\"><strong>Data fine:</strong> $fine</li>"
                                                ."<li class=\"list-group-item\"><strong>Numero squadre iscritte:</strong> $squadre_iscritte->numero</li>";
                                                if($max_anno == 0){
                                                    echo "<li class=\"list-group-item\"><strong>Anno più grande:</strong> Nessun limite</li>";
                                                } else {
                                                    echo "<li class=\"list-group-item\"><strong>Anno più grande:</strong> $max_anno</li>";
                                                }
                                            echo "</ul>"
                                        ."</div>"
                                    ."</div>"
                                    ."<div class='row'>"
                                        ."<div class='col-md-12 col-sm-12' >"
                                            ."<ul class=\"list-group\">"
                                            ."<li class=\"list-group-item\"><strong>Info torneo:</strong> $info</li>"
                                            ."</ul>"
                                        ."</div>"
                                    ."</div>"
                                  ."</div>"
                                ."<div class=\"panel-footer\">"
                                    ."<div class='row'>"
                                        ."<div class='col-md-6 col-sm-12' >";
                                            if($timeOggi>$timeInizio){
                                                echo "<strong>Stato torneo: </strong><strong class='text-rigth text-success'>&nbsp; In corso</strong></div>";
                                            } else {
                                                echo "<strong>Stato torneo: </strong><strong class='text-rigth text-primary'>&nbsp; Prossimamente</strong></div>";
                                            }
                                        echo "</div>"
                                    ."</div>"
                                ."</div>"
                                ."</div>";
                            }
                        } catch (PDOException $e){
                            echo $e->getMessage();
                        }
                        $connessione = null;
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>