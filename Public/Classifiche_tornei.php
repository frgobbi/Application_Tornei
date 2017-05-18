<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 08/05/2017
 * Time: 17:01
 */
?>
<html>
<head>
    <?php
    include '../Componenti_Base/Head.php';
    LibrerieUnLog()
    ?>
    <script type="text/javascript" src="Java-script/classifica.js"></script>
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
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-body" style="height: 550px; overflow-y: auto">
                        <?php
                        include "../connessione.php";
                        try {
                            $sql = "SELECT `id_torneo`,`nome_torneo`,tipo_sport.descrizione, tipo_sport.colore, tipo_sport.logo FROM `torneo`"
                                . "INNER JOIN tipo_sport ON tipo_sport.id_tipo_sport = torneo.id_sport "
                                . "WHERE torneo.finished = 0";
                            foreach ($connessione->query($sql) as $row) {
                                $id_t = $row['id_torneo'];
                                $nome_t = $row['nome_torneo'];
                                $sport = $row['descrizione'];
                                $colore = $row['colore'];
                                $logo = $row['logo'];
                                echo "<a href=\"#\" onclick=\"creaClassifica('$id_t')\">"
                                    . "<div class=\"panel panel-$colore\">"
                                    . "<div class=\"panel-heading\">"
                                    . "<div class=\"row\">"
                                    . "<div class=\"col-xs-3\">"
                                    . "<i class=\"fa $logo fa-5x\" aria-hidden=\"true\"></i>"
                                    . "</div>"
                                    . "<div class=\"col-xs-9 text-center\">"
                                    . "<h3>$nome_t <br><small style=\"color:white;\">Torneo di $sport</small></h3>"
                                    . "</div>"
                                    . "</div>"
                                    . "</div>"
                                    . "<div class=\"panel-footer\">"
                                    . "<span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>"
                                    . "<div class=\"clearfix\"></div>"
                                    . "</div>"
                                    . "</div>"
                                    . "</a>";
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                        $connessione = null;
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div class="row container-fluid">
                    <div style="height: 550px; overflow-y: auto" id="area_classifica">
                        <div class="alert alert-info">Clicca su un torneo per visualiizare la classifica</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>