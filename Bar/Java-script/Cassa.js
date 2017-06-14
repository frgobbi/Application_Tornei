/**
 * Created by francesco on 07/03/2017.
 */
var prodotti = []; //array indice prodotti
var quantita = []; //array quantità
var des = []; //array descrizione
var prezzi = []; //array prezzi
var indice_p = 0; //indice prodotto
var resto = 0; //resta
var totale = 0; //totale
var contanti = 0; //contanti del subtot
var t_v = ""; //variabile per tastiera varie
var t_card = "";
var booleanSub = false; //boolean per riconoscere subtotale
var i, j; //indice per array
var t_sub = ""; //variabile per statiera sub
var booleanScontrino = true;
/*Quasi tutti i metodi devono avere come prima riga
 if(booleanSub == false){

 } else {
 alert("Prima cocludi l'ordine!!");
 }
 */

//----------------------------------------------------------------------------------------------------------------------
//                -------------------------- Creazione Conto --------------------------
//----------------------------------------------------------------------------------------------------------------------

//Scontrino virtuale
function scontrino_v() {
    $('#scontrino').removeClass('barra_y');
    $('#area_sub_tot').hide();
    $('#area_resto').hide();
    var tot = 0;
    $('#area_ordine').empty();
    for (i = 0; i < indice_p; i++) {
        var codice = "<div class=\"row\">"
            + "<div class=\"col-lg-4 col-md-5 col-sm-4 col-xs-4 text-left\">" + des[i] + "</div>";
        var arr_num = prezzi[i].toString().split('.');
        //console.log(arr_num.length);
        if (prezzi[i].toString().indexOf(".") != (-1)) {
            if (arr_num[1] < 10) {
                codice += "<div class=\"col-lg-4 col-md-3 col-sm-4 col-xs-4 text-center\">" + quantita[i] + "X" + prezzi[i] + "0 &euro;</div>";
            } else {
                codice += "<div class=\"col-lg-4 col-md-3 col-sm-4 col-xs-4 text-center\">" + quantita[i] + "X" + prezzi[i] + " &euro;</div>";
            }
        } else {
            //console.log("va");
            codice += "<div class=\"col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center\">" + quantita[i] + "X" + prezzi[i] + ".00 &euro;</div>";
        }
        var prezzo = parseInt(quantita[i]) * parseFloat(prezzi[i]);
        codice += "<div class=\"col-lg-3 col-md-4 col-sm-3 col-xs-4 text-right\">" + prezzo + " &euro;</div>"
            + "<div class=\"col-lg-12\"><hr></div>"
            + "</div>";
        $('#area_ordine').append(codice);
        tot = tot + parseFloat(prezzo);
    }
    $('#tot').empty();
    var cod = "<h3><b>" + tot + " &euro;</b></h3>"
    $('#tot').append(cod);
}
//Scontrino virtuale vuoto
function scontrinoCanc() {
    $('#scontrino').removeClass('barra_y');
    $('#area_sub_tot').hide();
    $('#area_resto').hide();
    $('#area_ordine').empty();
    $('#display_sub').empty();
    $('#display_varie').empty();
    $('#tot').empty();
}
//Inserimento dei prodotti
function prodotto(id, prezzo, descrizione_p) {
    if (booleanSub == false) {
        var app = false;
        var ind = null;
        /* Controllo se il prodotto
         * è già nella lista */
        for (i = 0; i < des.length; i++) {
            if (descrizione_p.localeCompare(des[i]) == 0) {
                app = true;
                ind = i;
            }
        }

        //aggiungo o aggiorno il prodotto
        if (app == true) {
            quantita[ind]++;
        } else {
            prodotti[indice_p] = id;
            quantita[indice_p] = 1;
            prezzi[indice_p] = prezzo;
            des[indice_p] = descrizione_p;
            indice_p++;
        }
        scontrino_v();
    } else {
        alert("Prima cocludi l'ordine!!");
    }
}
//apre il popupVarie
function varie() {
    if (booleanSub == false) {
        $('#modal_varie').modal('show');
    } else {
        alert("Prima cocludi l'ordine!!");
    }
}
//tastierini
function tastiera(tipo, num) {
    if (tipo.localeCompare("varie") == 0) {
        $('#display_varie').empty();
        t_v = t_v + num;
        var str = t_v + " &euro;";
        $('#display_varie').append(str);
    } else {
        if (tipo.localeCompare("sub") == 0) {
            $('#display_sub').empty();
            t_sub = t_sub + num;
            var str = t_sub + " &euro;";
            $('#display_sub').append(str);
        } else {
            $('#display_code').empty();
            t_card = t_card + num;
            var str = t_card;
            $('#display_code').append(str);
        }
    }
}
//cancellare ultimo articolo
function cancella() {
    if (booleanSub == false) {
        if (quantita[indice_p - 1] > 1) {
            quantita[indice_p - 1]--;
        } else {
            quantita[indice_p - 1] = null;
            prezzi[indice_p - 1] = null;
            prodotti[indice_p - 1] = null;
            des[indice_p - 1] = null;
            indice_p--;
        }
        scontrino_v();
    } else {
        alert("Prima cocludi l'ordine!!");
    }
}
//annullamento dell'ordine
function annulla() {
    prodotti = [];
    quantita = [];
    des = [];
    prezzi = [];
    indice_p = 0;
    resto = 0;
    totale = 0;
    contanti = 0;
    t_v = "";
    booleanSub = false;
    t_sub = "";
    scontrinoCanc();
}
//inserimento di un articolo varie
function prodotto_varie() {
    var prezzo = parseFloat(t_v);
    prodotti[indice_p] = null;
    quantita[indice_p] = 1;
    prezzi[indice_p] = prezzo;
    des[indice_p] = "Varie";
    indice_p++;
    scontrino_v();
    t_v = "";
    $('#modal_varie').modal('hide');
    $('#display_varie').empty();
}
//annulla varie
function annullaVarie() {
    t_v = "";
    $('#modal_varie').modal('hide');
    $('#display_varie').empty();
}

