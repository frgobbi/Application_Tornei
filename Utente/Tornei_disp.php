<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 11/04/2017
 * Time: 12:25
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
        function info_t(id) {
           console.log($('#modal_info_T').modal('show'));
        }
    </script>
</head>
<body>
<div id="wrapper">
    <?php
    require '../Componenti_Base/Nav-SideBar.php';
    navLogin();
    ?>
    <div id="page-wrapper">
        <div style="padding-top: 30px; height: 700px; overflow-y: auto" class="row">
            <?php
                include "../connessione.php";
                try{
                    $sql = "SELECT id_torneo, nome_torneo, tipo_sport.logo, tipo_sport.descrizione, tipo_sport.colore FROM `torneo` INNER JOIN tipo_sport ON tipo_sport.id_tipo_sport=torneo.id_sport WHERE torneo.finished =0";
                    foreach ($connessione->query($sql) as $row){
                        $id_t = $row['id_torneo'];
                        $nome_t = $row['nome_torneo'];
                        $logo = $row['logo'];
                        $colore = $row['colore'];
                        echo "<div class=\"col-lg-4 col-md-4 col-sm-12 col-xs-12\">"
                            ."<a href=\"#\" onclick=\"info_t($id_t)\">"
                            ."<div class=\"panel panel-$colore\">"
                            ."<div class=\"panel-heading\">"
                            ."<div class=\"row\">"
                            ."<div class=\"col-md-3\">"
                            ."<i class=\"fa $logo fa-5x\" aria-hidden=\"true\"></i>"
                            ."</div>"
                            ."<div class=\"col-md-9 text-right\">"
                            ."<h3>$nome_t</h3>"
                            ."</div>"
                            ."</div>"
                            ."</div>"
                            ."<div class=\"panel-footer\"></div>"
                            ."</div>"
                            ."</a>"
                            ."</div>";
                    }
                } catch (PDOException $e){
                    echo $e->getMessage();
                }
                $connessione = null;
            ?>
        </div>
    </div>



    <!-- Modal -->
    <div id="modal_info_T" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div id="header_t" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div id="body_t" class="modal-body">
                    <p>Some text in the modal.</p>
                </div>
                <div id="footer_t" class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>


</div>
</body>
</html>