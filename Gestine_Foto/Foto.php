<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 30/11/2016
 * Time: 21:46
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
    <link href="../Librerie/CSS/contact-list.css" rel="stylesheet">
    <link href="../Librerie/Input_File/css/fileinput.min.css" rel="stylesheet">
    <link href="../Librerie/Input_File/themes/explorer/theme.css" rel="stylesheet">
    <script src="../Librerie/Input_File/js/fileinput.js"></script>
    <script src="../Librerie/Input_File/themes/explorer/theme.js"></script>
    <link rel="stylesheet" href="../Librerie/CSS/event-list.css">
    <script type="text/javascript" src="Java-script/Gestione_foto.js"></script>
    <style type="text/css">
        .btn span.glyphicon {
            opacity: 0;
        }
        .btn.active span.glyphicon {
            opacity: 1;
        }
    </style>
    <script type="text/javascript">
        function open_popHome() {
            visualizza_foto(1);
            $('#gestione_foto').modal('show');
        }
        function open_popCart(id_c) {
            visualizza_foto(id_c);
            $('#gestione_foto').modal('show');
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
        <div style="padding-top: 30px; " class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <a href="#" onclick="open_popHome()">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-3">
                                    <i class="fa fa-picture-o fa-5x" aria-hidden="true"></i>
                                </div>
                                <div class="col-md-9 text-right">
                                    <h3>Foto Homepage</h3>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer"></div>
                    </div>
                </a>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#newCartella">
                                <div class="row">
                                    <div class="col-md-3">
                                        <i class="fa fa-plus-circle fa-5x" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-md-9 text-right">
                                        <h3>Nuova Cartella</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div id="newCartella" class="panel-collapse collapse">
                            <div class="panel-body">
                                <form method="post" action="metodi/new_cartella.php">
                                    <div class="form-group">
                                        <label for="nome_c">Nome Cartella:</label>
                                        <input type="text" class="form-control" id="nome_c" name="nome_c">
                                    </div>

                                    <div class="form-group">
                                        <label for="colore_c">Colore Cartella:</label>
                                        <select class="form-control" id="colore_C" name="colore_c">
                                            <option value="default">Bianco</option>
                                            <option value="danger">Rosso Pastello</option>
                                            <option value="red">Rosso</option>
                                            <option value="warning">Giallo Pastello</option>
                                            <option value="yellow">Giallo</option>
                                            <option value="success">Verde Pastello</option>
                                            <option value="green">Verde</option>
                                            <option value="info">Azzurro</option>
                                            <option value="primary">Blu</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">Aggiungi Cartella</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-primary">
                <div id="area_c" class="panel-body" style="height: 530px; overflow-y: auto">
                    <?php
                        include "../connessione.php";
                        try{
                            foreach ($connessione->query("SELECT * FROM `cartelle_f` ORDER BY(nome_cartella) ASC") as $row){
                                $nome = $row['nome_cartella'];
                                $colore = $row['colore'];
                                $id = $row['id_c'];
                                if($id!=1){
                                    echo "<div class=\"col-lg-4 col-md-4 col-sm-12 col-xs-12\">"
                                        ."<a href=\"#\" onclick=\"open_popCart($id)\">"
                                        ."<div class=\"panel panel-$colore\">"
                                        ."<div class=\"panel-heading\">"
                                        ."<div class=\"row\">"
                                        ."<div class=\"col-md-3\">"
                                        ."<i class=\"fa fa-folder fa-5x\" aria-hidden=\"true\"></i>"
                                        ."</div>"
                                        ."<div class=\"col-md-9 text-right\">"
                                        ."<h3>$nome</h3>"
                                        ."</div>"
                                        ."</div>"
                                        ."</div>"
                                        ."<div class=\"panel-footer\"></div>"
                                        ."</div>"
                                        ."</a>"
                                        ."</div>";
                                }
                            }
                        }catch (PDOException $e){
                            echo $e->getMessage();
                        }
                        $connessione = null;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="gestione_foto" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" id='headerPartita'>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id='titoloClassifica' class=\"modal-title\">Gestione Foto</h4>
            </div>
            <div style='overflow-y:hidden;' class="modal-body" id='body_foto'>
            </div>
            <div class="modal-footer" id='footerFoto'>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>