//----------------------------------------------------------------------------------------------------------------------
//                -------------------------- Parte totali conto --------------------------
//----------------------------------------------------------------------------------------------------------------------

//subtotale
function subtotale() {
    if (indice_p > 0) {
        $('#display_sub').empty();
        booleanSub = true;
        $('#modal_subtot').modal('show');
    } else {
        alert("Prima ordina qualcosa!!!")
    }
}
//annullamento del resto
function annullaResto() {
    booleanSub = false;
    $('#modal_subtot').modal('hide');
    totale_ord();

}
//totale Ordine
function totale_ord() {
    if (indice_p > 0) {
        var tot = 0;
        for (i = 0; i < indice_p; i++) {
            var prezzo = parseInt(quantita[i]) * parseFloat(prezzi[i]);
            tot = tot + parseFloat(prezzo);
        }
        totale = tot;
        totale = arrotonda(totale, 2);
        var strId = "";
        var strPrezzi = "";
        var strQuantita = "";
        var strDesc = "";

        for (i = 0; i < indice_p; i++) {
            if (i == 0) {
                strId += "id" + i + "=" + prodotti[i];
                strPrezzi += "prezzi" + i + "=" + prezzi[i];
                strQuantita += "quant" + i + "=" + quantita[i];
                strDesc += "desc" + i + "=" + des[i];
            } else {
                strId += "&id" + i + "=" + prodotti[i];
                strPrezzi += "&prezzi" + i + "=" + prezzi[i];
                strQuantita += "&quant" + i + "=" + quantita[i];
                strDesc += "&desc" + i + "=" + des[i];
            }
        }
        var parametri = strId + "&" + strPrezzi + "&" + strQuantita + "&" + strDesc + "&num_P=" + indice_p;

        $.ajax({
            type: "GET",
            url: "metodi/acquisto.php",
            data: parametri,
            dataType: "html",
            success: function (risposta) {
                if (risposta == 1) {
                    var str = "";
                    if (booleanSub == false) {
                        str = strStampa("SC");
                    } else {
                        contanti = t_sub;
                        resto = parseFloat(contanti) - parseFloat(totale);
                        resto = arrotonda(parseFloat(resto), 2);
                        str = strStampa("SC");

                        var strC = "<h4><b>" + contanti + " &euro;</b></h4>";
                        $('#contante').empty();
                        $('#contante').append(strC);

                        var strR = "<h4><b>" + resto + " &euro;</b></h4></div>";
                        $('#resto').empty();
                        $('#resto').append(strR);

                        $('#area_sub_tot').show();
                        $('#area_resto').show();

                        $('#scontrino').addClass('barra_y');
                        $('#modal_subtot').modal('hide');
                        $('#scontrino').animate({scrollTop: $('#scontrino').height()}, 100);
                    }

                    if (booleanScontrino == true) {
                        stampa(str);
                    }

                    prodotti = [];
                    quantita = [];
                    des = [];
                    prezzi = [];
                    indice_p = 0;
                    resto = 0;
                    totale = 0;
                    contanti = 0;
                    t_v = "";
                    booleanSub = false;
                    t_sub = "";
                }
            },
            error: function () {
                alert("Ordine non inserito!!");
            }
        });
    } else {
        alert("Prima ordina qualcosa!!!")
    }
}
//Totale con card
function totale_card(codice_card) {
    var tot = 0;
    for (i = 0; i < indice_p; i++) {
        var prezzo = parseInt(quantita[i]) * parseFloat(prezzi[i]);
        tot = tot + parseFloat(prezzo);
    }
    totale = tot;
    totale = arrotonda(totale, 2);
    var strId = "";
    var strPrezzi = "";
    var strQuantita = "";
    var strDesc = "";

    for (i = 0; i < indice_p; i++) {
        if (i == 0) {
            strId += "id" + i + "=" + prodotti[i];
            strPrezzi += "prezzi" + i + "=" + prezzi[i];
            strQuantita += "quant" + i + "=" + quantita[i];
            strDesc += "desc" + i + "=" + des[i];
        } else {
            strId += "&id" + i + "=" + prodotti[i];
            strPrezzi += "&prezzi" + i + "=" + prezzi[i];
            strQuantita += "&quant" + i + "=" + quantita[i];
            strDesc += "&desc" + i + "=" + des[i];
        }
    }
    var parametri = strId + "&" + strPrezzi + "&" + strQuantita + "&" + strDesc + "&num_P=" + indice_p + "&codice="+codice_card;
    $.ajax({
        type: "GET",
        url: "metodi/acquisto_card.php",
        data: parametri,
        dataType: "html",
        success: function (risposta) {
            if(risposta ==3){
                $('#no_denaro').show();
                $('#esito_pos').hide();
                $('#cod_errato').hide();
                setTimeout(function(){ $('#modal_card').modal('hide') }, 2000);
            } else{
                if(risposta==2){
                    $('#cod_errato').show();
                    $('#no_denaro').hide();
                    $('#esito_pos').hide();
                    setTimeout(function(){ $('#modal_card').modal('hide') }, 2000);
                } else{
                    if(risposta==1){
                        var str = strStampa("SC-CARD");
                        alert(str);
                        stampa(str);
                        $('#esito_pos').show();
                        $('#no_denaro').hide();
                        $('#cod_errato').hide();
                        prodotti = [];
                        quantita = [];
                        des = [];
                        prezzi = [];
                        indice_p = 0;
                        resto = 0;
                        totale = 0;
                        contanti = 0;
                        t_v = "";
                        booleanSub = false;
                        t_sub = "";
                        setTimeout(function(){ $('#modal_card').modal('hide') }, 2000);
                    } else {
                        if(risposta==0){
                            alert("Qualcosa è andato storto... Riprovare");
                        }
                    }
                }
            }
        },
        error: function () {
            alert("Ordine non inserito!!");
        }
    });
}

