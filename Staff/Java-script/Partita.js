/**
 * Created by francesco on 10/01/2017.
 */
function creaPopup(id_partita, id_torneo) {

    $('#bodyPartita').empty();
    $.ajax({
        type: "GET",
        url: "metodi/dati_partita.php",
        data: "id_p=" + id_partita,
        success: function (risposta) {
            /*var dati = $.parseJSON(ogg);
             Questo trasfoma il json in oggetto
             */
            var dati = $.parseJSON(risposta);
            var titolo = dati.nome_sq1 + " VS " + dati.nome_sq2;
            $('#titoloPartita').empty();
            $('#titoloPartita').append(titolo);
            //console.log(dati);
            var codice =
                "<div class='container-fluid'>" +
                "<div class='row'>"
                + "<div class=\"panel-group\">"
                + "<div class=\"panel panel-default\">"
                + "<div class=\"panel-heading\">";
                if(dati.finish==0){
                    codice+= "<a data-toggle=\"collapse\" href=\"#form\">";
                } else {
                    codice+= "<a data-toggle=\"collapse\" class='disabled' href=\"#\">";
                }
                codice += "<h4 class=\"panel-title\">"
                + "Modifica Partita"
                + "</h4>"
                + "</a>"
                + "</div>"
                + "<div id=\"form\" class=\"panel-collapse collapse\">"
                + "<div class=\"panel-body\">" +
                "<form method='post' action=\"metodi/modificaPartita.php?id=" + id_torneo + "&id_p=" + id_partita + "\">"
                + "<div class=\"form-group\">"
                + "<label for=\"usr\">Data:</label>"
                + "<input type=\"date\" class=\"form-control\" id=\"date\" name='data' value=\"" + dati.data + "\">"
                + "</div>"
                + "<div class=\"form-group\">"
                + "<label for=\"usr\">Ora:</label>"
                + "<input type=\"time\" class=\"form-control\" id=\"ora\" name='ora' value=\"" + dati.ora + "\">"
                + "</div>"
                + "<div class=\"form-group\">"
                + "<label for=\"usr\">Luogo:</label>"
                + "<input type=\"text\" class=\"form-control\" id=\"luogo\" name='luogo' value=\"" + dati.campo + "\">"
                + "</div>"
                + "<div class=\"form-group\">"
                + "<button type='submit' class='btn btn-primary btn-block'>Modifica Dati</button>"
                + "</div>"
                + "</form>"
                + "</div>"
                + "</div>"
                + "</div>"
                + "</div>"
                + "</div>";
            if(dati.finish ==1){
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
                    + "<li class=\"list-group-item list-group-item-info text-center text-uppercase\">" + dati.nome_sq1 + "</li>"
                    + "</ul>"
                    + "</div>"
                    + "</div>"
                    //Fino Nome Prima SQ
                    //Contatore Gol SQ1
                    + "<div style='padding: 15px;' class=\"input-group number-spinner\">"
                    + "<div class=\"btn-group-vertical\">"
                    + "<input type=\"text\" disabled style=\"font-size:40px; height:60px;\" class=\"form-control text-center\" value=\"" + dati.esito[0] + "\">"
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
                    + "<li class=\"list-group-item list-group-item-info text-center text-uppercase\">" + dati.nome_sq2 + "</li>"
                    + "</ul>"
                    + "</div>"
                    + "</div>"
                    //Fino Nome Seconda SQ
                    //Contatore Gol SQ2
                    + "<div style='padding: 15px;' class=\"input-group number-spinner\">"
                    + "<div class=\"btn-group-vertical\">"
                    + "<input type=\"text\" disabled style=\"font-size:40px; height:60px;\" class=\"form-control text-center\" value=\"" + dati.esito[1] + "\">"
                    + "</div>"+
                    "</div>"+
                    "</div>"+
                    "</div>"
                    +"</div>"
                    + "</div>";
                //Fine Contatore Gol SQ2
            }
            codice += "<div id='dati_partita'></div>";
            codice += "<div class='col-lg-8 col-lg-offset-2 col-md-6 col-md-offset-3 col-sm-12 col-xs-12' id='esito_partita'></div>";
            codice += "</div>";
            $('#bodyPartita').append(codice);
//______________________________________________________________________________________________________________________
            //Tempi

            $.ajax({
                type: "GET",
                url: "metodi/dati_tempo.php",
                data: "id_p="+id_partita+"&sq1="+dati.id_sq1+"&sq2="+dati.id_sq2,
                success: function(risposta){
                    /*var dati = $.parseJSON(ogg);
                     Questo trasfoma il json in oggetto
                     */
                    var dati_tempo = $.parseJSON(risposta);
                    var codice_sq1 = "";
                    var codice_sq2 = "";
                    codice = "";
                    for(var i=0; i<dati_tempo.tempi_partita.length;i++){
                        codice_sq1 = "";
                        codice_sq2 = "";
                        if(dati_tempo.tempi_partita[i]!=0){
                                
                            var id_sq1 = "punti_"+dati.id_sq1+"-"+dati_tempo.tempi_partita[i];
                            var id_gol_tempo1 = "giocatori_"+dati.id_sq1+"-"+dati_tempo.tempi_partita[i];
                            var id_sq2 = "punti_"+dati.id_sq2+"-"+dati_tempo.tempi_partita[i];
                            var id_gol_tempo2 = "giocatori_"+dati.id_sq2+"-"+dati_tempo.tempi_partita[i];
                            var id_area_punti1 = "G"+id_sq1;
                            var id_area_punti2 = "G"+id_sq2;
                            var id_area_cart1 = "cart_"+dati.id_sq1+"-"+dati_tempo.tempi_partita[i];
                            var id_area_cart2 = "cart_"+dati.id_sq2+"-"+dati_tempo.tempi_partita[i];
                            var id_area_conf1 = "conf_"+dati.id_sq1+"-"+dati_tempo.tempi_partita[i];
                            var id_area_conf2 = "conf_"+dati.id_sq2+"-"+dati_tempo.tempi_partita[i];
                            var name_option_sq1= "colore_"+dati.id_sq1+"-"+dati_tempo.tempi_partita[i];
                            var name_option_sq2= "colore_"+dati.id_sq2+"-"+dati_tempo.tempi_partita[i];
                            var id_option_sq1_G = "G"+dati.id_sq1+"-"+dati_tempo.tempi_partita[i];
                            var id_option_sq2_G = "G"+dati.id_sq2+"-"+dati_tempo.tempi_partita[i];
                            var id_option_sq1_R = "R"+dati.id_sq1+"-"+dati_tempo.tempi_partita[i];
                            var id_option_sq2_R = "R"+dati.id_sq2+"-"+dati_tempo.tempi_partita[i];
                            var id_tbody_sq1 = "Tb_"+dati.id_sq1+"-"+dati_tempo.tempi_partita[i];
                            var id_tbody_sq2 = "Tb_"+dati.id_sq2+"-"+dati_tempo.tempi_partita[i];


                            if(dati_tempo.close_tempo_sq1[i]==0){
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
                                    +"<li class=\"list-group-item list-group-item-info text-center text-uppercase\">"+dati.nome_sq1+"</li>"
                                    +"</ul>"
                                    +"</div>"
                                    +"</div>"
                                    //Fino Nome Prima SQ
                                    //Contatore Gol SQ1
                                    +"<div style='padding: 15px;' class=\"input-group number-spinner\">"
                                    +"<div class=\"btn-group-vertical\">"
                                    +"<button class=\"btn btn-primary\" data-dir=\"up\" id=\""+dati.id_sq1+"_"+dati_tempo.tempi_partita[i]+"\"><span class=\"glyphicon glyphicon-plus\"></span></button>"
                                    +"<input type=\"text\" id=\""+id_sq1+"\" style=\"font-size:40px; height:60px;\" class=\"form-control text-center\" value=\""+dati_tempo.punti_tempo_sq1[i]+"\">"
                                    +"<button class=\"btn btn-primary\" id=\""+dati.id_sq1+"_"+dati_tempo.tempi_partita[i]+"\" data-dir=\"dwn\"><span class=\"glyphicon glyphicon-minus\"></span></button>"
                                    +"</div>"
                                    +"</div>"
                                    //Fine Contatore Gol SQ1
                                    //Parte assegnazione Gol/cartellini SQ1
                                    +"<div class='row'>"
                                    +"<button type=\"button\" class=\"btn btn-info btn-block\" data-toggle=\"collapse\" data-target=\"#"+id_gol_tempo1+"\">Info Tempo</button>"
                                    +"<div style='padding-top:10px;' id=\""+id_gol_tempo1+"\" class=\"collapse\">"
                                    +"<div class='row' id=\""+id_area_punti1+"\"></div>";
                                codice_sq1 +="<div class='row' id=\""+id_area_cart1+"\">" +
                                    "<div id=\"cartellino_"+dati.id_sq1+"_"+dati_tempo.tempi_partita[i]+"\" >" +
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
                                                codice_sq1+="<td><button type='button' onclick='elimina_cartellino(\""+obj.id_cartellini[z]+"\")' class='btn btn-danger'><i class='fa fa-times'></i> </button></td>"
                                                codice_sq1+="</tr>";
                                            } else {
                                                codice_sq1+= "<tr id=\""+id_tr+"\" class='danger'>"
                                                codice_sq1+="<td>"+obj.nome_g_cartellini[z]+"</td>";
                                                codice_sq1+="<td>Rosso</td>";
                                                codice_sq1+="<td><button type='button' onclick='elimina_cartellino(\""+obj.id_cartellini[z]+"\")' class='btn btn-danger'><i class='fa fa-times'></i> </button></td>"
                                                codice_sq1+="</tr>";
                                            }

                                        }
                                    }
                                });


                                codice_sq1+="</tbody>"+
                                    "</table>" +
                                    "</div>"+
                                    "<div id=\"new_cartellino_"+dati.id_sq1+"_"+dati_tempo.tempi_partita[i]+"\" >" +
                                    "<div class='panel panel-primary'>" +
                                    "<div class='panel-heading'>Assegna Cartellini</div>" +
                                    "<div class='panel-body'>"+
                                    "<div class='form-group'>"
                                    +"<label for=\"SG"+dati.id_sq1+"_"+dati_tempo.tempi_partita[i]+"\">Giocatore:</label>"
                                    +"<select class=\"form-control\" id=\"SG"+dati.id_sq1+"_"+dati_tempo.tempi_partita[i]+"\">" +
                                    "<option value=\"nessuno\">Scegli Giocatore...</option>";
                                for(var j = 1; j<dati_tempo.sq1.id_giocatori.length;j++){
                                    codice_sq1 += "<option value=\""+dati_tempo.sq1.id_giocatori[j]+"\">"+dati_tempo.sq1.nomi_giocatori[j]+"</option>"
                                }
                                codice_sq1+= "</select>" +
                                    "</div>" +
                                    "<div class='form-group text-center'>" +
                                    "<label class=\"radio-inline\"><input id=\""+id_option_sq1_G+"\" checked type=\"radio\" value='G' name=\""+name_option_sq1+"\">Giallo</label>"+
                                    "<label class=\"radio-inline\"><input id=\""+id_option_sq1_R+"\" type=\"radio\" value='R' name=\""+name_option_sq1+"\">Rosso</label>" +
                                    "</div>" +
                                    "<div class='form-group'>" +
                                    "<button type='button' onclick='aggiungi_cartellino("+dati.id_sq1+","+dati_tempo.tempi_partita[i]+","+id_partita+")' class='btn btn-primary btn-block'>Aggiungi Cartellino</button>"+
                                    "</div>" +
                                    "</div>" +
                                    "</div>" +
                                    "</div>"+
                                    "</div>";
                                codice_sq1 +="<div class='row' id=\""+id_area_conf1+"\">"
                                    +"<button type='button' class='btn btn-success btn-block' onclick='conferma_tempo(\""+dati.id_sq1+"\",\""+dati_tempo.tempi_partita[i]+"\",\""+id_partita+"\",\""+id_torneo+"\")'>Conferma dati Tempo</button>"

                                    +"</div>"
                                    +"</div>"
                                    +"</div>"
                                    //Fine Parte assegnazione Gol/Cartellini SQ1
                                    +"</div>"
                                //Fine Prima Squadra
                            }
                            else{
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
                                    +"<li class=\"list-group-item list-group-item-info text-center text-uppercase\">"+dati.nome_sq1+"</li>"
                                    +"</ul>"
                                    +"</div>"
                                    +"</div>"
                                    //Fino Nome Prima SQ
                                    //Contatore Gol SQ1
                                    +"<div style='padding: 15px;' class=\"input-group number-spinner\">"
                                    +"<div class=\"btn-group-vertical\">"
                                    +"<button class=\"btn btn-primary disabled\" disabled data-dir=\"up\" id=\""+dati.id_sq1+"_"+dati_tempo.tempi_partita[i]+"\"><span class=\"glyphicon glyphicon-plus\"></span></button>"
                                    +"<input type=\"text\" disabled id=\""+id_sq1+"\" style=\"font-size:40px; height:60px;\" class=\"form-control text-center\" value=\""+dati_tempo.punti_tempo_sq1[i]+"\">"
                                    +"<button class=\"btn btn-primary disabled\" disabled id=\""+dati.id_sq1+"_"+dati_tempo.tempi_partita[i]+"\" data-dir=\"dwn\"><span class=\"glyphicon glyphicon-minus\"></span></button>"
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
                                    "<div id=\"cartellino_"+dati.id_sq1+"_"+dati_tempo.tempi_partita[i]+"\" >" +
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
                                /*codice_sq1+="<div id=\"new_cartellino_"+dati.id_sq1+"_"+dati_tempo.tempi_partita[i]+"\" >" +
                                    "<div class='panel panel-primary'>" +
                                    "<div class='panel-heading'>Assegna Cartellini</div>" +
                                    "<div class='panel-body'>"+
                                    "<div class='form-group'>"
                                    +"<label for=\"SG"+dati.id_sq1+"_"+dati_tempo.tempi_partita[i]+"\">Giocatore:</label>"
                                    +"<select class=\"form-control\" id=\"SG"+dati.id_sq1+"_"+dati_tempo.tempi_partita[i]+"\">" +
                                    "<option value=\"0\">Scegli Giocatore...</option>";
                                for(var j = 1; j<dati_tempo.sq1.id_giocatori.length;j++){
                                    codice_sq1 += "<option value=\""+dati_tempo.sq1.id_giocatori[j]+"\">"+dati_tempo.sq1.nomi_giocatori[j]+"</option>"
                                }
                                codice_sq1+= "</select>" +
                                    "</div>" +
                                    "<div class='form-group text-center'>" +
                                    "<label class=\"radio-inline\"><input id=\""+id_option_sq1_G+"\" checked type=\"radio\" value='G' name=\""+name_option_sq1+"\">Giallo</label>"+
                                    "<label class=\"radio-inline\"><input id=\""+id_option_sq1_R+"\" type=\"radio\" value='R' name=\""+name_option_sq1+"\">Rosso</label>" +
                                    "</div>" +
                                    "<div class='form-group'>" +
                                    "<button type='button' disabled onclick='aggiungi_cartellino("+dati.id_sq1+","+dati_tempo.tempi_partita[i]+","+id_partita+")' class='btn btn-primary btn-block disabled'>Aggiungi Cartellino</button>"+
                                    "</div>" +
                                    "</div>" +
                                    "</div>" +
                                    "</div>";*/
                                codice_sq1+="</div>";
                                /*codice_sq1 +="<div class='row' id=\""+id_area_conf1+"\">"
                                    +"<button type='button' class='btn btn-success btn-block' onclick='conferma_tempo(\""+dati.id_sq1+"\",\""+dati_tempo.tempi_partita[i]+"\",\""+id_partita+"\",\""+id_torneo+"\")'>Conferma dati Tempo</button>"
                                 +"</div>";*/
                                codice_sq1+="</div>";
                                codice_sq1+="</div>";
                                //Fine Parte assegnazione Gol/Cartellini SQ1
                                codice_sq1+="</div>";
                                //Fine Prima Squadra
                            }

                            if(dati_tempo.close_tempo_sq2[i]==0){
                                //Parte Seconda squadra
                                codice_sq2 = "<div class='col-lg-offset-2 col-md-offset-2 col-lg-3 col-md-3 col-sm-6 col-xs-6'>"
                                    //Nome Sqconda SQ
                                    +"<div class='row'>"
                                    +"<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>"
                                    +"<ul class=\"list-group\">"
                                    +"<li class=\"list-group-item list-group-item-info text-center text-uppercase\">"+dati.nome_sq2+"</li>"
                                    +"</ul>"
                                    +"</div>"
                                    +"</div>"
                                    //Fino Nome Seconda SQ
                                    //Contatore Gol SQ2
                                    +"<div style='padding: 15px;' class=\"input-group number-spinner\">"
                                    +"<div class=\"btn-group-vertical\">"
                                    +"<button class=\"btn btn-primary\" data-dir=\"up\" id=\""+dati.id_sq2+"_"+dati_tempo.tempi_partita[i]+"\"><span class=\"glyphicon glyphicon-plus\"></span></button>"
                                    +"<input type=\"text\" id=\""+id_sq2+"\" style=\"font-size:40px; height:60px;\" class=\"form-control text-center\" value=\""+dati_tempo.punti_tempo_sq2[i]+"\">"
                                    +"<button class=\"btn btn-primary\" id=\""+dati.id_sq2+"_"+dati_tempo.tempi_partita[i]+"\" data-dir=\"dwn\"><span class=\"glyphicon glyphicon-minus\"></span></button>"
                                    +"</div>"
                                    +"</div>"
                                    //Fine Contatore Gol SQ2
                                    //Parte assegnazione Gol/cartellini SQ2
                                    +"<div class='row'>"
                                    +"<button type=\"button\" class=\"btn btn-info btn-block\" data-toggle=\"collapse\" data-target=\"#"+id_gol_tempo2+"\">Info Tempo</button>"
                                    +"<div style='padding-top:10px;' id=\""+id_gol_tempo2+"\" class=\"collapse\">"
                                    +"<div class='row' id=\""+id_area_punti2+"\"></div>";
                                codice_sq2 +="<div class='row' id=\""+id_area_cart2+"\">" +
                                    "<div id=\"cartellino_"+dati.id_sq2+"_"+dati_tempo.tempi_partita[i]+"\" >" +
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
                                                codice_sq2+="<td><button type='button' onclick='elimina_cartellino(\""+obj.id_cartellini[z]+"\")' class='btn btn-danger'><i class='fa fa-times'></i> </button></td>"
                                                codice_sq2+="</tr>";
                                            } else {
                                                codice_sq2+= "<tr id=\""+id_tr+"\" class='danger'>"
                                                codice_sq2+="<td>"+obj.nome_g_cartellini[z]+"</td>";
                                                codice_sq2+="<td>Rosso</td>";
                                                codice_sq2+="<td><button type='button' onclick='elimina_cartellino(\""+obj.id_cartellini[z]+"\")' class='btn btn-danger'><i class='fa fa-times'></i> </button></td>"
                                                codice_sq2+="</tr>";
                                            }

                                        }
                                    }
                                });


                                codice_sq2+="</tbody>"+
                                    "</table>" +
                                    "</div>"+
                                    "<div id=\"new_cartellino_"+dati.id_sq2+"_"+dati_tempo.tempi_partita[i]+"\" >" +
                                    "<div class='panel panel-primary'>" +
                                    "<div class='panel-heading'>Assegna Cartellini</div>" +
                                    "<div class='panel-body'>"+
                                    "<div class='form-group'>"
                                    +"<label for=\"SG"+dati.id_sq2+"_"+dati_tempo.tempi_partita[i]+"\">Giocatore:</label>"
                                    +"<select class=\"form-control\" id=\"SG"+dati.id_sq2+"_"+dati_tempo.tempi_partita[i]+"\">" +
                                    "<option value=\"nessuno\">Scegli Giocatore...</option>";
                                for(var j = 1; j<dati_tempo.sq2.id_giocatori.length;j++){
                                    codice_sq2 += "<option value=\""+dati_tempo.sq2.id_giocatori[j]+"\">"+dati_tempo.sq2.nomi_giocatori[j]+"</option>"
                                }
                                codice_sq2+= "</select>" +
                                    "</div>" +
                                    "<div class='form-group text-center'>" +
                                    "<label class=\"radio-inline\"><input id=\""+id_option_sq2_G+"\" type=\"radio\" checked value='G' name=\""+name_option_sq2+"\">Giallo</label>"+
                                    "<label class=\"radio-inline\"><input id=\""+id_option_sq2_R+"\" type=\"radio\" value='R' name=\""+name_option_sq2+"\">Rosso</label>" +
                                    "</div>" +
                                    "<div class='form-group'>" +
                                    "<button type='button' onclick='aggiungi_cartellino("+dati.id_sq2+","+dati_tempo.tempi_partita[i]+","+id_partita+")' class='btn btn-primary btn-block'>Aggiungi Cartellino</button>"+
                                    "</div>" +
                                    "</div>" +
                                    "</div>" +
                                    "</div>"+
                                    "</div>";
                                codice_sq2 +="<div class='row' id=\""+id_area_conf2+"\">"
                                    +"<button type='button' class='btn btn-success btn-block' onclick='conferma_tempo(\""+dati.id_sq2+"\",\""+dati_tempo.tempi_partita[i]+"\",\""+id_partita+"\",\""+id_torneo+"\")'>Conferma dati Tempo</button>"

                                    +"</div>"
                                    +"</div>"
                                    +"</div>"
                                    //Fine Parte assegnazione Gol/Cartellini SQ2
                                    +"</div>"
                                    //Fine Seconda Squadra

                                    +"</div>"
                                    +"</div>"
                                    +"</div>";
                            }
                            else {
                                //Parte Seconda squadra
                                codice_sq2 = "<div class='col-lg-offset-2 col-md-offset-2 col-lg-3 col-md-3 col-sm-6 col-xs-6'>"
                                    //Nome Sqconda SQ
                                    +"<div class='row'>"
                                    +"<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>"
                                    +"<ul class=\"list-group\">"
                                    +"<li class=\"list-group-item list-group-item-info text-center text-uppercase\">"+dati.nome_sq2+"</li>"
                                    +"</ul>"
                                    +"</div>"
                                    +"</div>"
                                    //Fino Nome Seconda SQ
                                    //Contatore Gol SQ2
                                    +"<div style='padding: 15px;' class=\"input-group number-spinner\">"
                                    +"<div class=\"btn-group-vertical\">"
                                    +"<button class=\"btn btn-primary disabled \" disabled data-dir=\"up\" id=\""+dati.id_sq2+"_"+dati_tempo.tempi_partita[i]+"\"><span class=\"glyphicon glyphicon-plus\"></span></button>"
                                    +"<input type=\"text\" disabled id=\""+id_sq2+"\" style=\"font-size:40px; height:60px;\" class=\"form-control text-center\" value=\""+dati_tempo.punti_tempo_sq2[i]+"\">"
                                    +"<button class=\"btn btn-primary disabled\" disabled id=\""+dati.id_sq2+"_"+dati_tempo.tempi_partita[i]+"\" data-dir=\"dwn\"><span class=\"glyphicon glyphicon-minus\"></span></button>"
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
                                    "<div id=\"cartellino_"+dati.id_sq2+"_"+dati_tempo.tempi_partita[i]+"\" >" +
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
                              /*codice_sq2 +="<div id=\"new_cartellino_"+dati.id_sq2+"_"+dati_tempo.tempi_partita[i]+"\" >" +
                                    "<div class='panel panel-primary'>" +
                                    "<div class='panel-heading'>Assegna Cartellini</div>" +
                                    "<div class='panel-body'>"+
                                    "<div class='form-group'>"
                                    +"<label for=\"SG"+dati.id_sq2+"_"+dati_tempo.tempi_partita[i]+"\">Giocatore:</label>"
                                    +"<select class=\"form-control\" id=\"SG"+dati.id_sq2+"_"+dati_tempo.tempi_partita[i]+"\">" +
                                    "<option value=\"0\">Scegli Giocatore...</option>";
                                for(var j = 1; j<dati_tempo.sq2.id_giocatori.length;j++){
                                    codice_sq2 += "<option value=\""+dati_tempo.sq2.id_giocatori[j]+"\">"+dati_tempo.sq2.nomi_giocatori[j]+"</option>"
                                }
                                codice_sq2+= "</select>" +
                                    "</div>" +
                                    "<div class='form-group text-center'>" +
                                    "<label class=\"radio-inline\"><input id=\""+id_option_sq2_G+"\" type=\"radio\" checked value='G' name=\""+name_option_sq2+"\">Giallo</label>"+
                                    "<label class=\"radio-inline\"><input id=\""+id_option_sq2_R+"\" type=\"radio\" value='R' name=\""+name_option_sq2+"\">Rosso</label>" +
                                    "</div>" +
                                    "<div class='form-group'>" +
                                    "<button type='button' disabled onclick='aggiungi_cartellino("+dati.id_sq2+","+dati_tempo.tempi_partita[i]+","+id_partita+")' class='btn btn-primary btn-block disabled'>Aggiungi Cartellino</button>"+
                                    "</div>" +
                                    "</div>" +
                                    "</div>" +
                                    "</div>";*/
                                codice_sq2+="</div>";
                                /*codice_sq2 +="<div class='row' id=\""+id_area_conf2+"\">"
                                    +"<button type='button' class='btn btn-success btn-block' onclick='conferma_tempo(\""+dati.id_sq2+"\",\""+dati_tempo.tempi_partita[i]+"\",\""+id_partita+"\",\""+id_torneo+"\")'>Conferma dati Tempo</button>"
                                    +"</div>";*/
                                    codice_sq2+="</div>"
                                    +"</div>"
                                    //Fine Parte assegnazione Gol/Cartellini SQ2
                                    +"</div>"
                                    //Fine Seconda Squadra

                                    +"</div>"
                                    +"</div>"
                                    +"</div>";
                            }


                        }
                        codice += codice_sq1+codice_sq2;
                    }

                    $('#dati_partita').append(codice);

                },
                error: function(){
                    alert("Chiamata fallita!!!");
                }
            });
