<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 18/02/2017
 * Time: 13:02
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
    <link rel="stylesheet" href="../Librerie/CSS/event-list.css">
    <link rel="stylesheet" href="CSS/elementi_cassa.css">
    <script type="text/javascript" src="Java-script/Cassa.js"></script>
    <style type="text/css">
    </style>
    <script type="text/javascript">
        function popupInfo() {
            creaInfo()
            $('#info_cassa').modal('show');
        }
        function popupCard() {
            if (indice_p > 0) {
                if (booleanSub == false) {
                    var code = "";
                    code+="<div class=\"row\">"+
                    "<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">"+
                    "<textarea style=\"background-color: white; height:70px;\" class=\"display form-control text-right\" disabled"+
                    "rows=\"1\" id=\"display_code\" onkeyup=\"lettura_cod()\"></textarea>"+
                    "</div>"+
                    "</div>"+
                    "<div style=\"padding-bottom: 15px;\" class=\"row\" id=\"button_code\">"+
                    "<div class=\"col-lg-6 col-md-6 col-sm-12 col-xs-12\">"+
                    "<button type=\"button\" onclick=\"scelta_pag('card')\" class=\"btn btn-primary btn-block\">"+
                    "<i class=\"fa fa-credit-card fa-5x\" aria-hidden=\"true\"></i></button>"+
                    "</div>"+
                    "<div class=\"col-lg-6 col-md-6 col-sm-12 col-xs-12\">"+
                    "<button type=\"button\" onclick=\"scelta_pag('button')\" class=\"btn btn-primary btn-block\">"+
                    "<i class=\"fa fa-calculator fa-5x\" aria-hidden=\"true\"></i></button>"+
                    "</div>"+
                    "</div>"+
                    "<div class=\"row\">"+
                    "<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">"+
                    "<div class=\"alert alert-success alert_card text-center\" id=\"esito_pos\">"+
                    "<strong>Pagamento eseguito!</strong><br> Transazione avvenuta!!"+
                    "</div>"+
                    "<div class=\"alert alert-warning alert_card text-center\" id=\"cod_errato\">"+
                    "<strong>Attenzione!</strong><br> Codice Card Inesistente!!"+
                    "</div>"+
                    "<div class=\"alert alert-danger alert_card text-center\" id=\"no_denaro\">"+
                    "<strong>Errore!</strong><br> Denaro non sufficiente!!"+
                    "</div>"+
                    "</div>"+
                    "</div>"+
                    "<div class=\"row\" id=\"tastiera_code\"><!--numeri-->"+
                    "<div class=\"col-md-4 col-lg-4 col-sm-4 col-xs-4\">"+
                    "<button onclick=\"tastiera('card','1')\" class=\"numeri btn btn-info btn-block\">1</button>"+
                    "</div>"+
                    "<div class=\"col-md-4 col-lg-4 col-sm-4 col-xs-4\">"+
                    "<button onclick=\"tastiera('card','2')\" class=\"numeri btn btn-info btn-block\">2</button>"+
                    "</div>"+
                    "<div class=\"col-md-4 col-lg-4 col-sm-4 col-xs-4\">"+
                    "<button onclick=\"tastiera('card','3')\" class=\"numeri btn btn-info btn-block\">3</button>"+
                    "</div>"+
                    "<div class=\"col-md-4 col-lg-4 col-sm-4 col-xs-4\">"+
                    "<button onclick=\"tastiera('card','4')\" class=\"numeri btn btn-info btn-block\">4</button>"+
                    "</div>"+
                    "<div class=\"col-md-4 col-lg-4 col-sm-4 col-xs-4\">"+
                    "<button onclick=\"tastiera('card','5')\" class=\"numeri btn btn-info btn-block\">5</button>"+
                    "</div>"+
                    "<div class=\"col-md-4 col-lg-4 col-sm-4 col-xs-4\">"+
                    "<button onclick=\"tastiera('card','6')\" class=\"numeri btn btn-info btn-block\">6</button>"+
                    "</div>"+
                    "<div class=\"col-md-4 col-lg-4 col-sm-4 col-xs-4\">"+
                    "<button onclick=\"tastiera('card','7')\" class=\"numeri btn btn-info btn-block\">7</button>"+
                    "</div>"+
                    "<div class=\"col-md-4 col-lg-4 col-sm-4 col-xs-4\">"+
                    "<button onclick=\"tastiera('card','8')\" class=\"numeri btn btn-info btn-block\">8</button>"+
                    "</div>"+
                    "<div class=\"col-md-4 col-lg-4 col-sm-4 col-xs-4\">"+
                    "<button onclick=\"tastiera('card','9')\" class=\"numeri btn btn-info btn-block\">9</button>"+
                    "</div>"+
                    "<div class=\"col-md-4 col-lg-4 col-sm-4 col-xs-4\">"+
                    "<button onclick=\"tastiera('card','00')\" class=\"numeri btn btn-info btn-block\">00</button>"+
                    "</div>"+
                    "<div class=\"col-md-4 col-lg-4 col-sm-4 col-xs-4\">"+
                    "<button onclick=\"tastiera('card','0')\" class=\"numeri btn btn-info btn-block\">0</button>"+
                    "</div>"+
                    "<div class=\"col-md-4 col-lg-4 col-sm-4 col-xs-4\">"+
                    "<button onclick=\"tastiera('card','.')\" class=\"numeri btn btn-info btn-block\">.</button>"+
                    "</div>"+
                    "</div><!--numeri-->"+
                    "<div class=\"row\" id=\"conf_code\">"+
                    "<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">"+
                    "<button type=\"button\" onclick=\"avvio_tot_card()\" class=\"btn btn-primary btn-block\">Invio</button>"+
                    "</div>"+
                    "</div>";


                    $('#bodyCard').empty();
                    $('#bodyCard').append(code);
                    $('#conf_code').hide();
                    $('#tastiera_code').hide();
                    $('#button_code').show();
                    $('#display_code').prop("disabled", true);
                    $('#esito_pos').hide();
                    $('#cod_errato').hide();
                    $('#no_denaro').hide();
                    $('#modal_card').modal('show');
                    t_card="";
                    $('#display_code').empty();
                    $('#display_code').append(t_card);

                } else {
                    alert("Prima cocludi l'ordine!!");
                }
            } else
            {
                alert("Prima ordina qualcosa!!!")
            }
        }
        function scelta_pag(tipo) {
            if (tipo.localeCompare("card") == 0) {
                $('#display_code').prop("disabled", false);
                document.getElementById("display_code").focus();
            } else {
                $('#conf_code').show();
                $('#tastiera_code').show();
                $('#button_code').hide();
            }
        }
        function lettura_cod() {
            var tasto = window.event.keyCode;
            if (tasto == 13) {
                //alert("hai premuto invio");
                var codice = $('#display_code').val();
                totale_card(codice);
                t_card="";
                $('#display_code').empty();
                $('#display_code').append(t_card);
            }
        }
        function avvio_tot_card() {
            var codice = $('#display_code').val();
            totale_card(codice);
        }
    </script>
