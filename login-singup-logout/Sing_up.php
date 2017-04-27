<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <?php
    include '../Componenti_Base/Head.php';
    LibrerieUnLog()
    ?>
    <style type="text/css">
        .glyphicon-ok, .glyphicon-remove {
            display: none;
        }

        #alertF {
            display: none;
        }

        #dati_login{
            display: none;
        }
    </style>
    <script type="text/javascript" src="./javascript/Controlli.js"></script>
</head>
<body>
<div id="wrapper">
    <?php
    require '../Componenti_Base/Nav-SideBar.php';
    navUnLog();
    ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3 col-md-4 col-md-offset-4 col-sm-12 col-sm-12">
                <br><br>
                <div class="panel panel-primary">
                    <div class="panel-heading">Registrati</div>
                    <div class="panel-body">
                        <form id="iscrizione_utenti" method="post" action="metodi/Iscrizione.php">
                            <div id="alert">
                                <div id="alertF" class="alert alert-danger alert-dismissible">
                                    <strong><i class="fa fa-asterisk" aria-hidden="true"></i></strong> Campi
                                    Obbligatori!
                                </div>
                            </div>
                            <div id="dati_utente">
                                <!-- has-error/has-success has-feedback (Classi da aggiungere in caso di errore o corretto)-->
                                <div id="Fnome_utente" class="form-group">
                                    <label class="control-label" for="nome_utente">Nome:<i
                                            class="fa fa-asterisk text-danger" aria-hidden="true"></i></label>
                                    <input type="text" class="form-control" id="nome_utente" name="nome_utente"
                                           placeholder="Nome" required>
                                    <span id="LEnome_utente" class="glyphicon glyphicon-remove form-control-feedback"
                                          aria-hidden="true"></span>
                                    <span id="LOKnome_utente" class="glyphicon glyphicon-ok form-control-feedback"
                                          aria-hidden="true"></span>
                                </div>

                                <div id="Fcognome_utente" class="form-group">
                                    <label class="control-label" for="nome_utente">Cognome:<i
                                            class="fa fa-asterisk text-danger" aria-hidden="true"></i></label>
                                    <input type="text" class="form-control" id="cognome_utente" name="cognome_utente"
                                           placeholder="Cognome" required>
                                    <span id="LEcognome_utente" class="glyphicon glyphicon-remove form-control-feedback"
                                          aria-hidden="true"></span>
                                    <span id="LOKcognome_utente" class="glyphicon glyphicon-ok form-control-feedback"
                                          aria-hidden="true"></span>
                                </div>

                                <div id="Fdata_utente" class="form-group">
                                    <label class="control-label" for="data_utente">Data di nascita:<i
                                            class="fa fa-asterisk text-danger" aria-hidden="true"></i></label>
                                    <input type="date" class="form-control" id="data_utente" name="data_utente"
                                           placeholder="03-06-1997" required>
                                    <span id="LEdata_utente" class="glyphicon glyphicon-remove form-control-feedback"
                                          aria-hidden="true"></span>
                                    <span id="LOKdata_utente" class="glyphicon glyphicon-ok form-control-feedback"
                                          aria-hidden="true"></span>
                                </div>


                                <div id="Fluogo_utente" class="form-group">
                                    <label class="control-label" for="luogo_utente">Luogo di nascita:<i
                                            class="fa fa-asterisk text-danger" aria-hidden="true"></i></label>
                                    <input type="text" class="form-control" id="luogo_utente" name="luogo_utente"
                                           placeholder="Luogo di nascita" required>
                                    <span id="LEluogo_utente" class="glyphicon glyphicon-remove form-control-feedback"
                                          aria-hidden="true"></span>
                                    <span id="LOKluogo_utente" class="glyphicon glyphicon-ok form-control-feedback"
                                          aria-hidden="true"></span>
                                </div>

                                <div class="form-group">
                                    <div class="radio">
                                        <label><input checked type="radio" name="sesso" value="M"><i class="fa fa-male" aria-hidden="true"></i> Maschio</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="sesso" value="F"><i class="fa fa-female" aria-hidden="true"></i> Femmina</label>
                                    </div>
                                </div>

                                <div id="Fcodice_utente" class="form-group">
                                    <label class="control-label" for="codice_utente">Codice Fiscale:<i
                                            class="fa fa-asterisk text-danger" aria-hidden="true"></i></label>
                                    <input type="text" class="form-control" id="codice_utente"
                                           onkeyup="this.value = this.value.toLocaleUpperCase();" name="codice_utente"
                                           placeholder="Codice Fiscale" required>
                                    <span id="LEcodice_utente" class="glyphicon glyphicon-remove form-control-feedback"
                                          aria-hidden="true"></span>
                                    <span id="LOKcodice_utente" class="glyphicon glyphicon-ok form-control-feedback"
                                          aria-hidden="true"></span>
                                </div>

                                <div id="Fresidenza_utente" class="form-group">
                                    <label class="control-label" for="residenza_utente">Residenza:<i
                                            class="fa fa-asterisk text-danger" aria-hidden="true"></i></label>
                                    <input type="text" class="form-control" id="residenza_utente"
                                           name="residenza_utente" placeholder="Via Montiano 5 Corciano" required>
                                    <span id="LEresidenza_utente"
                                          class="glyphicon glyphicon-remove form-control-feedback"
                                          aria-hidden="true"></span>
                                    <span id="LOKresidenza_utente" class="glyphicon glyphicon-ok form-control-feedback"
                                          aria-hidden="true"></span>
                                </div>

                                <div class="form-group">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-block " onclick="cambia()">
                                            Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div id="dati_login">
                                <div class="form-group">
                                    <div id="Fusername_utente" class="form-group">
                                        <label class="control-label" for="username_utente">Username:<i
                                                class="fa fa-asterisk text-danger" aria-hidden="true"></i></label>
                                        <input type="text" class="form-control" onblur="controllaUser()" id="username_utente"
                                               name="username_utente" placeholder="Username" required>
                                    <span id="LEusername_utente"
                                          class="glyphicon glyphicon-remove form-control-feedback"
                                          aria-hidden="true"></span>
                                    <span id="LOKusername_utente" class="glyphicon glyphicon-ok form-control-feedback"
                                          aria-hidden="true"></span>
                                    </div>

                                    <div id="Femail_utente" class="form-group">
                                        <label class="control-label" for="email_utente">Email:<i
                                                class="fa fa-asterisk text-danger" aria-hidden="true"></i></label>
                                        <input type="email" class="form-control" id="email_utente"
                                               name="email_utente" placeholder="Email" onblur="controllaMail()" required>
                                    <span id="LEemail_utente"
                                          class="glyphicon glyphicon-remove form-control-feedback"
                                          aria-hidden="true"></span>
                                    <span id="LOKemail_utente" class="glyphicon glyphicon-ok form-control-feedback"
                                          aria-hidden="true"></span>
                                    </div>

                                    <div id="Fpass_utente" class="form-group">
                                        <label class="control-label" for="pass_utente">Password:<i
                                                class="fa fa-asterisk text-danger" aria-hidden="true"></i></label>
                                        <input type="password" class="form-control" onblur="confermaP()" id="pass_utente"
                                               name="pass_utente" placeholder="Password" required>
                                    <span id="LEpass_utente"
                                          class="glyphicon glyphicon-remove form-control-feedback"
                                          aria-hidden="true"></span>
                                    <span id="LOKpass_utente" class="glyphicon glyphicon-ok form-control-feedback"
                                          aria-hidden="true"></span>
                                    </div>

                                    <div id="Fconferma" class="form-group">
                                        <label class="control-label" for="conferma">Password:<i
                                                class="fa fa-asterisk text-danger"  aria-hidden="true"></i></label>
                                        <input type="password" class="form-control" onblur="confermaP()" id="conferma"
                                                placeholder="Conferma Password" required>
                                    <span id="LEconferma"
                                          class="glyphicon glyphicon-remove form-control-feedback"
                                          aria-hidden="true"></span>
                                    <span id="LOKconferma" class="glyphicon glyphicon-ok form-control-feedback"
                                          aria-hidden="true"></span>
                                        <div id="controlloP" style="display: none;" class="help-block with-errors">Password non uguali</div>
                                    </div>

                                    <div id="Ftelutente" class="form-group">
                                        <label class="control-label" for="tel_utente">Numero di telefono: (facoltativo)</label>
                                        <input type="tel" class="form-control" id="tel_utente"
                                               name="tel_utente" placeholder="Numero di Telefono">
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xm-12 col-sm-6 col-md-6 col-lg-6">
                                                <button type="button" id="buttonSub" onclick="submitForm()" class="btn btn-primary btn-lg btn-block">Invia</button>
                                            </div>
                                            <div class="col-xm-12 col-sm-6 col-md-6 col-lg-6">
                                                <button type="button" onclick="resetForm()" class="btn btn-danger btn-lg btn-block">Reset</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-block " onclick="indietro()">
                                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Previous
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
</body>
</html>


