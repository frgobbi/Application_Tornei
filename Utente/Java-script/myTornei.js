/**
 * Created by francesco on 01/05/2017.
 */
function creaPopup(id_partita, id_torneo) {
    var codice = "";
    var codiceH = "";
    $('#bodyPartita').empty();
    $.ajax({
        type: "GET",
        url: "../Staff/metodi/dati_partita.php",
        data: "id_p=" + id_partita,
        success: function (risposta) {
            var ogg = $.parseJSON(risposta);
            console.log(ogg);

            codiceH += "<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>" +
                "<h4 id='titoloPartita' class=\"modal-title\">" + ogg.nome_sq1 + " VS " + ogg.nome_sq2 + "</h4>" +
                "</div>";
            $('#headerPartita').empty();
            $('#headerPartita').append(codiceH);
            codice += "<div class='container-fluid'>" +
                "<div class='row'>" +
                "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>" +
                "<div class=\"panel panel-primary\">" +
                "<div class=\"panel-heading\">Dati Partita</div>" +
                "<div class=\"panel-body\">" +
                "<div class='row'>" +
                "<div class=\"form-group col-xs-6\">" +
                "<label for=\"name_ad\">Data Partita:</label>" +
                "<input type=\"text\" value=\"" + ogg.data + "\" class=\"form-control\" id=\"name_ad\" name=\"name_ad\" readonly>" +
                "</div>" +
                "<div class=\"form-group col-xs-6\">" +
                "<label for=\"name_ad\">Ora Partita:</label>" +
                "<input type=\"text\" value=\"" + ogg.ora + "\" class=\"form-control\" id=\"name_ad\" name=\"name_ad\" readonly>" +
                "</div>" +
                "<div class=\"form-group col-xs-12\">" +
                "<label for=\"name_ad\">Luogo Partita:</label>" +
                "<input type=\"text\" value=\"" + ogg.campo + "\" class=\"form-control\" id=\"name_ad\" name=\"name_ad\" readonly>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>";

            $.ajax({
                type: "GET",
                url: "../Staff/metodi/dati_tempo.php",
                data: "id_p="+id_partita+"&sq1="+ogg.id_sq1+"&sq2="+ogg.id_sq2,
                success: function(risposta){
                    if (ogg.finish == 0) {
                        codice += "<div class='row>'>" +
                            "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>" +
                            "<div class='alert alert-info'>" +
                            "<strong>Attanzione!</strong> La partita non e' conclusa" +
                            "</div>" +
                            "</div>" +
                            "</div>";
                    }else{
                        codice += "<div id='esito_punti'><div class='row'>"
                            + "<div class=\"panel panel-primary\">"
                            //+"<div class=\"panel-heading\">"+dati_tempo.nomi_tempi[i-1]+"</div>"
                            + "<div class=\"panel-body\">"
                            /*Parte prima squadra*/
                            + "<div class='col-lg-offset-2 col-md-offset-2 col-lg-3 col-md-3 col-sm-6 col-xs-6'>"
                            //Nome Prima SQ
                            + "<div class='row'>"
                            + "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>"
                            + "<ul class=\"list-group\">"
                            + "<li class=\"list-group-item list-group-item-info text-center text-uppercase\">" + ogg.nome_sq1 + "</li>"
                            + "</ul>"
                            + "</div>"
                            + "</div>"
                            //Fino Nome Prima SQ
                            //Contatore Gol SQ1
                            + "<div style='padding: 15px;' class=\"input-group number-spinner\">"
                            + "<div class=\"btn-group-vertical\">"
                            + "<input type=\"text\" disabled style=\"font-size:40px; height:60px;\" class=\"form-control text-center\" value=\"" + ogg.esito[0] + "\">"
                            + "</div>"
                            + "</div>"
                            //Fine Contatore Gol SQ1
                            //Fine Parte assegnazione Gol/Cartellini SQ1
                            + "</div>";
                        //Fine Prima Squadra

                        codice += "<div class='col-lg-offset-2 col-md-offset-2 col-lg-3 col-md-3 col-sm-6 col-xs-6'>"
                            //Nome Sqconda SQ
                            + "<div class='row'>"
                            + "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>"
                            + "<ul class=\"list-group\">"
                            + "<li class=\"list-group-item list-group-item-info text-center text-uppercase\">" + ogg.nome_sq2 + "</li>"
                            + "</ul>"
                            + "</div>"
                            + "</div>"
                            //Fino Nome Seconda SQ
                            //Contatore Gol SQ2
                            + "<div style='padding: 15px;' class=\"input-group number-spinner\">"
                            + "<div class=\"btn-group-vertical\">"
                            + "<input type=\"text\" disabled style=\"font-size:40px; height:60px;\" class=\"form-control text-center\" value=\"" + ogg.esito[1] + "\">"
                            + "</div>"+
                            "</div>"+
                            "</div>"+
                            "</div>"
                            +"</div>"
                            + "</div>";

                        /*var dati = $.parseJSON(ogg);
                         Questo trasfoma il json in oggetto
                         */
                        var dati_tempo = $.parseJSON(risposta);
                        var codice_sq1 = "";
                        var codice_sq2 = "";
                        for(var i=0; i<dati_tempo.tempi_partita.length;i++){
                            codice_sq1 = "";
                            codice_sq2 = "";
                            if(dati_tempo.tempi_partita[i]!=0){

                                var id_sq1 = "punti_"+ogg.id_sq1+"-"+dati_tempo.tempi_partita[i];
                                var id_gol_tempo1 = "giocatori_"+ogg.id_sq1+"-"+dati_tempo.tempi_partita[i];
                                var id_sq2 = "punti_"+ogg.id_sq2+"-"+dati_tempo.tempi_partita[i];
                                var id_gol_tempo2 = "giocatori_"+ogg.id_sq2+"-"+dati_tempo.tempi_partita[i];
                                var id_area_punti1 = "G"+id_sq1;
                                var id_area_punti2 = "G"+id_sq2;
                                var id_area_cart1 = "cart_"+ogg.id_sq1+"-"+dati_tempo.tempi_partita[i];
                                var id_area_cart2 = "cart_"+ogg.id_sq2+"-"+dati_tempo.tempi_partita[i];
                                var id_area_conf1 = "conf_"+ogg.id_sq1+"-"+dati_tempo.tempi_partita[i];
                                var id_area_conf2 = "conf_"+ogg.id_sq2+"-"+dati_tempo.tempi_partita[i];
                                var name_option_sq1= "colore_"+ogg.id_sq1+"-"+dati_tempo.tempi_partita[i];
                                var name_option_sq2= "colore_"+ogg.id_sq2+"-"+dati_tempo.tempi_partita[i];
                                var id_option_sq1_G = "G"+ogg.id_sq1+"-"+dati_tempo.tempi_partita[i];
                                var id_option_sq2_G = "G"+ogg.id_sq2+"-"+dati_tempo.tempi_partita[i];
                                var id_option_sq1_R = "R"+ogg.id_sq1+"-"+dati_tempo.tempi_partita[i];
                                var id_option_sq2_R = "R"+ogg.id_sq2+"-"+dati_tempo.tempi_partita[i];
                                var id_tbody_sq1 = "Tb_"+ogg.id_sq1+"-"+dati_tempo.tempi_partita[i];
                                var id_tbody_sq2 = "Tb_"+ogg.id_sq2+"-"+dati_tempo.tempi_partita[i];

                                    codice_sq1 += "<div class='row'>"
                                        +"<div class=\"panel panel-primary\">"
                                        +"<div class=\"panel-heading\">"+dati_tempo.nomi_tempi[i-1]+"</div>"
                                        +"<div class=\"panel-body\">"
                                        /*Parte prima squadra*/
                                        +"<div class='col-lg-offset-2 col-md-offset-2 col-lg-3 col-md-3 col-sm-6 col-xs-6'>"
                                        //Nome Prima SQ
                                        +"<div class='row'>"
                                        +"<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>"
                                        +"<ul class=\"list-group\">"
                                        +"<li class=\"list-group-item list-group-item-info text-center text-uppercase\">"+ogg.nome_sq1+"</li>"
                                        +"</ul>"
                                        +"</div>"
                                        +"</div>"
                                        //Fino Nome Prima SQ
                                        //Contatore Gol SQ1
                                        +"<div style='padding: 15px;' class=\"input-group number-spinner\">"
                                        +"<div class=\"btn-group-vertical\">"
                                        +"<button class=\"btn btn-primary disabled\" disabled data-dir=\"up\" id=\""+ogg.id_sq1+"_"+dati_tempo.tempi_partita[i]+"\"><span class=\"glyphicon glyphicon-plus\"></span></button>"
                                        +"<input type=\"text\" disabled id=\""+id_sq1+"\" style=\"font-size:40px; height:60px;\" class=\"form-control text-center\" value=\""+dati_tempo.punti_tempo_sq1[i]+"\">"
                                        +"<button class=\"btn btn-primary disabled\" disabled id=\""+ogg.id_sq1+"_"+dati_tempo.tempi_partita[i]+"\" data-dir=\"dwn\"><span class=\"glyphicon glyphicon-minus\"></span></button>"
                                        +"</div>"
                                        +"</div>"
                                        //Fine Contatore Gol SQ1
                                        //Parte assegnazione Gol/cartellini SQ1
                                        +"<div class='row'>"
                                        +"<button type=\"button\" class=\"btn btn-info btn-block\" data-toggle=\"collapse\" data-target=\"#"+id_gol_tempo1+"\">Info Tempo</button>"
                                        +"<div style='padding-top:10px;' id=\""+id_gol_tempo1+"\" class=\"collapse\">"
                                        +"<div class='row' id=\""+id_area_punti1+"\">";
                                    $.each(dati_tempo.gol_sq1, function(idx, obj) {
                                        if(obj.id_tempo == dati_tempo.tempi_partita[i]) {
                                            if(obj.giocatore.length>1){
                                                codice_sq1 +="<div class='panel panel-primary'>"
                                                    +"<div class='panel-body'>"
                                                codice_sq1+="<ul class='list-group'>";
                                                for(var z =1;z<obj.giocatore.length;z++){
                                                    codice_sq1+="<li class='list-group-item'><label>Gol "+parseInt(z)+":</label> "+obj.giocatore[z]+"</li>";
                                                    console.log(obj.giocatore[z]);
                                                }
                                                codice_sq1+="</ul>"
                                                    +"</div>"
                                                    +"</div>";
                                            }

                                        }
                                    });
                                    codice_sq1+="</div>";
                                    codice_sq1 +="<div class='row' id=\""+id_area_cart1+"\">" +
                                        "<div id=\"cartellino_"+ogg.id_sq1+"_"+dati_tempo.tempi_partita[i]+"\" >" +
                                        "<table class=\"table table-bordered table-hovered\">"+
                                        "<thead>"+
                                        "<tr>"+
                                        "<th>Giocatore</th>"+
                                        "<th>Cartellino</th>"+
                                        "<th></th>"+
                                        "</tr>"+
                                        "</thead>"+
                                        "<tbody id=\""+id_tbody_sq1+"\">";

                                    $.each(dati_tempo.cartellini_sq1, function(idx, obj){
                                        //console.log(idx);
                                        //console.log(obj.id_tempo+"--"+dati_tempo.tempi_partita[i]);
                                        if(obj.id_tempo == dati_tempo.tempi_partita[i]){
                                            //console.log("ci sono");
                                            for(var z=1;z<obj.id_cartellini.length;z++){
                                                //console.log(z);
                                                //console.log(obj.colore_cartellini[z].localeCompare("G"));
                                                var id_tr = "TR_"+obj.id_cartellini[z];
                                                if(obj.colore_cartellini[z].localeCompare("G")==0){
                                                    codice_sq1+= "<tr id=\""+id_tr+"\" class='warning'>";
                                                    codice_sq1+="<td>"+obj.nome_g_cartellini[z]+"</td>";
                                                    codice_sq1+="<td>Giallo</td>";
                                                    codice_sq1+="<td><button type='button' disabled onclick='elimina_cartellino(\""+obj.id_cartellini[z]+"\")' class='btn btn-danger disabled'><i class='fa fa-times'></i> </button></td>"
                                                    codice_sq1+="</tr>";
                                                } else {
                                                    codice_sq1+= "<tr id=\""+id_tr+"\" class='danger'>"
                                                    codice_sq1+="<td>"+obj.nome_g_cartellini[z]+"</td>";
                                                    codice_sq1+="<td>Rosso</td>";
                                                    codice_sq1+="<td><button type='button' disabled onclick='elimina_cartellino(\""+obj.id_cartellini[z]+"\")' class='btn btn-danger disabled'><i class='fa fa-times'></i> </button></td>"
                                                    codice_sq1+="</tr>";
                                                }
                                            }
                                        }
                                    });
                                    codice_sq1+="</tbody>"+
                                        "</table>" +
                                        "</div>";
                                    codice_sq1+="</div>";
                                    codice_sq1+="</div>";
                                    codice_sq1+="</div>";
                                    //Fine Parte assegnazione Gol/Cartellini SQ1
                                    codice_sq1+="</div>";
                                    //Fine Prima Squadra
                                    //Parte Seconda squadra
                                    codice_sq2 = "<div class='col-lg-offset-2 col-md-offset-2 col-lg-3 col-md-3 col-sm-6 col-xs-6'>"
                                        //Nome Sqconda SQ
                                        +"<div class='row'>"
                                        +"<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>"
                                        +"<ul class=\"list-group\">"
                                        +"<li class=\"list-group-item list-group-item-info text-center text-uppercase\">"+ogg.nome_sq2+"</li>"
                                        +"</ul>"
                                        +"</div>"
                                        +"</div>"
                                        //Fino Nome Seconda SQ
                                        //Contatore Gol SQ2
                                        +"<div style='padding: 15px;' class=\"input-group number-spinner\">"
                                        +"<div class=\"btn-group-vertical\">"
                                        +"<button class=\"btn btn-primary disabled \" disabled data-dir=\"up\" id=\""+ogg.id_sq2+"_"+dati_tempo.tempi_partita[i]+"\"><span class=\"glyphicon glyphicon-plus\"></span></button>"
                                        +"<input type=\"text\" disabled id=\""+id_sq2+"\" style=\"font-size:40px; height:60px;\" class=\"form-control text-center\" value=\""+dati_tempo.punti_tempo_sq2[i]+"\">"
                                        +"<button class=\"btn btn-primary disabled\" disabled id=\""+ogg.id_sq2+"_"+dati_tempo.tempi_partita[i]+"\" data-dir=\"dwn\"><span class=\"glyphicon glyphicon-minus\"></span></button>"
                                        +"</div>"
                                        +"</div>"
                                        //Fine Contatore Gol SQ2
                                        //Parte assegnazione Gol/cartellini SQ2
                                        +"<div class='row'>"
                                        +"<button type=\"button\" class=\"btn btn-info btn-block\" data-toggle=\"collapse\" data-target=\"#"+id_gol_tempo2+"\">Info Tempo</button>"
                                        +"<div style='padding-top:10px;' id=\""+id_gol_tempo2+"\" class=\"collapse\">"
                                        +"<div class='row' id=\""+id_area_punti2+"\">";
                                    $.each(dati_tempo.gol_sq2, function(idx, obj) {
                                        if(obj.id_tempo == dati_tempo.tempi_partita[i]) {
                                            if(obj.giocatore.length>1){
                                                codice_sq2 +="<div class='panel panel-primary'>"
                                                    +"<div class='panel-body'>"
                                                codice_sq2+="<ul class='list-group'>";
                                                for(var z =1;z<obj.giocatore.length;z++){
                                                    codice_sq2+="<li class='list-group-item'><label>Gol "+parseInt(z)+":</label> "+obj.giocatore[z]+"</li>";
                                                    console.log(obj.giocatore[z]);
                                                }
                                                codice_sq2+="</ul>"
                                                    +"</div>"
                                                    +"</div>";
                                            }
                                        }
                                    });
                                    codice_sq2+="</div>";
                                    codice_sq2 +="<div class='row' id=\""+id_area_cart2+"\">" +
                                        "<div id=\"cartellino_"+ogg.id_sq2+"_"+dati_tempo.tempi_partita[i]+"\" >" +
                                        "<table class=\"table table-bordered table-hovered\">"+
                                        "<thead>"+
                                        "<tr>"+
                                        "<th>Giocatore</th>"+
                                        "<th>Cartellino</th>"+
                                        "<th></th>"+
                                        "</tr>"+
                                        "</thead>"+
                                        "<tbody id=\""+id_tbody_sq2+"\">";

                                    $.each(dati_tempo.cartellini_sq2, function(idx, obj){
                                        //console.log(idx);
                                        //console.log(obj.id_tempo+"--"+dati_tempo.tempi_partita[i]);
                                        if(obj.id_tempo == dati_tempo.tempi_partita[i]){
                                            //console.log("ci sono");
                                            for(var z=1;z<obj.id_cartellini.length;z++){
                                                var id_tr = "TR_"+obj.id_cartellini[z];
                                                //console.log(z);
                                                //console.log(obj.colore_cartellini[z].localeCompare("G"));
                                                if(obj.colore_cartellini[z].localeCompare("G")==0){
                                                    codice_sq2+= "<tr id=\""+id_tr+"\" class='warning'>";
                                                    codice_sq2+="<td>"+obj.nome_g_cartellini[z]+"</td>";
                                                    codice_sq2+="<td>Giallo</td>";
                                                    codice_sq2+="<td><button type='button' disabled onclick='elimina_cartellino(\""+obj.id_cartellini[z]+"\")' class='btn btn-danger disabled'><i class='fa fa-times'></i> </button></td>"
                                                    codice_sq2+="</tr>";
                                                } else {
                                                    codice_sq2+= "<tr id=\""+id_tr+"\" class='danger'>"
                                                    codice_sq2+="<td>"+obj.nome_g_cartellini[z]+"</td>";
                                                    codice_sq2+="<td>Rosso</td>";
                                                    codice_sq2+="<td><button type='button' disabled onclick='elimina_cartellino(\""+obj.id_cartellini[z]+"\")' class='btn btn-danger disabled'><i class='fa fa-times'></i> </button></td>"
                                                    codice_sq2+="</tr>";
                                                }

                                            }
                                        }
                                    });
                                    codice_sq2+="</tbody>"+
                                        "</table>" +
                                        "</div>";
                                    codice_sq2+="</div>";

                                    codice_sq2+="</div>"
                                        +"</div>"
                                        //Fine Parte assegnazione Gol/Cartellini SQ2
                                        +"</div>"
                                        //Fine Seconda Squadra
                                        +"</div>"
                                        +"</div>"
                                        +"</div>";
                            }
                            codice += codice_sq1+codice_sq2;
                        }
                    }
                    codice += "</div>";

                    $('#bodyPartita').append(codice);
                },
                error: function(){
                    alert("Chiamata fallita!!!");
                }
            });
        },
        error: function () {
            alert("Chiamata fallita!!!");
        }
    });
}