</head>
<body>
<div id="wrapper">
    <?php
    require '../Componenti_Base/Nav-SideBar.php';
    navLogin();

    include "../connessione.php";
    try{
        $ogg_giorno = $connessione->query("SELECT DATE_FORMAT(data_g,'%d-%m-%Y') AS giorno_a FROM giorno WHERE chiuso = 0")->fetch(PDO::FETCH_OBJ);
        if($ogg_giorno != NULL){
            echo "<script>"
                ."var domanda = confirm(\"Oggi è il $ogg_giorno->giorno_a ??\");"
                ."if (domanda != true) {"
                    ."alert(\"Chiudi la giornata e apri quella di oggi\");"
                    ."window.location.href=\"Bar.php\";"
                ."}"
                ."</script>";
        } else {
            echo "<script>"
                ."alert(\"Apri una giornata prima di utilizzare la cassa\");"
                ."window.location.href=\"Bar.php\";"
                ."</script>";
        }
    }catch (PDOException $e){
        echo $e->getMessage();
    }
    $connessione = null;
    ?>
    <div id="page-wrapper">
        <div class="row" style="padding-top: 30px;">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i> <a href="../Home/home.php">Dashboard</a>
                    </li>
                    <li>
                        <i class="fa fa-shopping-basket"></i> <a href="Bar.php"> Bar</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-calculator" aria-hidden="true"></i> Cassa Bar
                    </li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12" style="padding-right: 30px;">
                <div class="row">
                    <div class="panel panel-primary" style="height: 500px; overflow-y: auto">
                        <div class="panel-body">
                            <?php
                            include "../connessione.php";
                            try {
                                foreach ($connessione->query("SELECT * FROM `prodotto` INNER JOIN cat_prodotto ON cat_prodotto.id_cat_prodotto = prodotto.id_cat_prodotto WHERE vendibile = 1 ORDER BY(prodotto.id_cat_prodotto) ASC") as $row) {
                                    $colore = $row['colore'];
                                    $prodotto = $row['nome_prodotto'];
                                    $prezzo = $row['prezzo'];
                                    $id = $row['id_prodotto'];
                                    echo "<div class=\"col-lg-3 col-md-6\">"
                                        . "<a href=\"#\" onclick=\"prodotto($id,$prezzo,'$prodotto')\">"
                                        . "<div class=\"panel panel-$colore \">"
                                        . "<div class=\"panel-heading\">"
                                        . "<div class='row text-center'><h4>$prodotto</h4></div>"
                                        . "<div style='padding-right: 5px;' class='row text-right'>$prezzo &euro;</div>"
                                        . "</div>"
                                        . "</div>"
                                        . "</a>"
                                        . "</div>";
                                }
                            } catch (PDOException $e) {
                                echo $e->getMessage();
                            }
                            $connessione = null;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <button type="button" onclick="popupInfo()" class="btn btn-lg btn-block btn-primary">Info
                            Cassa
                        </button>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <button type="button" onclick="annulla()" class="btn btn-lg btn-block btn-primary">Annulla Tot
                        </button>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <button type="button" onclick="cancella()" class="btn btn-lg btn-block btn-primary">Cancella
                        </button>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <button onclick="varie()" type="button" class="btn btn-lg btn-block btn-primary">Varie</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                <div class="row">
                    <div id="scontrino" class="panel panel-primary" style="height: 500px;">
                        <div class="panel-body">
                            <div class="row container-fluid" id="area_ordine"
                                 style="height: 380px; overflow-y: auto; overflow-x:hidden ">
                                <!--da javascript-->
                            </div>
                            <div class="row" id="area_sub_tot">
                                <hr>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left"><h4><b>Contante:</b></h4>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right" id="contante"><h4>
                                        <b>15.25 &euro;</b></h4></div>
                            </div>
                            <div class="row" id="area_tot">
                                <hr>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left"><h3><b>Tot:</b></h3></div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right" id="tot"><h3><b></b></h3>
                                </div>

                            </div>
                            <div class="row" id="area_resto">
                                <hr>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left"><h4><b>Resto:</b></h4></div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right" id="resto"><h4>
                                        <b>15.25 &euro;</b></h4></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group btn-group-justified">
                        <a href="#" onclick="subtotale()" class="btn btn-primary btn-lg">Sub</a>
                        <a href="#" onclick="totale_ord()" class="btn btn-primary btn-lg">Totale</a>
                        <a href="#" onclick="popupCard()" class="btn btn-primary btn-lg">Card</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    $('#area_sub_tot').hide();
    $('#area_resto').hide();
