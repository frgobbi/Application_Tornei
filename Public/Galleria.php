<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 05/05/2017
 * Time: 11:51
 */
?>
<html>
<head>
    <?php
    include '../Componenti_Base/Head.php';
    LibrerieUnLog()
    ?>
    <style type="text/css">

        .navC > li > a:hover, .navC > li > a:focus, .navC .open > a, .navC .open > a:hover, .navC .open > a:focus {
            background: #fff;
        }

        .dropdownC {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 300px;
        }

        .dropdown-menuC > li > a {
            color: #428bca;
        }

        .dropdownC ul.dropdown-menuC {
            border-radius: 4px;
            box-shadow: none;
            margin-top: 20px;
            width: 300px;
        }

        .dropdownC ul.dropdown-menuC:before {
            content: "";
            border-bottom: 10px solid #fff;
            border-right: 10px solid transparent;
            border-left: 10px solid transparent;
            position: absolute;
            top: -10px;
            right: 16px;
            z-index: 10;
        }

        .dropdownC ul.dropdown-menuC:after {
            content: "";
            border-bottom: 12px solid #ccc;
            border-right: 12px solid transparent;
            border-left: 12px solid transparent;
            position: absolute;
            top: -12px;
            right: 14px;
            z-index: 9;
        }

        .hide-bullets {
            list-style: none;
            margin-left: -40px;
            margin-top: 20px;
        }

        .thumbnail {
            padding: 0;
        }

        .carousel-inner > .item > img, .carousel-inner > .item > a > img {
            width: 100%;
        }
    </style>
    <script type="text/javascript">
        function cambioFoto(id_cartella) {
            var codice = "";
            $.ajax({
                type: "GET",
                url: "metodi/dati_foto.php",
                data: "id_cartella="+id_cartella,
                success: function(risposta){
                    var ogg = $.parseJSON(risposta);
                    if(ogg.foto.length !=0){
                        codice += "<div id=\"main_area\">"
                            + "<div class=\"row\">"
                            + "<div class=\"col-sm-6\" style='height: 500px; overflow-y: auto;' id=\"slider-thumbs\">"
                            + "<ul class=\"hide-bullets\">";
                        for (var i = 0; i< ogg.foto.length; i++) {
                            var percorso = "../Immagini/"+ogg.nome_cartella+"/" + ogg.foto[i];
                            var selector = "carousel-selector-"+i;
                            if (i == 0) {
                                codice += "<li style='height: 90px;' class=\"col-sm-3\">"
                                    + "<a onclick='cambiaFoto(\""+selector+"\")' class=\"thumbnail\" id=\""+selector+"\">"
                                    + "<img src=\""+percorso+"\" style='height: 70px;'>"
                                    + "</a>"
                                    + "</li>";
                            } else {
                                codice += "<li style='height: 90px;' class=\"col-sm-3\">"
                                    + "<a onclick='cambiaFoto(\""+selector+"\")' class=\"thumbnail\" id=\""+selector+"\">"
                                    + "<img style='height: 70px;' src=\""+percorso+"\"></a>"
                                    + "</li>";
                            }
                        }
                        codice += "</ul>"
                            + "</div>"
                            + "<div class=\"col-sm-6\">"
                            + "<div class=\"col-xs-12\" id=\"slider\">"
                            + "<div class=\"row\">"
                            + "<div class=\"col-sm-12\" id=\"carousel-bounding-box\">"
                            + "<div class=\"carousel slide\" id=\"myCarousel\">"
                            + "<div class=\"carousel-inner\">";

                        for (i = 0; i< ogg.foto.length; i++) {
                            percorso = "../Immagini/"+ogg.nome_cartella+"/" + ogg.foto[i];
                            if (i == 0) {
                                codice += "<div class=\"active item\" data-slide-number=\""+i+"\">"
                                    + "<img src=\""+percorso+"\"></div>";
                            } else {
                                codice += "<div class=\"item\" data-slide-number=\""+i+"\">"
                                    + "<img src=\""+percorso+"\"></div>";
                            }
                        }
                        codice += "</div>"

                            + "<a class=\"left carousel-control\" href=\"#myCarousel\" role=\"button\" data-slide=\"prev\">"
                            + "<span class=\"glyphicon glyphicon-chevron-left\"></span>"
                            + "</a>"
                            + "<a class=\"right carousel-control\" href=\"#myCarousel\" role=\"button\" data-slide=\"next\">"
                            + "<span class=\"glyphicon glyphicon-chevron-right\"></span>"
                            + "</a>"
                            + "</div>"
                            + "</div>"
                            + "</div>"
                            + "</div>"
                            + "</div>"
                            + "</div>";
                    }else {
                        codice += "<div class=\"alert alert-info\">" +
                            "<strong>Attenzione!</strong> Questo album non contiene foti!" +
                            "</div>"
                    }
                    $('#area_foto').empty();
                    $('#area_foto').append(codice);
                },
                error: function(){
                    alert("Chiamata fallita!!!");
                }
            });

        }
        jQuery(document).ready(function ($) {

            $('#myCarousel').carousel({
                interval: 5000
            });

            //Handles the carousel thumbnails
            $('[id^=carousel-selector-]').click(function () {
                var id_selector = $(this).attr("id");
                try {
                    var id = /-(\d+)$/.exec(id_selector)[1];
                    console.log(id_selector, id);
                    jQuery('#myCarousel').carousel(parseInt(id));
                } catch (e) {
                    console.log('Regex failed!', e);
                }
            });
            // When the carousel slides, auto update the text
            $('#myCarousel').on('slid.bs.carousel', function (e) {
                var id = $('.item.active').data('slide-number');
                $('#carousel-text').html($('#slide-content-' + id).html());
            });
        });
        function cambiaFoto(id_selector) {
            try {
                var id = /-(\d+)$/.exec(id_selector)[1];
                console.log(id_selector, id);
                jQuery('#myCarousel').carousel(parseInt(id));
            } catch (e) {
                console.log('Regex failed!', e);
            }
        }
    </script>