//----------------------------------------------------------------------------------------------------------------------
//                -------------------------- Parte per la stampa --------------------------
//----------------------------------------------------------------------------------------------------------------------
//toString Inter0 (massimo 3 cifre)
function toStringIntero(numero) {
    var str = "";
    if (numero < 10) {
        str += "  " + numero;
    } else {
        if (numero < 100) {
            str += " " + numero;
        } else {
            str += numero;
        }
    }
    return str;
}
//toString Decimale (3 cifre parte intera, 2 cifre parte decimale
function toStringDecimale(numero) {
    var arr_num = numero.toString().split('.');
    var str = "";
    if (arr_num[0] < 10) {
        str += "  " + arr_num[0];
    } else {
        if (arr_num[0] < 100) {
            str += " " + arr_num[0];
        } else {
            str += arr_num[0];
        }
    }
    str += ".";
    if (numero.toString().indexOf(".") != (-1)) {
        if (arr_num[1] < 10) {
            str += arr_num[1] + "0";
        } else {
            str += arr_num[1];
        }
    } else {
        str += "00";
    }
    return str;
}
//Stringa per stampante
function strStampa(tipo) {
    var str = "";
    if (tipo.localeCompare("SC") == 0) {
        str += "2;1                                   EURO;1";
        for (i = 0; i < indice_p; i++) {
            var sp1 = "";//spazio1
            var numTx = des[i].length;//parte testo
            var mancanti = 12 - parseInt(numTx);
            var app = "";
            for (j = 0; j < mancanti; j++) {
                app += " ";
            }
            var Tx = des[i] + app;//parte testo
            var sp2 = "     ";//spazio2
            var qua = toStringIntero(quantita[i]);//parte numeri
            var deci = toStringDecimale(prezzi[i]);
            var molt = qua + "X" + deci; //qua e prezzo
            var sp3 = "      ";//spazio3
            var prezzo = parseInt(quantita[i]) * parseFloat(prezzi[i]);
            var prezzo_str = toStringDecimale(prezzo); //tot prezzo
            var sp4 = " ";//spazio4
            str += sp1 + Tx + sp2 + molt + sp3 + prezzo_str + sp4 + ":";
        }

        //TOTALE SCONTRINO
        str += ";2;1";
        str += "TOTALE                           ";
        var cifra = toStringDecimale(totale); //tot prezzo
        str += cifra + ":";
        //CONTANTI E RESTO
        if (booleanSub == true) {
            str += "CONTANTE                         ";
            cifra = toStringDecimale(contanti);
            str += cifra + ":";
            str += "RESTO                            ";
            cifra = toStringDecimale(resto);
            str += cifra + ":";
        }
        str += ";4;5";
    } else {
        if(tipo.localeCompare("SC-CARD") == 0) {
            str += "2;1                                   EURO;1";
            for (i = 0; i < indice_p; i++) {
                var sp1 = "";//spazio1
                var numTx = des[i].length;//parte testo
                var mancanti = 12 - parseInt(numTx);
                var app = "";
                for (j = 0; j < mancanti; j++) {
                    app += " ";
                }
                var Tx = des[i] + app;//parte testo
                var sp2 = "     ";//spazio2
                var qua = toStringIntero(quantita[i]);//parte numeri
                var deci = toStringDecimale(prezzi[i]);
                var molt = qua + "X" + deci; //qua e prezzo
                var sp3 = "      ";//spazio3
                var prezzo = parseInt(quantita[i]) * parseFloat(prezzi[i]);
                var prezzo_str = toStringDecimale(prezzo); //tot prezzo
                var sp4 = " ";//spazio4
                str += sp1 + Tx + sp2 + molt + sp3 + prezzo_str + sp4 + ":";
            }
            //TOTALE SCONTRINO
            str += ";2;1";
            str += "TOTALE                           ";
            var cifra = toStringDecimale(totale); //tot prezzo
            str += cifra + ":;2;";
            str += "1           TRANSAZIONE ESEGUITA           \n         CASTELVIETO EVENTS CARD          ";
            str += ";4;5";
        }
    }
    return str;
}
//Stampa Scontrino
function stampa(str) {
    if(booleanScontrino==true) {
        $.ajax({
            type: "GET",
            url: "../Librerie/Stampante/Stampante.php",
            data: "comando=" + str,
            dataType: "html",
            success: function () {
            },
            error: function () {
                alert("Scontrino non stampato");
            }
        });
    }
}
//Ristampa scontrino
function ristampa(id_giorno, id_ord) {
    if(booleanScontrino==true) {
        $.ajax({
            type: "GET",
            url: "metodi/dati_ordine.php",
            data: "id_giorno=" + id_giorno + "&id_ord=" + id_ord,
            success: function (risposta) {
                var ogg = $.parseJSON(risposta);
                var tot_sc = 0;
                var str = "";
                str += "2;1           COPIA DELLO SCONTRINO          :                                   EURO;1";
                for (i = 1; i < ogg.desc_ord.length; i++) {
                    var sp1 = "";//spazio1
                    var numTx = ogg.desc_ord[i].length;//parte testo
                    var mancanti = 12 - parseInt(numTx);
                    var app = "";
                    for (j = 0; j < mancanti; j++) {
                        app += " ";
                    }
                    var Tx = ogg.desc_ord[i] + app;//parte testo
                    var sp2 = "     ";//spazio2
                    var qua = toStringIntero(ogg.num_p[i]);//parte numeri
                    var deci = toStringDecimale(ogg.prezzo[i]);
                    var molt = qua + "X" + deci; //qua e prezzo
                    var sp3 = "      ";//spazio3
                    var prezzo = parseInt(ogg.num_p[i]) * parseFloat(ogg.prezzo[i]);
                    var prezzo_str = toStringDecimale(prezzo); //tot prezzo
                    tot_sc = parseFloat(tot_sc) + parseFloat(prezzo);
                    var sp4 = " ";//spazio4
                    str += sp1 + Tx + sp2 + molt + sp3 + prezzo_str + sp4 + ":";
                }

                //TOTALE SCONTRINO
                str += ";2;1";
                str += "TOTALE                           ";
                var cifra = toStringDecimale(tot_sc); //tot prezzo
                str += cifra + ":";
                str += ";4";
                stampa(str);
            },
            error: function () {
                alert("Scontrino non stampato");
            }
        });
    }
}
//Stampa Incasso
function stampa_incassoG(incassoTOT, incassoCard, Diff) {
    var str = "2;1                                      EURO;1";
    str += "Incasso Giornata                    "+toStringDecimale(incassoTOT)+":";
    str += "Incasso Credit Card                 "+toStringDecimale(incassoCard)+":";
    str += "Incasso in Contanti                 "+toStringDecimale(Diff)+":";
    str += ";2;4";
    if(booleanScontrino==true) {
        stampa(str);
    }
}
//Apri Cassetto
function apriCassetto() {
    var comando = "5";
    stampa(comando);
}

