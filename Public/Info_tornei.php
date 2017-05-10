<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 08/05/2017
 * Time: 17:00
 */
?>
<html>
    <head>
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
                            $sql = "SELECT * FROM `torneo`"
                                ."INNER JOIN tipo_sport ON tipo_sport.id_tipo_sport = torneo.id_sport "
                                ."WHERE torneo.finished = 0";
                            foreach ($connessione->query($sql) as $row){
                                $nome_t = $row['nome_torneo'];
                                $tipo_sport = $row['descrizione'];
                                $colore = $row['colore'];
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
                                              ."<li class=\"list-group-item\"><strong>Data inizio:</strong> </li>"
                                              ."<li class=\"list-group-item\"><strong>Data fine Iscrizioni:</strong> </li> "
                                              ."<li class=\"list-group-item\"><strong>Anno più piccolo:</strong> </li>"
                                            ."</ul>"
                                        ."</div>"
                                        ."<div class='col-md-6 col-sm-12' >"
                                            ."<ul class=\"list-group\">"
                                                ."<li class=\"list-group-item\"><strong>Data fine:</strong> </li>"
                                                ."<li class=\"list-group-item\"><strong>Numero squadre iscritte:</strong> </li>"
                                                ."<li class=\"list-group-item\"><strong>Anno più grande:</strong></li>"
                                            ."</ul>"
                                        ."</div>"
                                    ."</div>"
                                    ."<div class='row'>"
                                        ."<div class='col-md-12 col-sm-12' >"
                                            ."<ul class=\"list-group\">"
                                            ."<li class=\"list-group-item\"><strong>Info torneo:</strong> </li>"
                                            ."</ul>"
                                        ."</div>"
                                    ."</div>"
                                  ."</div>"
                                ."<div class=\"panel-footer\">"
                                    ."<div class='row'>"
                                        ."<div class='col-md-6 col-sm-12' >"
                                            ."<strong>Stato torneo:</strong> </div>"
                                        ."</div>"
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