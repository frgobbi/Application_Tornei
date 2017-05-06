/**
 * Created by francesco on 14/04/2017.
 */
var num_g_a =0;
var max_g = 0;
var min_g = 0;
var input = ["nome", "cognome", "data", "luogo", "cod", "res","sesso"];
function ControllaNome(id_t) {
    var nome = $('#nome_sq').val();
    var key = "#nome_sq";
    var keyI = "#Fnome_sq";
    var keyLE = "#LEnome_sq";
    var keyLOK = "#LOKnome_sq";
    if(nome.localeCompare("")==0){
        $(keyI).addClass("has-error");
        $(keyI).addClass("has-feedback");
        $(keyI).removeClass("has-success");
        $(keyLE).show();
        $(keyLOK).hide();
        $(key).popover({
            title: "Nome Errato",
            content: "Inserire il nome della squadra",
            placement: "top"
        });
        $(key).popover('show');
    } else {
        $.ajax({
            type: "GET",
            url: "controlli/controllaNomeSq.php",
            data: "id_t="+id_t+"&nome_sq="+nome,
            dataType: "html",
            success: function(risposta){
                if(risposta==0){
                    $(keyI).addClass("has-success");
                    $(keyI).addClass("has-feedback");
                    $(keyI).removeClass("has-error");
                    $(keyLE).hide();
                    $(keyLOK).show();
                    $(key).popover('hide');
                } else {
                    $(keyI).addClass("has-error");
                    $(keyI).addClass("has-feedback");
                    $(keyI).removeClass("has-success");
                    $(keyLE).show();
                    $(keyLOK).hide();
                    $(key).popover({
                        title: "Nome Errato",
                        content: "Il nome della squadra e' gia' usato",
                        placement: "top"
                    });
                    $(key).popover('show');
                }
            },
            error: function(){
                alert("Chiamata fallita!!!");
            }
        });
    }
}
function nextPag(id_t) {
    var nome = $('#nome_sq').val();
    var key = "#nome_sq";
    var keyI = "#Fnome_sq";
    var keyLE = "#LEnome_sq";
    var keyLOK = "#LOKnome_sq";
    if(nome.localeCompare("")==0){
        $(keyI).addClass("has-error");
        $(keyI).addClass("has-feedback");
        $(keyI).removeClass("has-success");
        $(keyLE).show();
        $(keyLOK).hide();
        $(key).popover({
            title: "Nome Errato",
            content: "Inserire il nome della squadra",
            placement: "top"
        });
        $(key).popover('show');
    } else {
        $.ajax({
            type: "GET",
            url: "controlli/controllaNomeSq.php",
            data: "id_t="+id_t+"&nome_sq="+nome,
            dataType: "html",
            success: function(risposta){
                if(risposta==0){
                    $(keyI).addClass("has-success");
                    $(keyI).addClass("has-feedback");
                    $(keyI).removeClass("has-error");
                    $(keyLE).hide();
                    $(keyLOK).show();
                    $(key).popover('hide');
                    $('#resp_sq').hide();
                    $('#g_sq').show();
                } else {
                    $(keyI).addClass("has-error");
                    $(keyI).addClass("has-feedback");
                    $(keyI).removeClass("has-success");
                    $(keyLE).show();
                    $(keyLOK).hide();
                    $(key).popover({
                        title: "Nome Errato",
                        content: "Il nome della squadra e' gia' usato",
                        placement: "top"
                    });
                    $(key).popover('show');
                }
            },
            error: function(){
                alert("Chiamata fallita!!!");
            }
        });
    }
}
function indietro() {
    $('#g_sq').hide();
    $('#resp_sq').show();
}
function cercaUtenti(id_t, id) {
    var codice = "";
    keyN = "#nome"+id;
    var nome = $(keyN).val();
    keyC = "#cognome"+id;
    var cognome = $(keyC).val();

    if((nome.localeCompare("")!=0) && (cognome.localeCompare("")!=0)){
        $.ajax({
            type: "GET",
            url: "controlli/cercaUtente.php",
            data: "nome="+nome+"&cognome="+cognome,
            success: function(risposta){
                var ogg = $.parseJSON(risposta);
                if(ogg.numero != 0){
                    $('#body_utenti').empty();
                    codice += "<div class='container-fluid'>" +
                            "<div class='alert alert-info'><strong>INFO</strong> Se l'utente gia' esiste cliccaci per inserire i sui dati!</div>"+
                        "<div class='table-responsive'>" +
                        "<table class='table table-hover'>" +
                        "<thead>" +
                        "<th>Nome</th>" +
                        "<th>Cognome</th>" +
                        "<th>Data di nascita</th>" +
                        "<th>Luogo di nascita</th>" +
                        "<th>Codice fiscale</th>" +
                        "<th>Residenza</th>" +
                        "</thead>" +
                        "<tbody>";
                        for(var i=0; i<ogg.numero; i++){
                            codice += "<tr onclick='giocatore("+id_t+","+id+",\""+ogg.nome[i]+"\",\""+ogg.cognome[i]+"\",\""+ogg.data_nascita[i]+"\",\""+ogg.luogo_nascita[i]+"\",\""+ogg.codice_fiscale[i]+"\",\""+ogg.residenza[i]+"\")'>" +
                                "<td>"+ogg.nome[i]+"</td>" +
                                "<td>"+ogg.cognome[i]+"</td>" +
                                "<td>"+ogg.data_nascita[i]+"</td>" +
                                "<td>"+ogg.luogo_nascita[i]+"</td>" +
                                "<td>"+ogg.codice_fiscale[i]+"</td>" +
                                "<td>"+ogg.residenza[i]+"</td>" +
                                "</tr>"
                        }
                        codice += "</tbody>" +
                        "</table>" +
                        "</div>" +
                        "</div>";
                    $('#body_utenti').append(codice);
                    $('#modal_utenti').modal('show');
                }
            },
            error: function(){
                alert("Chiamata fallita!!!");
            }
        }); 
    }
}
function giocatore(id_t, id,nome,cognome,data_nascita,luogo_nascita,codice_fiscale,residenza){
    var keyN = "#nome"+id;
    var keyC = "#cognome"+id;
    var keyD = "#data"+id;
    var keyL = "#luogo"+id;
    var keyCod = "#cod"+id;
    var keyR = "#res"+id;

    $(keyN).val(nome);
    $(keyC).val(cognome);
    $(keyD).val(data_nascita);
    $(keyL).val(luogo_nascita);
    $(keyCod).val(codice_fiscale);
    $(keyR).val(residenza);

    giocatoreGiaIscritto(id_t,id);

    $('#modal_utenti').modal('hide');

}
function giocatoreGiaIscritto(id_t,id){
    var keyC = "#cod"+id;
    var cod = $(keyC).val();
    var key = "#alert"+id;
    $.ajax({
        type: "GET",
        url: "controlli/gIscritto.php",
        data: "id_t="+id_t+"&cod="+cod,
        success: function(risposta){
            if(risposta!=0){
                console.log(key);
                $(key).show();
            } else{
                $(key).hide();
            }
        },
        error: function(){
            alert("Chiamata fallita!!!");
        }
    });

}
function addGiocatore() {
    if(num_g_a!=max_g){
        var controllo = 0;
        for(var i = 0;i<input.length;i++){
            var key = "#"+input[i]+num_g_a;
            var text = $(key).val();
            if(text.localeCompare("")==0){
                controllo = 1;
            }
        }

        if(controllo == 0){
            num_g_a ++;
            var riga = "#giocatore"+num_g_a;
            $(riga).show();
        } else {
            alert("Compila tutti i campi prima di inserire un nuovo gioctore!");
        }
    }else {
        alert("Numero massimo di giocatori inseriti");
    }
}
function removeGiocatore() {
    if(num_g_a!=min_g) {
        var riga = "#giocatore" + num_g_a;
        $(riga).hide();
        for (var i = 0; i < input.length; i++) {
            var key = "#" + input[i] + num_g_a;
            $(key).val("");
        }
        num_g_a--;
    } else {
        alert("Numero minimo di gicatori da inserire");
    }
}
function invia(username,id_t) {
    $('#inviaF').attr("disabled");
    $('#inviaF').addClass("disabled");
    $('#ruota').show();
    var nome_sq = $('#nome_sq').val();
    var gioco_r = $('#gioco').val();
    var parametri = "id_t="+id_t+"&username="+username+"&nome_sq="+nome_sq+"&gioco="+gioco_r+"&numero_g="+num_g_a;
    for(var i=0;i<=num_g_a;i++){
        for(var j=0;j<input.length;j++){
            var key = "#" + input[j] + i;
            var txt = $(key).val();
            var parola =  input[j] + i;
            parametri += "&"+parola+"="+txt;
        }
    }
    console.log(parametri);
    $.ajax({
        type: "POST",
        url: "metodi/iscriviSquadra.php",
        data: parametri,
        dataType: "html",
        success: function(risposta){
           window.location.href="Iscritto.php?esito="+risposta+"&id_t="+id_t;
        },
        error: function(){
            alert("Chiamata fallita!!!");
        }
    });
}