</script>
<!-- Modal Varie-->
<div class="modal fade" id="modal_varie" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Varie</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <textarea style="background-color: white" class="display form-control text-right" disabled
                                  rows="1" id="display_varie"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','1')" class="numeri btn btn-info btn-block">1</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','2')" class="numeri btn btn-info btn-block">2</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','3')" class="numeri btn btn-info btn-block">3</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','4')" class="numeri btn btn-info btn-block">4</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','5')" class="numeri btn btn-info btn-block">5</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','6')" class="numeri btn btn-info btn-block">6</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','7')" class="numeri btn btn-info btn-block">7</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','8')" class="numeri btn btn-info btn-block">8</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','9')" class="numeri btn btn-info btn-block">9</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','00')" class="numeri btn btn-info btn-block">00</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','0')" class="numeri btn btn-info btn-block">0</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('varie','.')" class="numeri btn btn-info btn-block">.</button>
                    </div>
                </div><!--numeri-->
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <button type="button" onclick="annullaVarie()" class="btn btn-danger btn-block">Cancella
                        </button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <button type="button" onclick="prodotto_varie()" class="btn btn-primary btn-block">Varie
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal SubTotale-->
<div class="modal fade" id="modal_subtot" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Contanti</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <textarea style="background-color: white" class="display form-control text-right" disabled
                                  rows="1" id="display_sub"></textarea>
                    </div>
                </div>
                <div class="row"><!--numeri-->
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','1')" class="numeri btn btn-info btn-block">1</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','2')" class="numeri btn btn-info btn-block">2</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','3')" class="numeri btn btn-info btn-block">3</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','4')" class="numeri btn btn-info btn-block">4</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','5')" class="numeri btn btn-info btn-block">5</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','6')" class="numeri btn btn-info btn-block">6</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','7')" class="numeri btn btn-info btn-block">7</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','8')" class="numeri btn btn-info btn-block">8</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','9')" class="numeri btn btn-info btn-block">9</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','00')" class="numeri btn btn-info btn-block">00</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','0')" class="numeri btn btn-info btn-block">0</button>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                        <button onclick="tastiera('sub','.')" class="numeri btn btn-info btn-block">.</button>
                    </div>
                </div><!--numeri-->
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <button type="button" onclick="annullaResto()" class="btn btn-danger btn-block">Resto 0</button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <button type="button" onclick="totale_ord()" class="btn btn-primary btn-block">Resto</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal infoCassa -->
<div class="modal fade" id="info_cassa" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Info Cassa</h4>
            </div>
            <div id="bodyInfoC" class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- modal card -->
<div class="modal fade" id="modal_card" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Varie</h4>
            </div>
            <div class="modal-body" id="bodyCard">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>