/**
 * Created by francesco on 20/11/2016.
 */
/*
 * Prima parte della form
 */
function cambia() {
    var risultato = 0;
    var input = ["nome_utente", "cognome_utente", "data_utente", "luogo_utente", "codice_utente", "residenza_utente"];
    for (var i = 0; i < input.length; i++) {
        var valore = document.getElementById(input[i]).value;
        var confronto = valore.localeCompare("");
        var keyI = "#F" + input[i];
        var keyLE = "#LE" + input[i];
        var keyLOK = "#LOK" + input[i];
        if (confronto == 0) {
            $(keyI).addClass("has-error");
            $(keyI).addClass("has-feedback");
            $(keyI).removeClass("has-success");
            $(keyLE).show();
            $(keyLOK).hide();
            risultato = 1;
        } else {
            $(keyI).addClass("has-success");
            $(keyI).addClass("has-feedback");
            $(keyI).removeClass("has-error");
            $(keyLOK).show();
            $(keyLE).hide();
        }
    }

    if (risultato == 0) {
        $('#alertF').hide();
        $('#dati_utente').hide();
        $('#dati_login').show();
    } else {
        $('#alertF').show();
    }
}

function indietro() {
    $('#dati_login').hide();
    $('#dati_utente').show();
}

/*
 * Seconda Parte della Form
 */

function controllaUser() {
    var controllo = 0;
    var user = document.getElementById("username_utente").value;
    var key = "#username_utente";
    var keyI = "#Fusername_utente";
    var keyLE = "#LEusername_utente";
    var keyLOK = "#LOKusername_utente";

    if (user.localeCompare("") != 0) {
        $.ajax({
            // definisco il tipo della chiamata
            type: "GET",
            // specifico la URL della risorsa da contattare
            url: "metodi/controlla_user.php",
            // passo dei dati alla risorsa remota
            data: "user=" + user,
            // definisco il formato della risposta
            dataType: "html",
            // imposto un'azione per il caso di successo
            success: function (risposta) {
                if (risposta > 0) {
                    $(keyI).addClass("has-error");
                    $(keyI).addClass("has-feedback");
                    $(keyI).removeClass("has-success");
                    $(keyLE).show();
                    $(keyLOK).hide();
                    $(key).popover({
                        title: "username scorretto",
                        content: "Username gia' usato",
                        placement: "top"
                    });
                    $(key).popover('show');
                    controllo = 1;
                } else {
                    $(keyI).addClass("has-success");
                    $(keyI).addClass("has-feedback");
                    $(keyI).removeClass("has-error");
                    $(keyLOK).show();
                    $(keyLE).hide();
                }
            },
            // ed una per il caso di fallimento
            error: function () {
                alert("Chiamata fallita!!!");
            }
        });
    } else {
        $(keyI).addClass("has-error");
        $(keyI).addClass("has-feedback");
        $(keyI).removeClass("has-success");
        $(keyLE).show();
        $(keyLOK).hide();
        $(key).popover({title: "username scorretto", content: "Questo campo e' obbligatorio", placement: "top"});
        $(key).popover('show');
        controllo = 1;
    }
    return controllo;
}