//----------------------------------------------------------------------------------------------------------------------
//                -------------------------- Parte Altro per cassa --------------------------
//----------------------------------------------------------------------------------------------------------------------
function creaInfo() {
    var codice = "";
    $.ajax({
        type: "GET",
        url: "metodi/Info_giorno.php",
        success: function (risposta) {
            var ogg = $.parseJSON(risposta);
            console.log(ogg);
            var inc_contanti = parseFloat(ogg.incasso) - parseFloat(ogg.incassoC);
            codice += "<div class='row'>";

            codice += "<div class='col-lg-8 col-md-8 col-sm-8 col-xs-8'>";
            codice += "<div class='panel panel-default'>" +
                "<div class='panel-heading text-center'>Ordini Effettuati</div>" +
                "<div class='panel-body' style=\"height: 410px; overflow-y: auto\">" +
                "<div class='table-responsive' >" +
                "<table class=\"table table-bordered table-hover\">" +
                "<thead>" +
                "<tr>" +
                "<th>Numero Ordine</th>" +
                "<th>Ora Ordinazione</th>" +
                "<th>Ristampa</th>" +
                "</tr>" +
                "</thead>" +
                "<tbody>";
            for (i = 1; i < ogg.ora_ord.length; i++) {
                codice += "<tr>" +
                    "<td>Ordine n&deg; " + ogg.id_ord[i] + "</td>" +
                    "<td>" + ogg.ora_ord[i] + "</td>" +
                    "<td class='text-center'><button class='btn btn-primary btn-block' onclick='ristampa("+ogg.id_giorno+","+ogg.id_ord[i]+")'><i class=\"fa fa-print\" aria-hidden=\"true\"></i></button></td>" +
                    "</tr>";
            }
            codice += "</tbody>" +
                "</table>" +
                "</div>";

            codice += "</div>";
            codice += "</div>";
            codice += "</div>";

            codice += "<div class='col-lg-4 col-md-4 col-sm-4 col-xs-4'>";
            codice += "<div class='panel panel-primary'>" +
                "<div class='panel-heading text-center'>Stampa Scontrini</div>" +
                "<div class='panel-body text-center'>";
            if (booleanScontrino == true) {
                codice += "<div class=\"btn-group\" id=\"status\" data-toggle=\"buttons\">"
                    + "<label class=\"btn btn-default btn-on btn-lg active\">"
                    + "<input type=\"radio\" onchange='stampanteOnOff()' id='stampanteON' value=\"1\" name=\"stampante\" checked=\"checked\">ON</label>"
                    + "<label class=\"btn btn-default btn-off btn-lg\">"
                    + "<input type=\"radio\" onchange='stampanteOnOff()' id='stampanteOFF' value=\"0\" name=\"stampante\">OFF</label>"
                    + "</div>";
            }
            else {
                codice += "<div class=\"btn-group\" id=\"status\" data-toggle=\"buttons\">"
                    + "<label class=\"btn btn-default btn-on btn-lg\">"
                    + "<input type=\"radio\" value=\"1\" id='stampanteON' onchange='stampanteOnOff()' name=\"stampante\">ON</label>"
                    + "<label class=\"btn btn-default btn-off btn-lg active\">"
                    + "<input type=\"radio\" value=\"0\" id='stampanteOFF' onchange='stampanteOnOff()' name=\"stampante\" checked=\"checked\">OFF</label>"
                    + "</div>";
            }
            codice += "</div>";
            codice += "<div class='panel-footer text-center'>" +
                "<button class='btn btn-primary btn-block'onclick='apriCassetto();'>Apri Cassetto</button>" +
                "</div>";
            codice += "</div>";

            codice += "<div class='panel panel-default'>" +
                "<div class='panel-heading text-center'>Incasso Giornata</div>" +
                "<div style=\"height: 215px\" class='panel-body text-center'>";
            //<h1>Example <span class="label label-default">New</span></h1>
            codice += "<ul class=\"list-group text-left\">"
                + "<li class=\"list-group-item\"><label>Incasso Serata:</label> " + ogg.incasso + " &euro;</li>"
                + "<li class=\"list-group-item\"><label>Incasso Credit Card:</label> " + ogg.incassoC + " &euro;</li>"
                + "<li class=\"list-group-item\"><label>Incasso in contanti:</label> " + inc_contanti + " &euro;</li>"
                + "</ul>";
            codice += "</div>";
            codice += "<div class='panel-footer text-center'>" +
                "<button class='btn btn-primary btn-block' onclick='stampa_incassoG(\""+ogg.incasso+"\",\""+ogg.incassoC+"\",\""+inc_contanti+"\")'>Stampa Incasso</button>" +
                "</div>";
            codice += "</div>";

            codice += "</div>";
            //chiusura
            codice += "</div>";
            $('#bodyInfoC').empty();
            $('#bodyInfoC').append(codice)
        },
        error: function () {
            alert("Chiamata fallita");
        }
    });
}
function stampanteOnOff() {
    var x = document.getElementById("stampanteON");
    if(x.checked){
        booleanScontrino=true;
    }

    var x = document.getElementById("stampanteOFF");
    if(x.checked){
        booleanScontrino=false;
    }
}

//----------------------------------------------------------------------------------------------------------------------
//                -------------------------- Arrotondamento a 2 cifre --------------------------
//----------------------------------------------------------------------------------------------------------------------
//Arrotonda a 2 cifre
function arrotonda(valore, nCifre) {
    if (isNaN(parseFloat(valore)) || isNaN(parseInt(nCifre)))
        return false;
    else
        return Math.round(valore * Math.pow(10, nCifre)) / Math.pow(10, nCifre);
}