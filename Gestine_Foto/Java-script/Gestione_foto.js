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
            codice += "<div class=\"panel panel-primary\">"
                + "<div class=\"panel-heading text-center\"><h3>Aggiungi Foto</h3></div>"
                //+"<div class=\"panel-footer\"></div>"
                + "</div>";
            codice += "</div>";
            codice += "<div class=\"col-lg-4 col-md-4 col-sm-12 col-xs-12\">";
            codice += "<div class=\"panel panel-yellow\">"
                + "<div class=\"panel-heading text-center\"><h3>Gestisci Foto</h3></div>"
                //+"<div class=\"panel-footer\"></div>"
                + "</div>";
            codice += "</div>";
            if(cartella !=1) {
                codice += "<div class=\"col-lg-4 col-md-4 col-sm-12 col-xs-12\">";
                codice += "<div class=\"panel panel-red\">"
                    + "<div class=\"panel-heading text-center\"><h3>Elimina Album</h3></div>"
                    //+"<div class=\"panel-footer\"></div>"
                    + "</div>";
                codice += "</div>";
                codice += "</div>";
            } else {
                codice += "<div class=\"col-lg-4 col-md-4 col-sm-12 col-xs-12\">";
                codice += "<div class=\"panel panel-red\">"
                    + "<div class=\"panel-heading text-center\"><h3>Elimina Foto</h3></div>"
                    //+"<div class=\"panel-footer\"></div>"
                    + "</div>";
                codice += "</div>";
                codice += "</div>";
            }
            codice += "<div id='gestione_foto'  class='row'>";
            
            codice += "</div>";
            codice += "<div id='agg_foto' class='row' style='height: 400px; overflow-y: auto'>";
            codice += "<div class='container-fluid'>";
            codice += "<label class=\"control-label\">Select File</label>"
                + "<input id=\"input-ke-2\" name=\"foto[]\" type=\"file\" multiple class=\"file-loading\">";
            codice += "</div>";
            codice += "<div style='padding-top: 30px;' class='container-fluid'>";
            codice += "<button class='btn btn-primary btn-lg btn-block' onclick='caricaF(" + ogg.id_c + ")'>Carica Foto</button>";
            codice += "</div>";
            codice += "</div>";
            $('#body_foto').append(codice);
        },
        error: function () {
            alert("Chiamata fallita!!!");
        }
    });
}
function caricaF(id_c) {
    var lg = $('#input-ke-2')[0].files.length;
    var datiForm = new FormData();
    datiForm.append('num', lg);
    datiForm.append('id_c', lg);
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
            alert("hghghghghghghg");
        }
    });
}