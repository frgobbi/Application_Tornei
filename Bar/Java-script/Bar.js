/**
 * Created by francesco on 22/02/2017.
 */
function creaFormSoldi(username) {
    $('#add_denaroBody').empty();
    var codice = "";
    $.ajax({
        type: "GET",
        url: "metodi/dati_utente.php",
        data: "user=" + username,
        dataType: "html",
        success: function (risposta) {
            var ogg = $.parseJSON(risposta);
            if (ogg.card != null) {
                var percorso = "../Immagini/Immagini_Profilo/" + ogg.foto;
                codice += "<div class='row text-center' style='padding-bottom: 15px;'>"
                    + "<img src=\"" + percorso + "\" class=\"img-circle img-thumbnail\" width=\"170\" height=\"170\">"
                    + "</div>"
                    + "<ul class=\"list-group\">"
                    + "<li class=\"list-group-item\"><label>Utente:&nbsp; </label>" + ogg.nome + " " + ogg.cognome + "</li>"
                    + "<li class=\"list-group-item\"><label>Saldo Attuale:&nbsp;</label> &euro; " + ogg.saldo + "</li>"
                    + "</ul>"
                    + "<div class=\"panel panel-default\">"
                    + "<div class=\"panel-heading\">"
                    + "<h4 class=\"panel-title\">"
                    + "<a data-toggle=\"collapse\" href=\"#form_credito\">Aggiungi Credito</a>"
                    + "</h4>"
                    + "</div>"
                    + "<div id=\"form_credito\" class=\"panel-collapse collapse\">"
                    + "<div class=\"panel-body\">"
                    + "<form method='post' action=\"metodi/aggiungi_credito.php?user=" + username + "\">"
                    + "<div class=\"form-group\">"
                    + "<label for=\"credito\">Credito da aggiungere:<br><small>(usa il . per separare i decimali)</small></label>"
                    + "<input type=\"text\" class=\"form-control\" name='credito' id=\"credito\" placeholder='15.25'>"
                    + "</div>"
                    + "<div class=\"form-group\">"
                    + "<button class='btn btn-primary btn-block' type='submit'>Aggiungi credito</button>"
                    + "</div>"
                    + "</form>"
                    + "</div>"
                    + "</div>"
                    + "</div>"
                    + "<button type='button' onclick='cancellaCard(\"" + username + "\")' class='btn btn-danger btn-block'>Cancella Tessera</button> ";
            } else {
                var percorso = "../Immagini/Immagini_Profilo/" + ogg.foto;
                codice += "<div class='row text-center' style='padding-bottom: 15px;'>"
                    + "<img src=\"" + percorso + "\" class=\"img-circle img-thumbnail\" width=\"170\" height=\"170\">"
                    + "</div>"
                    + "<ul class=\"list-group\">"
                    + "<li class=\"list-group-item\"><label>Utente:&nbsp; </label>" + ogg.nome + " " + ogg.cognome + "</li>"
                    + "</ul>"
                    + "<form method='post' action=\"metodi/assegna_carta.php?user=" + username + "\">"
                    + "<div class=\"form-group\">"
                    + "<label for=\"codice\">Codice Carta</label>"
                    + "<input type=\"text\" class=\"form-control\" name='codice' id=\"codice\" required>"
                    + "</div>"
                    + "<div class=\"form-group\">"
                    + "<button class='btn btn-primary btn-block' type='submit'>Asseggna Carta</button>"
                    + "</div>"
                    + "</form>";
            }
            $('#add_denaroBody').append(codice);
        },
        error: function () {
            alert("Chiamata fallita!!!");
        }
    });
}
function cancellaCard(username) {
    var conferma = confirm("Calcellando la card verra' eliminato anche il credito corrente!\nContinuare?");
    if (conferma == true) {
        window.location.href = "metodi/cancella_card.php?user=" + username;
    }
}
function modificaC(id) {
    var keyC = "Color" + id;
    var keyB = "#Button" + id;
    var colore = document.getElementById(keyC).innerHTML;
    keyC = "#" + keyC;
    var codice = "<select class=\"form-control\" id=\"color" + id + "\">";
    if (colore.localeCompare("Rosso") == 0) {
        codice += "<option value=\"red\" selected>Rosso</option>"
    } else {
        codice += "<option value=\"red\">Rosso</option>";
    }
    if (colore.localeCompare("Giallo") == 0) {
        codice += "<option value=\"yellow\" selected>Giallo</option>"
    } else {
        codice += "<option value=\"yellow\">Giallo</option>";
    }
    if (colore.localeCompare("Verde") == 0) {
        codice += "<option value=\"green\" selected>Verde</option>"
    } else {
        codice += "<option value=\"green\">Verde</option>";
    }
    if (colore.localeCompare("Rosso Pastello") == 0) {
        codice += "<option value=\"danger\" selected>Rosso Pastello</option>"
    } else {
        codice += "<option value=\"danger\">Rosso Pastello</option>";
    }
    if (colore.localeCompare("Giallo Pastello") == 0) {
        codice += "<option value=\"warning\" selected>Giallo Pastello</option>"
    } else {
        codice += "<option value=\"warning\">Giallo Pastello</option>";
    }
    if (colore.localeCompare("Verde Pastello") == 0) {
        codice += "<option value=\"success\" selected>Verde Pastello</option>"
    } else {
        codice += "<option value=\"success\">Verde Pastello</option>";
    }
    if (colore.localeCompare("Celeste") == 0) {
        codice += "<option value=\"info\" selected>Celeste</option>"
    } else {
        codice += "<option value=\"info\">Celeste</option>";
    }
    if (colore.localeCompare("Blu") == 0) {
        codice += "<option value=\"primary\" selected>Blu</option>"
    } else {
        codice += "<option value=\"primary\">Blu</option>";
    }
    if (colore.localeCompare("Bianco") == 0) {
        codice += "<option value=\"default\" selected>Bianco</option>"
    } else {
        codice += "<option value=\"default\">Bianco</option>";
    }
    codice += "</select>";
    $(keyC).empty();
    $(keyC).append(codice);

    $(keyB).empty();
    $(keyB).append("<td id=\"Button" + id + "\"><button onclick=\"confermaC(" + id + ")\" class='btn btn-success'><i class='fa fa-check'></i></button></td>");
}
function confermaC(id) {
    var keyC = "#color" + id;
    var keyB = "#Button" + id;
    var colore = $(keyC).val();
    keyC = "#Color" + id;
    var codice;
    $.ajax({
        type: "GET",
        url: "metodi/modifica_colori.php",
        data: "id=" + id + "&colore=" + colore,
        dataType: "html",
        success: function (risposta) {
            if (risposta == 1) {
                if (colore.localeCompare("red") == 0) {
                    codice = "Rosso";
                } else {
                    if (colore.localeCompare("yellow") == 0) {
                        codice = "Giallo";
                    } else {
                        if (colore.localeCompare("green") == 0) {
                            codice = "Verde";
                        } else {
                            if (colore.localeCompare("info") == 0) {
                                codice = "Celeste";
                            } else {
                                if (colore.localeCompare("primary") == 0) {
                                    codice = "Blu";
                                } else {
                                    if (colore.localeCompare("default") == 0) {
                                        codice = "Bianco";
                                    } else {
                                        if (colore.localeCompare("danger") == 0) {
                                            codice = "Rosso Pastello";
                                        } else {
                                            if (colore.localeCompare("warning") == 0) {
                                                codice = "Giallo Pastello";
                                            } else {
                                                if (colore.localeCompare("success") == 0) {
                                                    codice = "Verde Pastello";
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $(keyC).empty();
            $(keyC).append(codice);
            $(keyB).empty();
            $(keyB).append("<td id=\"Button" + id + "\"><button onclick=\"modificaC(" + id + ")\" class='btn btn-primary'><i class='fa fa-pencil'></i></button></td>");

        },
        error: function () {
            alert("Chiamata fallita!!!");
        }
    });
}
function cambiaV(id) {
    var key = "vendibile" + id;
    var check = document.getElementById(key);
    var vendita;
    if (check.checked) {
        vendita = 1;
    } else {
        vendita = 0;
    }

    $.ajax({
        type: "GET",
        url: "metodi/cambia_vendita.php",
        data: "id=" + id + "&stato=" + vendita,
        dataType: "html",
        success: function (risposta) {
            if (risposta == 0) {
                check.checked = !check.checked;
            }
        },
        error: function () {
            alert("Chiamata fallita!!!");
        }
    });

}
function modificaP(id) {
    var keyN = "Nome" + id;
    var keyP = "Prezzo" + id;
    var keyB = "#ButtonP" + id;
    var nome = document.getElementById(keyN).innerHTML;
    var prezzo = document.getElementById(keyP).innerHTML;
    keyN = "#" + keyN;
    keyP = "#" + keyP;
    $(keyN).empty();
    $(keyP).empty();
    $(keyB).empty();
    $(keyN).append("<input required type=\"text\" class=\"form-control\" id=\"nome" + id + "\" value=\"" + nome + "\">");
    $(keyP).append("<input required type=\"text\" class=\"form-control\" id=\"prezzo" + id + "\" value=\"" + prezzo + "\">");
    $(keyB).append("<td id=\"ButtonP" + id + "\"><button onclick=\"confermaP(" + id + ")\" class='btn btn-success'><i class='fa fa-check'></i></button></td>");
}
function confermaP(id) {
    var keyN = "#nome" + id;
    var keyP = "#prezzo" + id;
    var keyB = "#ButtonP" + id;
    var nome = $(keyN).val();
    var prezzo = $(keyP).val();

    $.ajax({
        type: "GET",
        url: "metodi/modifica_prodotto.php",
        data: "id=" + id + "&nome=" + nome + "&prezzo=" + prezzo,
        dataType: "html",
        success: function (risposta) {
            if (risposta == 1) {
                keyN = "#Nome" + id;
                keyP = "#Prezzo" + id;

                $(keyN).empty();
                $(keyP).empty();
                $(keyB).empty();
                $(keyN).append(nome);
                $(keyP).append(prezzo);
                $(keyB).append("<td id=\"ButtonP" + id + "\"><button onclick=\"modificaP(" + id + ")\" class='btn btn-primary'><i class='fa fa-pencil'></i></button></td>");

            }
        },
        error: function () {
            alert("Chiamata fallita!!!");
        }
    });
}
function add_giorno() {
    $.ajax({
        type: "GET",
        url: "metodi/add_giorno.php",
        success: function (risposta) {
            var ogg = $.parseJSON(risposta);
            if (ogg.esito == 1) {
                var codice = "<tr id='rigaS" + ogg.id_giorno + "'>" +
                    "<td>" + ogg.data + "</td>" +
                    "<td>" + ogg.incasso + "</td>" +
                    "<td>" +
                    "<button id='buttonS" + ogg.id_giorno + "' onclick='chiudi_giorno(" + ogg.id_giorno + ")' class='btn btn-danger btn-block'><i class=\"fa fa-times-circle\" aria-hidden=\"true\"></i></button>" +
                    "</td>" +
                    "</tr>";
                $('#tbody_serate').append(codice);
            } else {
                if (ogg.esito == 0) {
                    alert("Chiudere tutte le giornate prima di crearne una nuova!");
                } else {
                    if (ogg.esito == 2) {
                        alert("Questa giornata e' gia' stata creata!!");
                    }
                }
            }
        },
        error: function () {
            alert("Chiamata fallita!!!");
        }
    });
}
function chiudi_giorno(id_giorno) {
    $.ajax({
        type: "GET",
        url: "metodi/chiudi_giorno.php",
        data: "id_giorno=" + id_giorno,
        dataType: "html",
        success: function (risposta) {
            if (risposta == 1) {
                var key = "#buttonS" + id_giorno;
                $(key).addClass("disabled");
                $(key).attr("disabled", true);
            } else {
                alert("Qualcosa è andato storto");
            }
        },
        error: function () {
            alert("Chiamata fallita!!!");
        }
    });
}
function Vserate() {
    $('#serateBody').empty();
    $.ajax({
        type: "GET",
        url: "metodi/visualizza_serate.php",
        success: function (risposta) {
            var ogg = $.parseJSON(risposta);
            var codice = "<div class=\"row\">" +
                "<div class=\"container-fluid table-responsive\">" +
                "<table id=\"tabella_serate\" class=\"table table-hover table-bordered\">" +
                "<thead>" +
                "<tr>" +
                "<th>Data</th>" +
                "<th>Incasso (&euro;)</th>" +
                "<th>Chiudi</th>" +
                "</tr>" +
                "</thead>" +
                "<tbody id=\"tbody_serate\">";
            for (var i = 1; i < ogg.data.length; i++) {
                codice += "<tr id='rigaS" + ogg.id[i] + "'>" +
                    "<td>" + ogg.data[i] + "</td>" +
                    "<td>" + ogg.incasso[i] + "</td>";
                if (ogg.chiuso[i] == 0) {
                    codice += "<td><button id='buttonS" + ogg.id[i] + "' onclick='chiudi_giorno(\"" + ogg.id[i] + "\")' class='btn btn-danger btn-block'><i class=\"fa fa-times-circle\" aria-hidden=\"true\"></i></button></td>";
                } else {
                    codice += "<td><button id='buttonS" + ogg.id[i] + "' disabled class='btn btn-danger btn-block disabled'><i class=\"fa fa-times-circle\" aria-hidden=\"true\"></i></button></td>";
                }
                codice += "</tr>";
            }
            codice += "</tbody>" +
                "</table>" +
                "</div>" +
                "</div>" +
                "<div class=\"row\">" +
                "<div class=\"container-fluid\">" +
                "<button onclick=\"add_giorno()\" class=\"btn btn-primary btn-block\">Aggiungi Serata</button>" +
                "</div>" +
                "</div>";
            $('#serateBody').append(codice);
        },
        error: function () {
            alert("Chiamata fallita!!!");
        }
    });
}