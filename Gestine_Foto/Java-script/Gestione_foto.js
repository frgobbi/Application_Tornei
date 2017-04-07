/**
 * Created by gobbi on 03/04/2017.
 */

function visualizza_foto(cartella) {
    $('#body_foto').empty();
    var codice = "";
    $.ajax({
        type: "GET",
        url: "metodi/visualizza_foto.php",
        data: "cartella=" + cartella,
        success: function (risposta) {
            var ogg = $.parseJSON(risposta);

            codice += "<div class='row'>";
                codice += "<div class=\"col-lg-4 col-md-4 col-sm-12 col-xs-12\">";
                codice += "<a href='#' onclick='aggFoto()'>";
                codice += "<div class=\"panel panel-primary\">"
                    + "<div class=\"panel-heading text-center\"><h3>Aggiungi Foto</h3></div>"
                    //+"<div class=\"panel-footer\"></div>"
                    + "</div>";
                codice += "</a>";
                codice += "</div>";

                codice += "<div class=\"col-lg-4 col-md-4 col-sm-12 col-xs-12\">";
                codice += "<a href='#' onclick='gestFoto()'>";
                codice += "<div class=\"panel panel-yellow\">"
                    + "<div class=\"panel-heading text-center\"><h3>Gestisci Foto</h3></div>"
                    //+"<div class=\"panel-footer\"></div>"
                    + "</div>";
                codice += "</a>";
                codice += "</div>";

                if(cartella !=1) {
                    codice += "<div class=\"col-lg-4 col-md-4 col-sm-12 col-xs-12\">";
                    codice += "<div class=\"panel panel-red\">"
                        + "<div class=\"panel-heading text-center\"><h3>Elimina Album</h3></div>"
                        //+"<div class=\"panel-footer\"></div>"
                        + "</div>";
                    codice += "</div>";
                } else {
                    codice += "<div class=\"col-lg-4 col-md-4 col-sm-12 col-xs-12\">";
                    codice += "<div class=\"panel panel-red\">"
                        + "<div class=\"panel-heading text-center\"><h3>Elimina Foto</h3></div>"
                        //+"<div class=\"panel-footer\"></div>"
                        + "</div>";
                    codice += "</div>";
                }
            codice += "</div>";

            codice += "<div id='agg_foto' class='row' style='height: 600px; overflow-y: auto'>";
            codice += "<div class='container-fluid'>";
            codice += "<label class=\"control-label\">Select File</label>"
                + "<input id=\"input-ke-2\" name=\"foto[]\" type=\"file\" multiple class=\"file-loading\">";
            codice += "</div>";
            codice += "<div style='padding-top: 30px;' class='container-fluid'>";
            codice += "<button id='btnupload' class='btn btn-primary btn-lg btn-block' onclick='caricaF(" + ogg.id_c + ")'>Carica Foto</button>";
            codice += "</div>";
            codice += "<div style='padding-top: 30px;' class='container-fluid'>";
            codice += "<div id='alertC' class='alert alert-info text-center'><i class=\"fa fa-spinner fa-pulse fa-3x fa-fw\"></i>" +
                "<span class=\"sr-only\"></span></div>";
            codice += "</div>";
            codice += "</div>";

            codice += "<div id='ges_foto' class='row container-fluid'>";
            codice += "<div class='panel panel-default'>" +
                "<div class='panel-heading c-list'>" +
                "<span class='title'>Gestione Foto</span>" +
                "<ul class=\"pull-right c-controls\">"+
                "<li id='deSel'><a href=\"#\"><i class=\"fa fa-square-o\" aria-hidden=\"true\"></i></a></li>"+
                "<li id='Sel'><a href=\"#\"><i class=\"fa fa-check-square-o\" aria-hidden=\"true\"></i></a></li>"+
                "<li id='cSel'><a href=\"#\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></a></li>"+
                "</ul>"+
                "</div>" +
                "<div style='height: 600px; overflow-y: auto' class='panel-body'>";
                codice+="<div class='list-group gallery'>";
                        for(var i=1;i<ogg.id_f.length;i++){
                            var percorso = "../Immagini/"+ogg.nome_c+"/"+ogg.nome_f[i];
                            codice+= "<div id=\"foto"+ogg.id_f[i]+"\" class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>" +
                                "<a style='height: 200px;' class=\"thumbnail fancybox\" rel=\"ligthbox\" href=\"#\">"+
                                "<img class=\"img-responsive\" alt=\"\" src=\""+percorso+"\" />" +
                                "<div class='text-right'>" +
                                "<div class='row' style='padding-top: 15px;'>" +
                                "<div class='col-md-8 col-sm-12'><button onclick='eliminaF("+ogg.id_f[i]+")' class='btn btn-danger btn-block'>Elimina</button></div>"+
                                "<div class='col-md-3 col-sm-12'>" +
                                "<div class=\"btn-group\" data-toggle=\"buttons\">" +
                                "<label class=\"btn btn-default\">" +
                                "<input type=\"checkbox\" autocomplete=\"off\">" +
                                "<span class=\"glyphicon glyphicon-ok\"></span>" +
                                "</label>" +
                                "</div>" +
                                "</div>"+
                                "</div>"+
                                "</div>" +
                                "</a>" +
                                "</div>";
                        }
                    codice+="</div>";
                codice += "</div>";
                codice += "</div>";
            codice += "</div>";
            
            $('#body_foto').append(codice);
            $('#deSel').hide();
        },
        error: function () {
            alert("Chiamata fallita!!!");
        }
    });
}
function caricaF(id_c) {
    $('#btnupload').addClass('disabled');
    $('#btnupload').attr('disabled',true);
    $('#body_foto').animate({scrollTop: $('#scontrino').height()}, 100);
    $('#alertC').show();
    var lg = $('#input-ke-2')[0].files.length;
    var datiForm = new FormData();
    datiForm.append('num', lg);
    datiForm.append('id_c', id_c);
    for (var i = 0; i < lg; i++) {
        var nome_f = "foto" + i;
        datiForm.append(nome_f, $('#input-ke-2')[0].files[i]);
    }
    console.log(datiForm);

    $.ajax({
        url: 'metodi/carica_foto.php',
        type: 'POST', //Le info testuali saranno passate in POST
        data: datiForm, //I dati, forniti sotto forma di oggetto FormData
        cache: false,
        processData: false, //Serve per NON far convertire l’oggetto
        //FormData in una stringa, preservando il file
        contentType: false, //Serve per NON far inserire automaticamente
        //un content type errato
        success: function (data) {
                $('#gestione_foto').modal('hide');
        }
    });
}
function aggFoto() {
    $('#ges_foto').hide();
    $('#agg_foto').show();
}
function gestFoto() {
    $('#ges_foto').show();
    $('#agg_foto').hide();
}
function eliminaF(id) {
    $.ajax({
        type: "GET",
        url: "metodi/elimina_foto.php",
        data: "id_f="+id,
        dataType: "html",
        success: function(risposta){
            if(risposta==1) {
                var key = "#foto" + id;
                $(key).hide();
            }
        },
        error: function(){
            alert("Chiamata fallita!!!");
        }
    });
}