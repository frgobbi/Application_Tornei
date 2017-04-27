/**
 * Created by gobbi on 12/04/2017.
 */
function torneo(id){
    var codice = "";
    $('#body_t').empty();
    $.ajax({
        type: "GET",
        url: "metodi/dati_torneo.php",
        data: "id_torneo="+id,
        success: function(risposta){
            var ogg = $.parseJSON(risposta);
            codice += "<div class='container-fluid'>";
                codice += "<div class='row'>";
                    codice += "<div class='col-lg-9 col-md-9 col-sm-12 col-xs-12'>";
                        codice += "<ul class=\"list-group\">"
                            +"<li class=\"list-group-item\"><label>Data Inizio:</label> "+ogg.data_inizio+"</li>"
                            +"<li class=\"list-group-item\"><label>Data Fine Iscrizioni:</label> "+ogg.data_f_iscrizioni+"</li>"
                            +"<li class=\"list-group-item\"><label>Data Fine:</label> "+ogg.data_fine+"</li>"
                            +"<li class=\"list-group-item\"><label>Numero minimo giocatori:</label> "+ogg.num_g_min+"</li>"
                            +"<li class=\"list-group-item\"><label>Numero massimo giocatori:</label> "+ogg.num_g_max+"</li>";
                            if(ogg.min_anno == 0){
                                codice +="<li class=\"list-group-item\"><label>Anno minimo giocatori:</label> Nessuna limitazione</li>";
                            } else {
                                codice +="<li class=\"list-group-item\"><label>Anno minimo giocatori:</label> "+ogg.min_anno+"</li>";
                            }

                            if(ogg.max_anno == 0){
                                codice +="<li class=\"list-group-item\"><label>Anno massimo giocatori:</label> Nessuna limitazione</li>";
                            } else {
                                codice +="<li class=\"list-group-item\"><label>Anno massimo giocatori:</label> "+ogg.max_anno+"</li>";
                            }
                            codice +="<li class=\"list-group-item\"><label>Squadre gi&agrave iscritte: </label> "+ogg.sq_iscritte+"</li>"
                            +"<li class=\"list-group-item\"><label>Squadre con iscrizione non confermata: </label> "+ogg.sq_n_confermate+"</li>"
                            +"<li class=\"list-group-item\"><label>Informazioni: </label> "+ogg.info_t+"</li>"
                            +"</ul>";
                    codice += "</div>";
                    codice += "<div class='col-lg-3 col-md-3 col-sm-12 col-xs-12'>";
                        codice += "<div class=\"well text-center\"><i class=\"fa "+ogg.logo+" fa-5x\"></i></div>";
                    codice += "</div>";
                codice += "</div>";
                codice += "<div class='row'>" +
                    "<div class='col-lg-12'><button onclick='window.location.href=\"iscrizioneTorneo.php?id_t="+id+"\"' class='btn btn-primary btn-lg btn-block'>Iscriviti al torneo</button></div>" +
                    "</div>";
            codice += "</div>";
            $('#body_t').append(codice);
        },
        error: function(){
            alert("Chiamata fallita!!!");
        }
    });
}