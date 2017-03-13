<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 18/02/2017
 * Time: 12:54
 */
session_start();
if (!$_SESSION['login']) {
    header("Location:../index.php");
}
if (!($_SESSION['tipo_utente'] == 1 || $_SESSION['tipo_utente'] == 3)) {
    header("Location:../Home/home.php");
}
?>
<html>
<head>
    <?php
    include '../Componenti_Base/Head.php';
    LibrerieLogin();
    ?>
    <link rel="stylesheet" href="../Librerie/CSS/contact-list.css">
    <link rel="stylesheet" href="../Librerie/CSS/material-switch.css">
    <script type="text/javascript" src="../Librerie/Java-script/contact-list.js"></script>
    <script type="text/javascript" src="Java-script/Bar.js"></script>
    <style type="text/css">
        .btn span.glyphicon {
            opacity: 0;
        }

        .btn.active span.glyphicon {
            opacity: 1;
        }
    </style>
    <script type="text/javascript">
        function popupSoldi(username) {
            creaFormSoldi(username);
            $('#add_euro').modal('show');
        }

        function popupSerate() {
            Vserate();
            $('#serate').modal('show')
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
            <div class="col-lg-6 col-md-6 col sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <a href="Cassa.php">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-9 text-left">
                                            <h3>Apri Cassa</h3>
                                        </div>
                                        <div class="col-xs-3">
                                            <i class="fa fa-calculator fa-5x" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <a href="#" onclick="popupSerate()">
                            <div class="panel panel-yellow">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-7 text-left">
                                            <h3>Serate</h3>
                                        </div>
                                        <div class="col-xs-5">
                                            <i class="fa fa-eur fa-5x" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading c-list">
                                <span class="title">Utenti</span>
                                <ul class="pull-right c-controls">
                                    <li>
                                        <a href="#" class="hide-search" data-command="toggle-search">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="row" style="display: none;">
                                <div class="col-xs-12">
                                    <div class="input-group c-search">
                                        <input type="text" class="form-control" id="contact-list-search">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><span
                                        class="glyphicon glyphicon-search text-muted"></span></button>
                            </span>
                                    </div>
                                </div>
                            </div>
                            <ul class="list-group" id="contact-list" style="height: 412px; overflow-y: auto">
                                <?php
                                include "../connessione.php";
                                try {
                                    foreach ($connessione->query("SELECT * FROM `utente` WHERE utente.id_cat = 4 ORDER BY nome ASC") as $row) {
                                        $nome = $row['nome'] . " " . $row['cognome'];
                                        $immagine = "../Immagini/Immagini_Profilo/" . $row['foto'];
                                        $saldo = $row['saldo'];
                                        $username = $row['username'];
                                        echo "<li class=\"list-group-item\">"
                                            . "<div class=\"col-xs-12 col-sm-3\">"
                                            . "<img src=\"$immagine\" alt=\"Scott Stevens\" class=\"img-responsive img-circle img-thumbnail\" />"
                                            . "</div>"
                                            . "<div class=\"col-xs-12 col-sm-9\">"
                                            . "<span class=\"name\">$nome</span><br/>";
                                        if ($row['card'] != NULL) {
                                            echo " <button type=\"button\" onclick='popupSoldi(\"$username\")' class=\"btn btn-primary btn-lg\"><i class=\"fa fa-eur\" aria-hidden=\"true\"></i></button>";
                                        } else {
                                            echo " <button type=\"button\" onclick='popupSoldi(\"$username\")' class=\"btn btn-success btn-lg\"><i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>";
                                        }
                                        echo "</div>"
                                            . "<div class=\"clearfix\"></div>"
                                            . "</li>";
                                    }
                                } catch (PDOException $e) {
                                    echo $e->getMessage();
                                }
                                $connessione = null;
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- JavaScrip Search Plugin -->
                <script
                    src="//rawgithub.com/stidges/jquery-searchable/master/dist/jquery.searchable-1.0.0.min.js"></script>

            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="h4 text-center">Categorie Prodotto</div>
                    </div>
                    <div style="overflow-y: auto;  height: 245px;" class="panel-body">
                        <div class="row">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <a data-toggle="collapse" href="#ad_cat">
                                        <h4 class="panel-title">Aggiungi Categoria</h4>
                                    </a>
                                </div>
                                <div id="ad_cat" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <form method="post" action="metodi/add_categoria.php">
                                            <div>
                                                <div class="form-group">
                                                    <label for="nome_cat">Name categoria:</label>
                                                    <input type="text" class="form-control" id="nome_cat"
                                                           name="nome_cat" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="color">Colore Categoria:</label>
                                                    <select class="form-control" name="colore" id="color">
                                                        <option value="red">Rosso</option>
                                                        <option value="danger">Rosso Pastello</option>
                                                        <option value="yellow">Giallo</option>
                                                        <option value="warning">Giallo Pastello</option>
                                                        <option value="green">Verde</option>
                                                        <option value="success">Verde Pastello</option>
                                                        <option value="info">Celeste</option>
                                                        <option value="primary">Blu</option>
                                                        <option value="default">Bianco</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary btn-block">Aggiungi
                                                        Categoria
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                <td>Nome Cageoria</td>
                                <td>Colore</td>
                                <td>Modifica</td>
                                </thead>
                                <tbody>
                                <?php
                                include "../connessione.php";
                                try {
                                    foreach ($connessione->query("SELECT * FROM `cat_prodotto`") as $row) {
                                        $color = $row['colore'];
                                        $nome = $row['nome_cat'];
                                        $id = $row['id_cat_prodotto'];
                                        echo "<tr>";
                                        echo "<td>$nome</td>";
                                        if (strcmp($color, "red") == 0) {
                                            echo "<td id='Color$id'>Rosso</td>";
                                        } else {
                                            if (strcmp($color, "yellow") == 0) {
                                                echo "<td id='Color$id'>Giallo</td>";
                                            } else {
                                                if (strcmp($color, "green") == 0) {
                                                    echo "<td id='Color$id'>Verde</td>";
                                                } else {
                                                    if (strcmp($color, "info") == 0) {
                                                        echo "<td id='Color$id'>Celeste</td>";
                                                    } else {
                                                        if (strcmp($color, "primary") == 0) {
                                                            echo "<td id='Color$id'>Blu</td>";
                                                        } else {
                                                            if (strcmp($color, "default") == 0) {
                                                                echo "<td id='Color$id'>Bianco</td>";
                                                            } else {
                                                                if (strcmp($color, "danger") == 0) {
                                                                    echo "<td id='Color$id'>Rosso Pastello</td>";
                                                                } else {
                                                                    if (strcmp($color, "warning") == 0) {
                                                                        echo "<td id='Color$id'>Giallo Pastello</td>";
                                                                    } else {
                                                                        if (strcmp($color, "success") == 0) {
                                                                            echo "<td id='Color$id'>Verde Pastello</td>";
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        echo "<td id='Button$id'><button onclick='modificaC($id)' class='btn btn-primary'><i class='fa fa-pencil'></i></button></td>";
                                        echo "</tr>";
                                    }
                                } catch (PDOException $e) {
                                    echo $e->getMessage();
                                }
                                $connessione = null;
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="h4 text-center">Prodotti</div>
                    </div>
                    <div style="overflow-y: auto;  height: 245px;" class="panel-body">
                        <div class="row">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <a data-toggle="collapse" href="#add_prodotto">
                                        <h4 class="panel-title">Aggiungi prodotto</h4>
                                    </a>
                                </div>
                                <div id="add_prodotto" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <form method="post" action="metodi/add_prodotto.php">
                                            <div class="form-group">
                                                <label for="nome_p">Nome Prodotto:</label>
                                                <input maxlength="12" required type="text" class="form-control"
                                                       id="nome_p"
                                                       name="nome_p">
                                            </div>
                                            <div class="form-group">
                                                <label for="prezzo">Prezzo:</label>
                                                <div class="alert alert-warning">
                                                    <strong>Attenzione!</strong>Usare il punto per separare i decimali
                                                </div>
                                                <input required type="text" class="form-control" id="prezzo"
                                                       name="prezzo">
                                            </div>
                                            <div class="form-group">
                                                <label for="categoria">Categoria Prodotto:</label>
                                                <select class="form-control" name="categoria" id="categoria">
                                                    <option>Scegli categoria...</option>
                                                    <?php
                                                    include "../connessione.php";
                                                    try {
                                                        foreach ($connessione->query("SELECT * FROM `cat_prodotto`") as $row) {
                                                            $nome = $row['nome_cat'];
                                                            $id = $row['id_cat_prodotto'];
                                                            echo "<option value='$id'>$nome</option>";
                                                        }
                                                    } catch (PDOException $e) {
                                                        echo $e->getMessage();
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Vendibile: &nbsp;</label>
                                                <div class="btn-group" data-toggle="buttons">
                                                    <label class="btn btn-primary">
                                                        <input type="checkbox" autocomplete="off" name="vendibile"
                                                               id="option2" value="1">
                                                        <span class="glyphicon glyphicon-ok"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-block">Aggiungi
                                                    Prodotto
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                <td>Nome Prodotto</td>
                                <td>Prezzo (&euro;)</td>
                                <td>Categoria</td>
                                <td>Vendibile</td>
                                <td>Modifica</td>
                                </thead>
                                <tbody>
                                <?php
                                include "../connessione.php";
                                try {
                                    foreach ($connessione->query("SELECT * FROM `prodotto` INNER JOIN cat_prodotto ON prodotto.id_cat_prodotto = cat_prodotto.id_cat_prodotto WHERE 1") as $row) {
                                        $nome = $row['nome_prodotto'];
                                        $nome_C = $row['nome_cat'];
                                        $id = $row['id_prodotto'];
                                        $vendibile = $row['vendibile'];
                                        $prezzo = $row['prezzo'];
                                        echo "<tr>";
                                        echo "<td id='Nome$id'>$nome</td>";
                                        echo "<td id='Prezzo$id'>$prezzo</td>";
                                        echo "<td>$nome_C</td>";
                                        if ($vendibile == 0) {
                                            echo "<td><div class=\"material-switch\" style='padding-top: 15px; padding-left: 30px;'>"
                                                . "<input id=\"vendibile$id\" name=\"vendibile$id\" type=\"checkbox\" onchange='cambiaV($id)'/>"
                                                . "<label for=\"vendibile$id\" class=\"label-primary\"></label>"
                                                . "</div></td>";
                                        } else {
                                            echo "<td><div class=\"material-switch \" style='padding-top: 15px; padding-left: 30px;'>"
                                                . "<input id=\"vendibile$id\" name=\"vendibile$id\" type=\"checkbox\" checked onchange='cambiaV($id)'/>"
                                                . "<label for=\"vendibile$id\" class=\"label-primary\"></label>"
                                                . "</div></td>";
                                        }
                                        echo "<td id='ButtonP$id'><button onclick='modificaP($id)' class='btn btn-primary'><i class='fa fa-pencil'></i></button></td>";
                                        echo "</tr>";
                                    }
                                } catch (PDOException $e) {
                                    echo $e->getMessage();
                                }
                                $connessione = null;
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Serate-->
        <div class="modal fade" id="serate" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Giorni Bar</h4>
                    </div>
                    <div class="modal-body" id="serateBody">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Soldi-->
        <div class="modal fade" id="add_euro" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Aggiungi denaro</h4>
                    </div>
                    <div id="add_denaroBody" class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
</html>