function confermaP() {
    var controllo = 0;
    var pwd1 = document.getElementById("pass_utente").value;
    var pwd2 = document.getElementById("conferma").value;

    if (pwd1.localeCompare("") == 0) {
        $("#Fpass_utente").addClass("has-error");
        $("#Fpass_utente").addClass("has-feedback");
        $("#Fpass_utente").removeClass("has-success");
        $("#LEpass_utente").show();
        $("#Lpass_utente").hide();
        controllo = 1;
    } else {
        $("#Fpass_utente").removeClass("has-error");
        $("#Fpass_utente").addClass("has-feedback");
        $("#Fpass_utente").addClass("has-success");
        $("#LEpass_utente").hide();
        $("#LOKpass_utente").show();
    }

    var confronto = pwd1.localeCompare(pwd2);
    if (pwd2.localeCompare("") != 0) {
        if (confronto == 0) {
            $("#Fconferma").removeClass("has-error");
            $("#Fconferma").addClass("has-feedback");
            $("#Fconferma").addClass("has-success");
            $("#LEconferma").hide();
            $("#LOKconferma").show();
            $("#controlloP").hide();

            $("#Fpass_utente").removeClass("has-error");
            $("#Fpass_utente").addClass("has-feedback");
            $("#Fpass_utente").addClass("has-success");
            $("#LEpass_utente").hide();
            $("#LOKpass_utente").show();
        } else {
            $("#Fconferma").addClass("has-error");
            $("#Fconferma").addClass("has-feedback");
            $("#Fconferma").removeClass("has-success");
            $("#LEconferma").show();
            $("#LOKconferma").hide();
            $("#controlloP").show();
            controllo = 1;
        }
    } else {
        $("#Fconferma").addClass("has-error");
        $("#Fconferma").addClass("has-feedback");
        $("#Fconferma").removeClass("has-success");
        $("#LEconferma").show();
        $("#LOKconferma").hide();
        controllo = 1;
    }
    return controllo;
}

function controllaMail() {
    var controllo = 0;
    var mail = document.getElementById("email_utente").value;
    if (mail.localeCompare("") != 0) {
        var nome = mail.split("@");
        if (nome.length == 2) {
            var dominio = nome[1].split(".");
            if (dominio.length == 2) {
                $("#Femail_utente").removeClass("has-error");
                $("#Femail_utente").addClass("has-feedback");
                $("#Femail_utente").addClass("has-success");
                $("#LEemail_utente").hide();
                $("#LOKemail_utente").show();
                $("#email_utente").popover('hide');
            } else {
                $("#Femail_utente").addClass("has-error");
                $("#Femail_utente").addClass("has-feedback");
                $("#Femail_utente").removeClass("has-success");
                $("#LEemail_utente").show();
                $("#LOKemail_utente").hide();
                $("#email_utente").popover({
                    title: "Campo Mail",
                    content: "Formato mail non corretto",
                    placement: "top"
                });
                $("#email_utente").popover('show');
                controllo = 1;
            }
        } else {
            $("#Femail_utente").addClass("has-error");
            $("#Femail_utente").addClass("has-feedback");
            $("#Femail_utente").removeClass("has-success");
            $("#LEemail_utente").show();
            $("#LOKemail_utente").hide();
            $("#email_utente").popover({title: "Campo Mail", content: "formato mail non corretto", placement: "top"});
            $("#email_utente").popover('show');
            controllo = 1;
        }
    } else {
        $("#Femail_utente").addClass("has-error");
        $("#Femail_utente").addClass("has-feedback");
        $("#Femail_utente").removeClass("has-success");
        $("#LEemail_utente").show();
        $("#LOKemail_utente").hide();
        controllo = 1;
    }
    return controllo;
}

/*
 * Conferma/Reset
 */
function resetForm() {
    document.getElementById("iscrizione_utenti").reset();

    var input = ["nome_utente", "cognome_utente", "data_utente", "luogo_utente", "codice_utente", "residenza_utente", "username_utente", "email_utente", "pass_utente", "conferma", "tel_utente"];
    for (var i = 0; i < input.length; i++) {
        var keyI = "#F" + input[i];
        var keyLE = "#LE" + input[i];
        var keyLOK = "#LOK" + input[i];
        $(keyI).removeClass("has-error");
        $(keyI).removeClass("has-feedback");
        $(keyI).removeClass("has-success");
        $(keyLE).hide();
        $(keyLOK).hide();
    }

    $('#dati_login').hide();
    $('#dati_utente').show();
}

function submitForm() {
    var controllo = 0;
    var user = controllaUser();
    var mail = controllaMail();
    var pass = confermaP();

    if (user == 1) {
        controllo = 1;
    }

    if (mail == 1) {
        controllo = 1;
    }

    if (pass == 1) {
        controllo = 1
    }


    if (controllo == 0) {
        document.getElementById("iscrizione_utenti").submit();
    }

}