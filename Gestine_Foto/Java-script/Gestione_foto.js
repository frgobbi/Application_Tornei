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
                codice += "<a href='#' onclick='DelAll("+cartella+",\"1\")'>";
                codice += "<div class=\"panel panel-red\">"
                    + "<div  class=\"panel-heading text-center\"><h3>Elimina Album</h3></div>"
                    //+"<div class=\"panel-footer\"></div>"
                    + "</div>";
                codice += "</a>";
                codice += "</div>";
            } else {
                codice += "<div class=\"col-lg-4 col-md-4 col-sm-12 col-xs-12\">";
                codice += "<a href='#' onclick='DelAll("+cartella+",\"0\")'>";
                codice += "<div class=\"panel panel-red\">"
                    + "<div class=\"panel-heading text-center\"><h3>Elimina Foto</h3></div>"
                    //+"<div class=\"panel-footer\"></div>"
                    + "</div>";
                codice += "</div>";
                codice += "</a>";
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
                "<li id='deSel'><a href=\"#\" onclick='AllDeSel()'><i class=\"fa fa-square-o\" aria-hidden=\"true\"></i></a></li>"+
                "<li id='Sel'><a href=\"#\" onclick='AllSel()'><i class=\"fa fa-check-square-o\" aria-hidden=\"true\"></i></a></li>"+
                "<li id='cSel'><a href=\"#\" onclick='SelC()'><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></a></li>"+
                "</ul>"+
                "</div>" +
                "<div style='height: 600px; overflow-y: auto' class='panel-body'>";
                codice+="<div class='list-group gallery'><form name='modulo'>";
                        for(var i=1;i<ogg.id_f.length;i++){
                            var percorso = "../Immagini/"+ogg.nome_c+"/"+ogg.nome_f[i];
                            codice+= "<div id=\"foto"+ogg.id_f[i]+"\" class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>" +
                                "<a style='height: 200px;' class=\"thumbnail fancybox\" rel=\"ligthbox\" href=\"#\">"+
                                "<img class=\"img-responsive\" alt=\"\" src=\""+percorso+"\" />" +
                                "<div class='text-right'>" +
                                "<div class='row container-fluid' style='padding-top: 15px;'>" +
                                "<div class='col-md-8 col-sm-12'><button onclick='eliminaF("+ogg.id_f[i]+")' class='btn btn-danger btn-block'>Elimina</button></div>"+
                                "<div class='col-md-4 col-sm-12'>" +
                                "<div class=\"btn-group\" data-toggle=\"buttons\">" +
                                "<label class=\"btn btn-default fotoS\">" +
                                "<input id=\"foto"+ogg.id_f[i]+"\" type=\"checkbox\" name='foto' value=\""+ogg.id_f[i]+"\" autocomplete=\"off\">" +
                                "<span class=\"glyphicon glyphicon-ok\"></span>" +
                                "</label>" +
                                "</div>" +
                                "</div>"+
                                "</div>"+
                                "</div>" +
                                "</a>" +
                                "</div>";
                        }
                    codice+="</div></</form>";
                codice += "</div>";
                codice += "</div>";
            codice += "</div>";
            
            $('#body_foto').append(codice);

            setTimeout(function () {
                $('#deSel').hide();
                $('#alertC').hide();
                $('#agg_foto').hide();
                $('#ges_foto').hide();
            },10);
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
    setTimeout(function () {
        $("#input-ke-2").fileinput({
            theme: "explorer",
            uploadUrl: "#",
            showUpload:false,
            //allowedFileExtensions: ['jpg', 'png', 'gif'],
            overwriteInitial: false,
            initialPreviewAsData: true,
            initialPreview: [],
            initialPreviewConfig: [
                {caption: "nature-1.jpg", size: 329892, width: "120px", url: "/site/file-delete", key: 1},
                {caption: "nature-2.jpg", size: 872378, width: "120px", url: "/site/file-delete", key: 2},
                {caption: "nature-3.jpg", size: 632762, width: "120px", url: "/site/file-delete", key: 3},
            ],
            uploadExtraData: {
                img_key: "1000",
                img_keywords: "happy, nature",
            },
            preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
            previewFileIconSettings: { // configure your icon file extensions
                'doc': '<i class="fa fa-file-word-o text-primary"></i>',
                'xls': '<i class="fa fa-file-excel-o text-success"></i>',
                'ppt': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
                'pdf': '<i class="fa fa-file-pdf-o text-danger"></i>',
                'zip': '<i class="fa fa-file-archive-o text-muted"></i>',
                'htm': '<i class="fa fa-file-code-o text-info"></i>',
                'txt': '<i class="fa fa-file-text-o text-info"></i>',
                'mov': '<i class="fa fa-file-movie-o text-warning"></i>',
                'mp3': '<i class="fa fa-file-audio-o text-warning"></i>',
                // note for these file types below no extension determination logic
                // has been configured (the keys itself will be used as extensions)
                'jpg': '<i class="fa fa-file-photo-o text-danger"></i>',
                'gif': '<i class="fa fa-file-photo-o text-muted"></i>',
                'png': '<i class="fa fa-file-photo-o text-primary"></i>'
            },
            previewFileExtSettings: { // configure the logic for determining icon file extensions
                'doc': function(ext) {
                    return ext.match(/(doc|docx)$/i);
                },
                'xls': function(ext) {
                    return ext.match(/(xls|xlsx)$/i);
                },
                'ppt': function(ext) {
                    return ext.match(/(ppt|pptx)$/i);
                },
                'zip': function(ext) {
                    return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
                },
                'htm': function(ext) {
                    return ext.match(/(htm|html)$/i);
                },
                'txt': function(ext) {
                    return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
                },
                'mov': function(ext) {
                    return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
                },
                'mp3': function(ext) {
                    return ext.match(/(mp3|wav)$/i);
                },
            }
        });
    }, 100);
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
function AllSel() {
    $('.fotoS').addClass('active');
    $('#Sel').hide();
    $('#deSel').show();

    var i = 0;
    var modulo = document.modulo.elements;
    for (i=0; i<modulo.length; i++)
    {
        if(modulo[i].type == "checkbox")
        {
            modulo[i].checked = true;
        }
    }
}
function AllDeSel() {
    $('.fotoS').removeClass('active');
    $('#deSel').hide();
    $('#Sel').show();

    var i = 0;
    var modulo = document.modulo.elements;
    for (i=0; i<modulo.length; i++)
    {
        if(modulo[i].type == "checkbox")
        {
            modulo[i].checked = false;
        }
    }
}
function SelC() {
    var i = 0;
    var modulo = document.modulo.elements;
    for (i=0; i<modulo.length; i++)
    {
        if(modulo[i].type == "checkbox")
        {
            if(modulo[i].checked){
                eliminaF(modulo[i].value);
            }
        }
    }
}
function DelAll(cartella,d_cartella) {
    $.ajax({
        type: "GET",
        url: "metodi/eliminaAllFoto.php",
        data: "id_f="+cartella+"&del="+d_cartella,
        dataType: "html",
        success: function(risposta){
            window.location.href="Foto.php";
        },
        error: function(){
            alert("Chiamata fallita!!!");
        }
    });
}