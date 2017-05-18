/**
 * Created by gobbi on 18/05/2017.
 */
function creaClassifica(id_torneo){
    $('#area_classifica').empty();
    $.ajax({
        type: "GET",
        url: "../Staff/metodi/classifica.php",
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
            $('#area_classifica').append(codice);
        },
        error: function(){
            alert("Chiamata fallita!!!");
        }
    });
}