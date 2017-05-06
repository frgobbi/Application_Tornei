<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
<head>
    <?php
    include 'Componenti_Base/Head.php';
    index();
    ?>
</head>
<body>
<div id="wrapper">
    <?php
    require 'Componenti_Base/Nav-SideBar.php';
    navIndex();
    ?>
    <div id="page-wrapper">
        <div class="row">
            <br>
            <div class="panel panel-yellow">
                <div class="panel-body">
                    <!-- 1 -->
                    <div class="col-lg-3 col-md-6">
                        <a href="#">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-calendar fa-5x" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <h3>I nostri Tornei</h3>
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
                    <!-- 2 -->
                    <div class="col-lg-3 col-md-6">
                        <a href="#">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-list fa-5x" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <h3>Classifiche</h3>
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
                    <!-- 3 -->
                    <div class="col-lg-3 col-md-6">
                        <a href="Public/Galleria.php">
                            <div class="panel panel-yellow">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-picture-o fa-5x" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <h3>Album Foto</h3>
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
                    <!-- 4 -->
                    <div class="col-lg-3 col-md-6">
                        <a href="#">
                            <div class="panel panel-red">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-newspaper-o fa-5x" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <h3>Comunicazioni</h3>
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
            </div>
        </div>
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <br>
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                            <?php
                            $c = 1;
                            if ($handle = opendir("Immagini/Vecchi_tornei")) {
                                while ($file = readdir($handle)) {
                                    echo "<li data-target=\"#myCarousel\" data-slide-to=\"$c\"></li>";
                                    $c = $c + 1;
                                }
                            }
                            ?>
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <?php
                            $c = 0;
                            include "connessione.php";
                            try{
                                $oggC = $connessione->query("SELECT `id_c`, `nome_cartella`, `colore` FROM `cartelle_f` WHERE nome_cartella = 'Vecchi_tornei'")->fetch(PDO::FETCH_OBJ);
                                foreach ($connessione->query("SELECT `id_foto`, `nome_foto`, `id_c` FROM `foto` WHERE id_c = '$oggC->id_c'") as $row){
                                 $file = $row['nome_foto'];
                                    if ($c == 0) {
                                        echo " <div class=\"item active\">"
                                            . "<img src=\"Immagini/Vecchi_tornei/$file\">"
                                            . "</div>";
                                    } else {
                                        echo " <div class=\"item\">"
                                            . "<img src=\"Immagini/Vecchi_tornei/$file\">"
                                            . "</div>";
                                    }
                                    $c = $c + 1;
                                }
                            } catch (PDOException $e){
                                echo $e->getMessage();
                            }
                            $connessione = null;
                            /*if ($handle = opendir("Immagini/Vecchi_tornei")) {
                                while ($file = readdir($handle)) {
                                    if ($file != "." & $file != "..") {
                                        if ($c == 0) {
                                            echo " <div class=\"item active\">"
                                                . "<img src=\"Immagini/Vecchi_tornei/$file\">"
                                                . "</div>";
                                        } else {
                                            echo " <div class=\"item\">"
                                                . "<img src=\"Immagini/Vecchi_tornei/$file\">"
                                                . "</div>";
                                        }
                                        $c = $c + 1;
                                    }

                                }
                            }*/
                            ?>
                        </div>

                        <!-- Left and right controls -->
                        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
</body>
</html>