</head>
<body>
<div id="wrapper">
    <?php
    require '../Componenti_Base/Nav-SideBar.php';
    navUnLog();
    ?>
    <div id="page-wrapper">
        <?php
        $array_cartelle = array();
        $array_foto = array();
        include "../connessione.php";
        try {
            foreach ($connessione->query("SELECT * FROM `cartelle_f`") as $row) {
                $array_cartelle[] = array($row['id_c'], $row['nome_cartella']);
            }
            $num = rand(0, (count($array_cartelle) - 1));
            //$id_c = $array_cartelle[$num][0];
            $id_c = 1;
            foreach ($connessione->query("SELECT * FROM `foto` WHERE id_c = '$id_c'") as $row) {
                $array_foto[] = $row['nome_foto'];
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $connessione = NULL;
        ?>
        <div style="padding-top: 30px;" class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <ul class="nav navbar-nav navC navbar-navC">
                    <li class="dropdown dropdownC">
                        <a href="#" class="dropdown-toggle text-center" data-toggle="dropdown">Album Foto <i class="fa fa-folder"></i></a>
                        <ul class="dropdown-menu dropdown-menuC">
                            <?php
                            for ($i=0;$i<count($array_cartelle);$i++){
                                if($i==0){
                                    if($array_cartelle[$i][0]==1) {
                                        echo "<li><a onclick='cambioFoto(\"".$array_cartelle[$i][0]."\")' href=\"#\">Foto home page</a></li>";
                                    } else {
                                        echo "<li><a onclick='cambioFoto(\"".$array_cartelle[$i][0]."\")' href=\"#\">".$array_cartelle[$i][1]."</a></li>";
                                    }
                                } else {
                                    echo "<li class=\"divider\"></li>";
                                    if($array_cartelle[$i][0]==1) {
                                        echo "<li><a onclick='cambioFoto(\"".$array_cartelle[$i][0]."\")' href=\"#\">Foto home page</a></li>";
                                    } else {
                                        echo "<li><a onclick='cambioFoto(\"".$array_cartelle[$i][0]."\")' href=\"#\">".$array_cartelle[$i][1]."</a></li>";
                                    }
                                }
                            }
                            ?>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <?php
                echo "<div id='area_foto'>";
                    echo "<div id=\"main_area\">"
                        . "<div class=\"row\">"
                        . "<div class=\"col-lg-6 col-md-12 col-sm-12\" style='height: 500px; overflow-y: auto;' id=\"slider-thumbs\">"
                        . "<ul class=\"hide-bullets\">";
                    for ($i = 0; $i < count($array_foto); $i++) {
                        //$percorso = "../Immagini/" . $array_cartelle[$num][1] . "/" . $array_foto[$i];
                        $percorso = "../Immagini/Vecchi_tornei/" . $array_foto[$i];
                        if ($i == 0) {
                            echo "<li style='height: 90px;' class=\"col-sm-3\">"
                                . "<a class=\"thumbnail\" id=\"carousel-selector-$i\">"
                                . "<img src=\"$percorso\" style='height: 70px;'>"
                                . "</a>"
                                . "</li>";
                        } else {
                            echo "<li style='height: 90px;' class=\"col-sm-3\">"
                                . "<a class=\"thumbnail\" id=\"carousel-selector-$i\"><img style='height: 70px;' src=\"$percorso\"></a>"
                                . "</li>";
                        }
                    }
                    echo "</ul>"
                        . "</div>"
                        . "<div class=\"col-lg-6 col-md-12 col-sm-12\">"
                        . "<div class=\"col-xs-12\" id=\"slider\">"
                        . "<div class=\"row\">"
                        . "<div class=\"col-sm-12\" id=\"carousel-bounding-box\">"
                        . "<div class=\"carousel slide\" id=\"myCarousel\">"
                        . "<div class=\"carousel-inner\">";

                    for ($i = 0; $i < count($array_foto); $i++) {
                        //$percorso = "../Immagini/" . $array_cartelle[$num][1] . "/" . $array_foto[$i];
                        $percorso = "../Immagini/Vecchi_tornei/" . $array_foto[$i];
                        if ($i == 0) {
                            echo "<div class=\"active item\" data-slide-number=\"$i\">"
                                . "<img src=\"$percorso\"></div>";
                        } else {
                            echo "<div class=\"item\" data-slide-number=\"$i\">"
                                . "<img src=\"$percorso\"></div>";
                        }
                    }
                    echo "</div>"

                        . "<a class=\"left carousel-control\" href=\"#myCarousel\" role=\"button\" data-slide=\"prev\">"
                        . "<span class=\"glyphicon glyphicon-chevron-left\"></span>"
                        . "</a>"
                        . "<a class=\"right carousel-control\" href=\"#myCarousel\" role=\"button\" data-slide=\"next\">"
                        . "<span class=\"glyphicon glyphicon-chevron-right\"></span>"
                        . "</a>"
                        . "</div>"
                        . "</div>"
                        . "</div>"
                        . "</div>"
                        . "</div>"
                        . "</div>";
                echo "</div>";
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>