//______________________________________________________________________________________________________________________
            //Parte dell'admin partita
            $.ajax({
                type: "GET",
                url: "metodi/dati_tempo.php",
                data: "id_p="+id_partita,
                success: function(risposta){
                    /*var dati = $.parseJSON(ogg);
                     Questo trasfoma il json in oggetto
                     */
                    var dati_tempo = $.parseJSON(risposta);
                    //console.log(dati_tempo);
                    var codice = "";
                    if(dati.finish ==0) {
                        var codice = "<form class='form-inline'>" +
                            "<div class=\"form-group\">" +
                            "<label for=\"add" + id_partita + "\">Aggiungi Tempo: &nbsp;</label>" +
                            "<select class=\"form-control\" id=\"add" + id_partita + "\">";
                        for (var i = 0; i < dati_tempo.id_tempi.length; i++) {
                            var confronto = 0;
                            for (var j = 0; j < dati_tempo.tempi_partita.length; j++) {
                                if (dati_tempo.id_tempi[i] == dati_tempo.tempi_partita[j]) {
                                    confronto = 1;
                                }
                            }
                            if (confronto != 1) {
                                codice += "<option value=\"" + dati_tempo.id_tempi[i] + "\">" + dati_tempo.nomi_tempi[i] + "</option>";
                            }
                        }
                        codice += "</select>&nbsp;" +
                            "</div>" +
                            "<div class=\"form-group\">" +
                            "<button type='button' onclick='aggiungi_tempo(\"" + id_partita + "\",\"" + id_torneo + "\")' class='btn btn-primary'>Aggiungi Tempo <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>" +
                            "</div>" +
                            "</form>";
                    }
                        codice+="<div class='row'>" +
                        "<div class='col-lg-10 col-lg-offset-1 col-md-6 col-md-offset-3 col-sm-12 col-xs-12'>"+
                        "<div class=\"btn-group btn-group-lg\">";
                        if(dati.finish == 0){
                            codice+="<button type=\"button\" onclick='elimina_partita(\""+id_partita+"\",\""+id_torneo+"\")' class=\"btn btn-danger\">Annulla Partita <i class=\"fa fa-times-circle\" aria-hidden=\"true\"></i></button>" +
                                "<button type='button' onclick='conferma_partita(\""+id_partita+"\",\""+dati.id_sq1+"\",\""+dati.id_sq2+"\",\""+id_torneo+"\")' class='btn btn-success'>Concludi Partita <i class=\"fa fa-check-circle\" aria-hidden=\"true\"></i></button>"

                        } else {
                            codice+= "<button type=\"button\" class=\"btn btn-danger\" onclick='elimina_partita(\""+id_partita+"\",\""+id_torneo+"\")'>Annulla Partita <i class=\"fa fa-times-circle\" aria-hidden=\"true\"></i></button>" +
                                "<button type='button' disabled class='btn btn-success disabled'>Concludi Partita <i class=\"fa fa-check-circle\" aria-hidden=\"true\"></i></button>"

                        }
                        codice +="</div>"
                        +"</div>"
                        +"</div>";

                    $('#esito_partita').append(codice);



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
function aggiungi_tempo(id_partita,id_torneo){
    var key = "add"+id_partita;
    var valore = document.getElementById(key).value;
    var codice = "";
    //console.log(valore);
    $.ajax({
        type: "GET",
        url: "metodi/aggiungi_tempo.php",
        data: "id_partita="+id_partita+"&tempo="+valore,
        success: function(risposta){
            var dati_tempo = $.parseJSON(risposta);

             var id_sq1 = "punti_"+dati_tempo.id_sq1+"-"+dati_tempo.id_tempo;
             var id_gol_tempo1 = "giocatori_"+dati_tempo.id_sq1+"-"+dati_tempo.id_tempo;
             var id_sq2 = "punti_"+dati_tempo.id_sq2+"-"+dati_tempo.id_tempo;
             var id_gol_tempo2 = "giocatori_"+dati_tempo.id_sq2+"-"+dati_tempo.id_tempo;
             var id_area_punti1 = "G"+id_sq1;
             var id_area_punti2 = "G"+id_sq2;
             var id_area_cart1 = "cart_"+dati_tempo.id_sq1+"-"+dati_tempo.id_tempo;
             var id_area_cart2 = "cart_"+dati_tempo.id_sq2+"-"+dati_tempo.id_tempo;
             var id_area_conf1 = "conf_"+dati_tempo.id_sq1+"-"+dati_tempo.id_tempo;
             var id_area_conf2 = "conf_"+dati_tempo.id_sq2+"-"+dati_tempo.id_tempo;
             var name_option_sq1= "colore_"+dati_tempo.id_sq1+"-"+dati_tempo.id_tempo;
             var name_option_sq2= "colore_"+dati_tempo.id_sq2+"-"+dati_tempo.id_tempo;
             var id_option_sq1_G = "G"+dati_tempo.id_sq1+"-"+dati_tempo.id_tempo;
             var id_option_sq2_G = "G"+dati_tempo.id_sq2+"-"+dati_tempo.id_tempo;
             var id_option_sq1_R = "R"+dati_tempo.id_sq1+"-"+dati_tempo.id_tempo;
             var id_option_sq2_R = "R"+dati_tempo.id_sq2+"-"+dati_tempo.id_tempo;
             var id_tbody_sq1 = "Tb_"+dati_tempo.id_sq1+"-"+dati_tempo.id_tempo;
             var id_tbody_sq2 = "Tb_"+dati_tempo.id_sq2+"-"+dati_tempo.id_tempo;


            codice += "<div class='row'>" +
                "<div class=\"panel panel-primary\">" +
                "<div class=\"panel-heading\">" + dati_tempo.nome_tempo + "</div>" +
                "<div class=\"panel-body\">"
                /*Parte prima squadra*/
                +
                "<div class='col-lg-offset-2 col-md-offset-2 col-lg-3 col-md-3 col-sm-6 col-xs-6'>"
                //Nome Prima SQ
                +
                "<div class='row'>" +
                "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>" +
                "<ul class=\"list-group\">" +
                "<li class=\"list-group-item list-group-item-info text-center text-uppercase\">" + dati_tempo.nome_sq1 + "</li>" +
                "</ul>" +
                "</div>" +
                "</div>"
                //Fino Nome Prima SQ
                //Contatore Gol SQ1
                +
                "<div style='padding: 15px;' class=\"input-group number-spinner\">" +
                "<div class=\"btn-group-vertical\">" +
                "<button class=\"btn btn-primary\" data-dir=\"up\" id=\"" + dati_tempo.id_sq1 + "_" + dati_tempo.id_tempo + "\"><span class=\"glyphicon glyphicon-plus\"></span></button>" +
                "<input type=\"text\" id=\"" + id_sq1 + "\" style=\"font-size:40px; height:60px;\" class=\"form-control text-center\" value=\"0\">" +
                "<button class=\"btn btn-primary\" id=\"" + dati_tempo.id_sq1 + "_" + dati_tempo.id_tempo + "\" data-dir=\"dwn\"><span class=\"glyphicon glyphicon-minus\"></span></button>" +
                "</div>" +
                "</div>"
                //Fine Contatore Gol SQ1
                //Parte assegnazione Gol/cartellini SQ1
                +
                "<div class='row'>" +
                "<button type=\"button\" class=\"btn btn-info btn-block\" data-toggle=\"collapse\" data-target=\"#" + id_gol_tempo1 + "\">Info Tempo</button>" +
                "<div style='padding-top:10px;' id=\"" + id_gol_tempo1 + "\" class=\"collapse\">" +
                "<div class='row' id=\"" + id_area_punti1 + "\"></div>";
            codice += "<div class='row' id=\"" + id_area_cart1 + "\">" +
                "<div id=\"cartellino_" + dati_tempo.id_sq1 + "_" + dati_tempo.id_tempo + "\" >" +
                "<table class=\"table table-bordered table-hovered\">" +
                "<thead>" +
                "<tr>" +
                "<th>Giocatore</th>" +
                "<th>Cartellino</th>" +
                "<th></th>" +
                "</tr>" +
                "</thead>" +
                "<tbody id=\"" + id_tbody_sq1 + "\">";

            $.each(dati_tempo.cartellini_sq1, function(idx, obj) {
                //console.log(idx);
                //console.log(obj.id_tempo+"--"+dati_tempo.id_tempo);
                if (obj.id_tempo == dati_tempo.id_tempo) {
                    //console.log("ci sono");
                    for (var z = 1; z < obj.id_cartellini.length; z++) {
                        //console.log(z);
                        //console.log(obj.colore_cartellini[z].localeCompare("G"));
                        var id_tr = "TR_" + obj.id_cartellini[z];
                        if (obj.colore_cartellini[z].localeCompare("G") == 0) {
                            codice += "<tr id=\"" + id_tr + "\" class='warning'>";
                            codice += "<td>" + obj.nome_g_cartellini[z] + "</td>";
                            codice += "<td>Giallo</td>";
                            codice += "<td><button type='button' onclick='elimina_cartellino(\"" + obj.id_cartellini[z] + "\")' class='btn btn-danger'><i class='fa fa-times'></i> </button></td>"
                            codice += "</tr>";
                        } else {
                            codice += "<tr id=\"" + id_tr + "\" class='danger'>"
                            codice += "<td>" + obj.nome_g_cartellini[z] + "</td>";
                            codice += "<td>Rosso</td>";
                            codice += "<td><button type='button' onclick='elimina_cartellino(\"" + obj.id_cartellini[z] + "\")' class='btn btn-danger'><i class='fa fa-times'></i> </button></td>"
                            codice += "</tr>";
                        }

                    }
                }
            });


            codice += "</tbody>" +
                "</table>" +
                "</div>" +
                "<div id=\"new_cartellino_" + dati_tempo.id_sq1 + "_" + dati_tempo.id_tempo + "\" >" +
                "<div class='panel panel-primary'>" +
                "<div class='panel-heading'>Assegna Cartellini</div>" +
                "<div class='panel-body'>" +
                "<div class='form-group'>" +
                "<label for=\"SG" + dati_tempo.id_sq1 + "_" + dati_tempo.id_tempo + "\">Giocatore:</label>" +
                "<select class=\"form-control\" id=\"SG" + dati_tempo.id_sq1 + "_" + dati_tempo.id_tempo + "\">" +
                "<option value=\"nessuno\">Scegli Giocatore...</option>";
            for (var j = 1; j < dati_tempo.sq1.id_giocatori.length; j++) {
                codice += "<option value=\"" + dati_tempo.sq1.id_giocatori[j] + "\">" + dati_tempo.sq1.nomi_giocatori[j] + "</option>"
            }
            codice += "</select>" +
                "</div>" +
                "<div class='form-group text-center'>" +
                "<label class=\"radio-inline\"><input id=\"" + id_option_sq1_G + "\" checked type=\"radio\" value='G' name=\"" + name_option_sq1 + "\">Giallo</label>" +
                "<label class=\"radio-inline\"><input id=\"" + id_option_sq1_R + "\" type=\"radio\" value='R' name=\"" + name_option_sq1 + "\">Rosso</label>" +
                "</div>" +
                "<div class='form-group'>" +
                "<button type='button' onclick='aggiungi_cartellino(" + dati_tempo.id_sq1 + "," + dati_tempo.id_tempo + "," + id_partita + ")' class='btn btn-primary btn-block'>Aggiungi Cartellino</button>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>";
            codice += "<div class='row' id=\"" + id_area_conf1 + "\">" +
                "<button type='button' class='btn btn-success btn-block' onclick='conferma_tempo(\"" + dati_tempo.id_sq1 + "\",\"" + dati_tempo.id_tempo + "\",\"" + id_partita + "\",\"" + id_torneo + "\")'>Conferma dati Tempo</button>"

                +
                "</div>" +
                "</div>" +
                "</div>"
                //Fine Parte assegnazione Gol/Cartellini SQ1
                +
                "</div>"
//Fine Prima Squadra



            //Parte Seconda squadra
            codice += "<div class='col-lg-offset-2 col-md-offset-2 col-lg-3 col-md-3 col-sm-6 col-xs-6'>"
                //Nome Sqconda SQ
                +
                "<div class='row'>" +
                "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>" +
                "<ul class=\"list-group\">" +
                "<li class=\"list-group-item list-group-item-info text-center text-uppercase\">" + dati_tempo.nome_sq2 + "</li>" +
                "</ul>" +
                "</div>" +
                "</div>"
                //Fino Nome Seconda SQ
                //Contatore Gol SQ2
                +
                "<div style='padding: 15px;' class=\"input-group number-spinner\">" +
                "<div class=\"btn-group-vertical\">" +
                "<button class=\"btn btn-primary\" data-dir=\"up\" id=\"" + dati_tempo.id_sq2 + "_" + dati_tempo.id_tempo + "\"><span class=\"glyphicon glyphicon-plus\"></span></button>" +
                "<input type=\"text\" id=\"" + id_sq2 + "\" style=\"font-size:40px; height:60px;\" class=\"form-control text-center\" value=\"0\">" +
                "<button class=\"btn btn-primary\" id=\"" + dati_tempo.id_sq2 + "_" + dati_tempo.id_tempo + "\" data-dir=\"dwn\"><span class=\"glyphicon glyphicon-minus\"></span></button>" +
                "</div>" +
                "</div>"
                //Fine Contatore Gol SQ2
                //Parte assegnazione Gol/cartellini SQ2
                +
                "<div class='row'>" +
                "<button type=\"button\" class=\"btn btn-info btn-block\" data-toggle=\"collapse\" data-target=\"#" + id_gol_tempo2 + "\">Info Tempo</button>" +
                "<div style='padding-top:10px;' id=\"" + id_gol_tempo2 + "\" class=\"collapse\">" +
                "<div class='row' id=\"" + id_area_punti2 + "\"></div>";
            codice += "<div class='row' id=\"" + id_area_cart2 + "\">" +
                "<div id=\"cartellino_" + dati_tempo.id_sq2 + "_" + dati_tempo.id_tempo + "\" >" +
                "<table class=\"table table-bordered table-hovered\">" +
                "<thead>" +
                "<tr>" +
                "<th>Giocatore</th>" +
                "<th>Cartellino</th>" +
                "<th></th>" +
                "</tr>" +
                "</thead>" +
                "<tbody id=\"" + id_tbody_sq2 + "\">";

            $.each(dati_tempo.cartellini_sq2, function(idx, obj) {
                //console.log(idx);
                //console.log(obj.id_tempo+"--"+dati_tempo.id_tempo);
                if (obj.id_tempo == dati_tempo.id_tempo) {
                    //console.log("ci sono");
                    for (var z = 1; z < obj.id_cartellini.length; z++) {
                        var id_tr = "TR_" + obj.id_cartellini[z];
                        //console.log(z);
                        //console.log(obj.colore_cartellini[z].localeCompare("G"));
                        if (obj.colore_cartellini[z].localeCompare("G") == 0) {
                            codice += "<tr id=\"" + id_tr + "\" class='warning'>";
                            codice += "<td>" + obj.nome_g_cartellini[z] + "</td>";
                            codice += "<td>Giallo</td>";
                            codice += "<td><button type='button' onclick='elimina_cartellino(\"" + obj.id_cartellini[z] + "\")' class='btn btn-danger'><i class='fa fa-times'></i> </button></td>"
                            codice += "</tr>";
                        } else {
                            codice += "<tr id=\"" + id_tr + "\" class='danger'>"
                            codice += "<td>" + obj.nome_g_cartellini[z] + "</td>";
                            codice += "<td>Rosso</td>";
                            codice += "<td><button type='button' onclick='elimina_cartellino(\"" + obj.id_cartellini[z] + "\")' class='btn btn-danger'><i class='fa fa-times'></i> </button></td>"
                            codice += "</tr>";
                        }

                    }
                }
            });


            codice += "</tbody>" +
                "</table>" +
                "</div>" +
                "<div id=\"new_cartellino_" + dati_tempo.id_sq2 + "_" + dati_tempo.id_tempo + "\" >" +
                "<div class='panel panel-primary'>" +
                "<div class='panel-heading'>Assegna Cartellini</div>" +
                "<div class='panel-body'>" +
                "<div class='form-group'>" +
                "<label for=\"SG" + dati_tempo.id_sq2 + "_" + dati_tempo.id_tempo + "\">Giocatore:</label>" +
                "<select class=\"form-control\" id=\"SG" + dati_tempo.id_sq2 + "_" + dati_tempo.id_tempo + "\">" +
                "<option value=\"nessuno\">Scegli Giocatore...</option>";
            for (var j = 1; j < dati_tempo.sq2.id_giocatori.length; j++) {
                codice += "<option value=\"" + dati_tempo.sq2.id_giocatori[j] + "\">" + dati_tempo.sq2.nomi_giocatori[j] + "</option>"
            }
            codice += "</select>" +
                "</div>" +
                "<div class='form-group text-center'>" +
                "<label class=\"radio-inline\"><input id=\"" + id_option_sq2_G + "\" type=\"radio\" checked value='G' name=\"" + name_option_sq2 + "\">Giallo</label>" +
                "<label class=\"radio-inline\"><input id=\"" + id_option_sq2_R + "\" type=\"radio\" value='R' name=\"" + name_option_sq2 + "\">Rosso</label>" +
                "</div>" +
                "<div class='form-group'>" +
                "<button type='button' onclick='aggiungi_cartellino(" + dati_tempo.id_sq2 + "," + dati_tempo.id_tempo + "," + id_partita + ")' class='btn btn-primary btn-block'>Aggiungi Cartellino</button>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>";
            codice += "<div class='row' id=\"" + id_area_conf2 + "\">" +
                "<button type='button' class='btn btn-success btn-block' onclick='conferma_tempo(\"" + dati_tempo.id_sq2 + "\",\"" + dati_tempo.id_tempo + "\",\"" + id_partita + "\",\"" + id_torneo + "\")'>Conferma dati Tempo</button>"

                +
                "</div>" +
                "</div>" +
                "</div>"
                //Fine Parte assegnazione Gol/Cartellini SQ2
                +
                "</div>"
                //Fine Seconda Squadra

                +"</div>" +
                "</div>" +
                "</div>" +
                "</div>";


             
            $('#dati_partita').append(codice);
            var indice = document.getElementById(key).selectedIndex;
            if(indice>=0) {
                document.getElementById(key).options[indice] = null;
            }
        },
        // ed una per il caso di fallimento
        error: function(){
            alert("Chiamata fallita!!!");
        }
    });
}
function assegna_punti(id_sq,id_tempo) {
    //console.log("funziono!!!!"+id_sq+"__"+id_tempo);
    //sleep(1000);
    var key =  "#punti_"+id_sq+"-"+id_tempo;
    var valore =0;
    valore = $(key).val();
    valore = parseInt(valore);
    
    var key_a_giocatori = "#Gpunti_"+id_sq+"-"+id_tempo;
    $(key_a_giocatori).empty();
    $.ajax({
        type: "GET",
        url: "metodi/dati_squadra.php",
        data: "id_sq="+id_sq,
        success: function(risposta){
        var codice = "<div class='panel panel-primary'><div class='panel-body'>";
        for(var i = 0; i<valore;i++){
            codice += "<div class=\"form-group\">"
                +"<label for=\"gol_"+i+"_sq"+id_sq+"_"+id_tempo+"\">Gol "+(parseInt(i)+1)+":</label>"
                +"<select class=\"form-control\" id=\"gol_"+i+"_sq"+id_sq+"_"+id_tempo+"\">"
                    +"<option value='nessuno'>Nessuno</option>";
                            var ogg_sq = $.parseJSON(risposta);
                            //console.log(ogg_sq);
                            for(var j = 1; j<ogg_sq.id_giocatori.length;j++){
                                codice += "<option value=\""+ogg_sq.id_giocatori[j]+"\">"+ogg_sq.nomi_giocatori[j]+"</option>"
                            }
                codice +="</select>";
        }
        codice+="</div></div>";
        $(key_a_giocatori).append(codice);
        //console.log(codice);
        },
        error: function(){
            alert("Chiamata fallita!!!");
        }
    });

}
function elimina_cartellino(id_cartellino){
    $.ajax({
        type: "GET",
        url: "metodi/elimina_cartellino.php",
        data: "id_cartellino="+id_cartellino,
        //dataType: "json",
        success: function(risposta){
            if(risposta.localeCompare('1')==0){
                var key = "#TR_"+id_cartellino;
                $(key).hide();
            }
        },
        // ed una per il caso di fallimento
        error: function(){
            //alert("Chiamata fallita!!!");
        }
    });
}
function aggiungi_cartellino(id_sq,id_tempo,id_p) {
    var key_colore = "input[name=\"colore_"+id_sq+"-"+id_tempo+"\"]:checked";
    var key_g = "SG"+id_sq+"_"+id_tempo;
    var giocatore = document.getElementById(key_g).value;
    var colore = $(key_colore).val();
    //console.log(giocatore+"_"+colore);
    $.ajax({
        type: "GET",
        url: "metodi/aggiungi_cartellino.php",
        data: "id_p="+id_p+"&id_tempo="+id_tempo+"&id_sq="+id_sq+"&giocatore="+giocatore+"&colore="+colore,
        //dataType: "json",
        success: function(risposta){
            //$("div#risposta").html(risposta);
            var ogg = $.parseJSON(risposta);
            var key = "#Tb_"+id_sq+"-"+id_tempo;
            //console.log(key);
            var codice = "";
            if(ogg.esito == 1){
                var id_tr = "TR_"+ogg.id_cartellino;
                if(ogg.colore.localeCompare("G")==0){
                    codice+= "<tr id=\""+id_tr+"\" class='warning'>";
                    codice+="<td>"+ogg.nome_giocatore+"</td>";
                    codice+="<td>Giallo</td>";
                    codice+="<td><button type='button' onclick='elimina_cartellino(\""+ogg.id_cartellino+"\")' class='btn btn-danger'><i class='fa fa-times'></i> </button></td>"
                    codice+="</tr>";
                } else {
                    codice+= "<tr id=\""+id_tr+"\" class='danger'>"
                    codice+="<td>"+ogg.nome_giocatore+"</td>";
                    codice+="<td>Rosso</td>";
                    codice+="<td><button type='button' onclick='elimina_cartellino(\""+ogg.id_cartellino+"\")' class='btn btn-danger'><i class='fa fa-times'></i> </button></td>"
                    codice+="</tr>";
                }
                $(key).append(codice);
            }
        },
        // ed una per il caso di fallimento
        error: function(){
            //alert("Chiamata fallita!!!");
        }
    });
}
function conferma_tempo(id_sq,id_tempo,id_partita,id_torneo){

    var key =  "#punti_"+id_sq+"-"+id_tempo;
    var valore =0;
    valore = $(key).val();
    valore = parseInt(valore);
    //console.log(valore);
    var parametri ="id_sq="+id_sq+"&id_tempo="+id_tempo+"&id_p="+id_partita+"&gol="+valore+"&id_torneo="+id_torneo;
    for(var i = 0; i<valore;i++){
        var id_s_g="#gol_"+i+"_sq"+id_sq+"_"+id_tempo;
        parametri += "&g"+i+"="+$(id_s_g).val();
    }

    $.ajax({
        type: "GET",
        url: "metodi/conferma_tempo.php",
        data: parametri,
        dataType: "html",
        success: function(risposta){
            if(risposta==1) {
                creaPopup(id_partita, id_torneo);
            }
        },
        error: function(){
            alert("Chiamata fallita!!!");
        }
    });
}
function elimina_partita(id_p, id_torneo) {
    $.ajax({
        type: "GET",
        url: "metodi/cancella_partita.php",
        data: "id_partita="+id_p,
        dataType: "html",
        success: function(risposta){
            if(risposta==1) {
                window.location.href="Admin_torneo.php?id="+id_torneo;
            }
        },
        error: function(){
            alert("Chiamata fallita!!!");
        }
    });   
}
function conferma_partita(id_p, id_sq1, id_sq2,id_torneo){
    $.ajax({
        type: "GET",
        url: "metodi/conferma_partita.php",
        data: "id_p="+id_p+"&id_sq1="+id_sq1+"&id_sq2="+id_sq2+"&torneo="+id_torneo,
        dataType: "html",
        success: function(risposta){
            if(risposta==1)
                creaPopup(id_p,id_torneo);
        },
        error: function(){
            alert("Chiamata fallita!!!");
        }
    });
}
function creaClassifica(id_torneo){
    $('#bodyClassifica').empty();
    $.ajax({
        type: "GET",
        url: "metodi/classifica.php",
        data: "id_t="+id_torneo,
        dataType: "html",
        success: function(risposta){
            var ogg = $.parseJSON(risposta);
            var codice = "<div class='container-fluid'>" +
                "<div class='row'>";
            if(ogg.fase_finale == 0) {
                $.each(ogg.classifica, function (idx, obj) {
                    if (idx != 0) {
                        codice += "<table class=\"table table-bordered\">"
                            + "<thead>"
                            + "<tr>"
                            + "<th colspan='5'><h4 class='text-center'>Girone " + obj.nome_girone + "</h4></th>"
                            + "</tr>"
                            + "<tr>"
                            + "<th>Nome Squadra</th>"
                            + "<th>Punti</th>"
                            + "<th>Gol Fatti</th>"
                            + "<th>Gol Subiti</th>"
                            + "<th>Differenza Reti</th>"
                            + "</tr>"
                            + "</thead>"
                            + "<tbody>";
                        for (var i = 0; i < obj.nome_sq.length; i++) {
                            codice += "<tr>"
                                + "<td>" + obj.nome_sq[i] + "</td>"
                                + "<td>" + obj.punti[i] + "</td>"
                                + "<td>" + obj.gol_fatti[i] + "</td>"
                                + "<td>" + obj.gol_subiti[i] + "</td>"
                                + "<td>" + obj.dif_reti[i] + "</td>"
                                + "</tr>";
                        }
                        codice += "</tbody>"
                            + "</table>";
                    }
                });
            }
            else {
                $.each(ogg.classifica, function (idx, obj) {
                    if (idx != 0) {
                        codice += "<table class=\"table table-bordered\">"
                            + "<thead>"
                            + "<tr>"
                            + "<th colspan='5'><h4 class='text-center'>Girone " + obj.nome_girone + "</h4></th>"
                            + "</tr>"
                            + "<tr>"
                            + "<th>Nome Squadra</th>"
                            + "</tr>"
                            + "</thead>"
                            + "<tbody>";
                        for (var i = 0; i < obj.nome_sq.length; i++) {
                            codice += "<tr>"
                                + "<td>" + obj.nome_sq[i] + "</td>"
                                + "</tr>";
                        }
                        codice += "</tbody>"
                            + "</table>";
                    }
                });
            }
            codice += "</div>";

            codice += "<div class='row'>";
            if(ogg.fase_finale == 0) {
                if (ogg.tipo_sport != 4 && ogg.tipo_sport != 5) {
                    $.each(ogg.classifica, function (idx, obj) {
                        if (idx != 0) {
                            codice += "<div class=\"col-lg-6 col-md-6 col-sm-6 col-xs-6\">";
                            codice += "<table class=\"table table-bordered\">"
                                + "<thead>"
                                + "<tr>"
                                + "<th colspan='5'><h4 class='text-center'>Marcatori Girone " + obj.nome_girone + "</h4></th>"
                                + "</tr>"
                                + "<tr>"
                                + "<th>Nome Giocatore</th>"
                                + "<th>Num Gol</th>"
                                + "</tr>"
                                + "</thead>"
                                + "<tbody>";
                            for (var i = 1; i < obj.marcatori_num_gol.length; i++) {
                                var name = obj.marcatori_nome[i] + " " + obj.marcatori_cognome[i];
                                codice += "<tr>"
                                    + "<td>" + name + "</td>"
                                    + "<td>" + obj.marcatori_num_gol[i] + "</td>"
                                    + "</tr>";
                            }
                            codice += "</tbody>"
                                + "</table>" +
                                "</div>";
                        }
                    });

                }

                if (ogg.tipo_sport != 5) {
                    $.each(ogg.classifica, function (idx, obj) {
                        if (idx != 0) {
                            codice += "<div class=\"col-lg-6 col-md-6 col-sm-6 col-xs-6\">";
                            codice += "<table class=\"table table-bordered\">"
                                + "<thead>"
                                + "<tr class='warning'>"
                                + "<th colspan='5'><h4 class='text-center'>Cartellini Gialli Girone " + obj.nome_girone + "</h4></th>"
                                + "</tr>"
                                + "<tr>"
                                + "<th>Nome Giocatore</th>"
                                + "<th>Num Gol</th>"
                                + "</tr>"
                                + "</thead>"
                                + "<tbody>";
                            for (var i = 1; i < obj.cartellino_G_nome.length; i++) {
                                var name = obj.cartellino_G_nome[i] + " " + obj.cartellino_G_cognome[i];
                                codice += "<tr>"
                                    + "<td>" + name + "</td>"
                                    + "<td>" + obj.cartellino_G_num[i] + "</td>"
                                    + "</tr>";
                            }
                            codice += "</tbody>"
                                + "</table>" +
                                "</div>";
                        }
                    });
                }

                if (ogg.tipo_sport != 5) {
                    $.each(ogg.classifica, function (idx, obj) {
                        if (idx != 0) {
                            codice += "<div class=\"col-lg-6 col-md-6 col-sm-6 col-xs-6\">";
                            codice += "<table class=\"table table-bordered\">"
                                + "<thead>"
                                + "<tr class='danger'>"
                                + "<th colspan='5'><h4 class='text-center'>Cartellini Gialli Girone " + obj.nome_girone + "</h4></th>"
                                + "</tr>"
                                + "<tr>"
                                + "<th>Nome Giocatore</th>"
                                + "<th>Num Gol</th>"
                                + "</tr>"
                                + "</thead>"
                                + "<tbody>";
                            for (var i = 1; i < obj.cartellino_R_nome.length; i++) {
                                var name = obj.cartellino_R_nome[i] + " " + obj.cartellino_R_cognome[i];
                                codice += "<tr>"
                                    + "<td>" + name + "</td>"
                                    + "<td>" + obj.cartellino_R_num[i] + "</td>"
                                    + "</tr>";
                            }
                            codice += "</tbody>"
                                + "</table>" +
                                "</div>";
                        }
                    });

                }
            }
            else{
                if (ogg.tipo_sport != 4 && ogg.tipo_sport != 5) {
                    codice += "<div class=\"col-lg-6 col-md-6 col-sm-6 col-xs-6\">";
                    codice += "<table class=\"table table-bordered\">"
                        + "<thead>"
                        + "<tr>"
                        + "<th colspan='5'><h4 class='text-center'>Classifica Marcatori</h4></th>"
                        + "</tr>"
                        + "<tr>"
                        + "<th>Nome Giocatore</th>"
                        + "<th>Num Gol</th>"
                        + "</tr>"
                        + "</thead>"
                        + "<tbody>";
                    for (var i = 1; i < ogg.marcatori_num_gol.length; i++) {
                        var name = ogg.marcatori_nome[i] + " " + ogg.marcatori_cognome[i];
                        codice += "<tr>"
                            + "<td>" + name + "</td>"
                            + "<td>" + ogg.marcatori_num_gol[i] + "</td>"
                            + "</tr>";
                    }
                    codice += "</tbody>"
                        + "</table>" +
                        "</div>";
                }

                if (ogg.tipo_sport != 5) {
                    codice += "<div class=\"col-lg-6 col-md-6 col-sm-6 col-xs-6\">";
                    codice += "<table class=\"table table-bordered\">"
                        + "<thead>"
                        + "<tr class='warning'>"
                        + "<th colspan='5'><h4 class='text-center'>Cartellini Gialli</h4></th>"
                        + "</tr>"
                        + "<tr>"
                        + "<th>Nome Giocatore</th>"
                        + "<th>Num Gol</th>"
                        + "</tr>"
                        + "</thead>"
                        + "<tbody>";
                    for (var i = 1; i < ogg.cartellino_G_nome.length; i++) {
                        var name = ogg.cartellino_G_nome[i] + " " + ogg.cartellino_G_cognome[i];
                        codice += "<tr>"
                            + "<td>" + name + "</td>"
                            + "<td>" + ogg.cartellino_G_num[i] + "</td>"
                            + "</tr>";
                    }
                    codice += "</tbody>"
                        + "</table>" +
                        "</div>";
                }

                if (ogg.tipo_sport != 5) {
                    codice += "<div class=\"col-lg-6 col-md-6 col-sm-6 col-xs-6\">";
                    codice += "<table class=\"table table-bordered\">"
                        + "<thead>"
                        + "<tr class='danger'>"
                        + "<th colspan='5'><h4 class='text-center'>Cartellini Gialli</h4></th>"
                        + "</tr>"
                        + "<tr>"
                        + "<th>Nome Giocatore</th>"
                        + "<th>Num Gol</th>"
                        + "</tr>"
                        + "</thead>"
                        + "<tbody>";
                    for (var i = 1; i < ogg.cartellino_R_nome.length; i++) {
                        var name = ogg.cartellino_R_nome[i] + " " + ogg.cartellino_R_cognome[i];
                        codice += "<tr>"
                            + "<td>" + name + "</td>"
                            + "<td>" + ogg.cartellino_R_num[i] + "</td>"
                            + "</tr>";
                    }
                    codice += "</tbody>"
                        + "</table>" +
                        "</div>";

                }
            }
            codice += "</div>";

            codice += "</div>";
            $('#bodyClassifica').append(codice);
        },
        error: function(){
            alert("Chiamata fallita!!!");
        }
    });    
}
function creaFormFineGironi(torneo){
    $('#bodyChiudi').empty();
    var codice = "";
    $.ajax({
        type: "GET",
        url: "metodi/gironi_faseF.php",
        success: function(gironi){
            var ogg_g = $.parseJSON(gironi);
            $.ajax({
                type: "GET",
                url: "metodi/classifica.php",
                data: "id_t="+torneo,
                dataType: "html",
                success: function(risposta){
                    var ogg = $.parseJSON(risposta);
                    var codice = "<div class='container-fluid'>" +
                    "<form method='post' action=\"metodi/chiudiG.php?id="+torneo+"\"><div class='row'>";
                        $.each(ogg.classifica, function(idx, obj){
                            if(idx !=0){
                                codice+="<table class=\"table table-bordered\">"
                                    +"<thead>"
                                    +"<tr>"
                                    +"<th colspan='6'><h4 class='text-center'>Girone "+obj.nome_girone+"</h4></th>"
                                    +"</tr>"
                                    +"<tr>"
                                    +"<th>Nome Squadra</th>"
                                    +"<th>Punti</th>"
                                    +"<th>Gol Fatti</th>"
                                    +"<th>Gol Subiti</th>"
                                    +"<th>Differenza Reti</th>"
                                    +"<th>Esito</th>"
                                    +"</tr>"
                                    +"</thead>"
                                    +"<tbody>";
                                for(var i =0;i<obj.nome_sq.length;i++){
                                    codice+="<tr>"
                                        +"<td>"+obj.nome_sq[i]+"</td>"
                                        +"<td>"+obj.punti[i]+"</td>"
                                        +"<td>"+obj.gol_fatti[i]+"</td>"
                                        +"<td>"+obj.gol_subiti[i]+"</td>"
                                        +"<td>"+obj.dif_reti[i]+"</td>"
                                        +"<td>";
                                            codice+="<div class=\"form-group\">"
                                            +"<select name=\"sel"+obj.id_sq[i]+"\" class=\"form-control\" id=\"select"+obj.id_sq[i]+"\">";
                                                for(var j =0;j<ogg_g.id_g.length;j++){
                                                    codice+="<option value=\""+ogg_g.id_g[j]+"\">"+ogg_g.desc_g[j]+"</option>";
                                                }
                                                codice+="</select>";
                                        codice+="</td>"
                                        +"</tr>";
                                }
                                codice+="</tbody>"
                                    +"</table>";
                            }
                        });
                    codice += "</div>";
                    codice+="<div class='row'><button type='submit' class='btn btn-primary btn-block'>Concludi Gironi</button></div></form>";
                    codice += "</div>";
                    $('#bodyChiudi').append(codice);


                },
                error: function(){
                    alert("Chiamata fallita!!!");
                }
            });
        },
        error: function(){
            alert("Chiamata fallita!!!");
        }
    });
}
function classificaFinale(id_torneo) {
    $('#fine').empty();
    $.ajax({
        type: "GET",
        url: "metodi/classifica.php",
        data: "id_t="+id_torneo,
        dataType: "html",
        success: function(risposta){
            var ogg = $.parseJSON(risposta);
            var codice = "<div class=\"row container-fluid\" style='padding-top: 20px;'>" +
                "<div class=\"panel panel-primary\">"
                    +"<div class=\"panel-body\"><div class='container-fluid'>" +
                        "<div class='row'>";
            
                $.each(ogg.classifica, function (idx, obj) {
                    if (idx != 0) {
                        codice += "<table class=\"table table-bordered\">"
                            + "<thead>"
                            + "<tr>"
                            + "<th colspan='5'><h4 class='text-center'>Girone " + obj.nome_girone + "</h4></th>"
                            + "</tr>"
                            + "<tr>"
                            + "<th>Nome Squadra</th>"
                            + "</tr>"
                            + "</thead>"
                            + "<tbody>";
                        for (var i = 0; i < obj.nome_sq.length; i++) {
                            codice += "<tr>"
                                + "<td>" + obj.nome_sq[i] + "</td>"
                                + "</tr>";
                        }
                        codice += "</tbody>"
                            + "</table>";
                    }
                });
            codice += "</div>";

            codice += "<div class='row'>";
                if (ogg.tipo_sport != 4 && ogg.tipo_sport != 5) {
                    codice += "<div class=\"col-lg-6 col-md-6 col-sm-6 col-xs-6\">";
                    codice += "<table class=\"table table-bordered\">"
                        + "<thead>"
                        + "<tr>"
                        + "<th colspan='5'><h4 class='text-center'>Classifica Marcatori</h4></th>"
                        + "</tr>"
                        + "<tr>"
                        + "<th>Nome Giocatore</th>"
                        + "<th>Num Gol</th>"
                        + "</tr>"
                        + "</thead>"
                        + "<tbody>";
                    for (var i = 1; i < ogg.marcatori_num_gol.length; i++) {
                        var name = ogg.marcatori_nome[i] + " " + ogg.marcatori_cognome[i];
                        codice += "<tr>"
                            + "<td>" + name + "</td>"
                            + "<td>" + ogg.marcatori_num_gol[i] + "</td>"
                            + "</tr>";
                    }
                    codice += "</tbody>"
                        + "</table>" +
                        "</div>";
                }

                if (ogg.tipo_sport != 5) {
                    codice += "<div class=\"col-lg-6 col-md-6 col-sm-6 col-xs-6\">";
                    codice += "<table class=\"table table-bordered\">"
                        + "<thead>"
                        + "<tr class='warning'>"
                        + "<th colspan='5'><h4 class='text-center'>Cartellini Gialli</h4></th>"
                        + "</tr>"
                        + "<tr>"
                        + "<th>Nome Giocatore</th>"
                        + "<th>Num Gol</th>"
                        + "</tr>"
                        + "</thead>"
                        + "<tbody>";
                    for (var i = 1; i < ogg.cartellino_G_nome.length; i++) {
                        var name = ogg.cartellino_G_nome[i] + " " + ogg.cartellino_G_cognome[i];
                        codice += "<tr>"
                            + "<td>" + name + "</td>"
                            + "<td>" + ogg.cartellino_G_num[i] + "</td>"
                            + "</tr>";
                    }
                    codice += "</tbody>"
                        + "</table>" +
                        "</div>";
                }

                if (ogg.tipo_sport != 5) {
                    codice += "<div class=\"col-lg-6 col-md-6 col-sm-6 col-xs-6\">";
                    codice += "<table class=\"table table-bordered\">"
                        + "<thead>"
                        + "<tr class='danger'>"
                        + "<th colspan='5'><h4 class='text-center'>Cartellini Gialli</h4></th>"
                        + "</tr>"
                        + "<tr>"
                        + "<th>Nome Giocatore</th>"
                        + "<th>Num Gol</th>"
                        + "</tr>"
                        + "</thead>"
                        + "<tbody>";
                    for (var i = 1; i < ogg.cartellino_R_nome.length; i++) {
                        var name = ogg.cartellino_R_nome[i] + " " + ogg.cartellino_R_cognome[i];
                        codice += "<tr>"
                            + "<td>" + name + "</td>"
                            + "<td>" + ogg.cartellino_R_num[i] + "</td>"
                            + "</tr>";
                    }
                    codice += "</tbody>"
                        + "</table>" +
                        "</div>";

                }
            
            codice += "</div>";

            codice += "<div class='row'>";
            codice += "<button class='btn btn-primary btn-block' onclick=\"fineTorneo("+id_torneo+")\">Concludi Torneo</button>"
            codice += "</div>";

            codice += "</div>" +
                "</div>" +
                "</div>" +
                "</div>";
            $('#fine').append(codice);
        },
        error: function(){
            alert("Chiamata fallita!!!");
        }
    });
}
function fineTorneo(id_torneo) {
    $('#fine').empty();
    $.ajax({
        type: "GET",
        url: "metodi/fine_torneo.php",
        data: "id_t=" + id_torneo,
        dataType: "html",
        success: function () {
            window.location.href="Admin_Torneo.php?id="+id_torneo;
        },
        error: function () {
            alert("qualcosa non va!!");
        }
    });
}