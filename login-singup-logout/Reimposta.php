<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 29/11/2016
 * Time: 15:21
 */
?>
<html>
    <head>
        <?php
        include '../Componenti_Base/Head.php';
        LibrerieUnLog()
        ?>
        <style type="text/css">
            .messaggi{
                display: none;
            }
        </style>
        <script type="text/javascript">
            function inviamail() {
                var mail = $('#mail').val();
                if(mail.localeCompare("")!=0) {
                    $('#alertW').hide();
                    $.ajax({
                        // definisco il tipo della chiamata
                        type: "GET",
                        // specifico la URL della risorsa da contattare
                        url: "metodi/mail_recupero.php",
                        // passo dei dati alla risorsa remota
                        data: "mail=" + mail,
                        // definisco il formato della risposta
                        dataType: "html",
                        // imposto un'azione per il caso di successo
                        success: function (risposta) {
                            if(risposta == 0){
                                $('#alertD').hide();
                                $('#messaggio').modal('show');
                                timeRefresh(5000);
                            } else if(risposta == 1){
                                alert("Qualcosa e' andato storto...riprova piu' tardi");
                            } else if(risposta == 2){
                                $('#alertD').show();
                            }
                        },
                        // ed una per il caso di fallimento
                        error: function () {
                            alert("Chiamata fallita!!!");
                        }
                    });
                } else{
                    $('#alertW').show();
                }
            }

            function timeRefresh(timeoutPeriod)
            {
                setTimeout("location.href='../index.php';",timeoutPeriod);
            }
        </script>
    </head>
    <body>
    <div id="wrapper">
        <?php
        require '../Componenti_Base/Nav-SideBar.php';
        navUnLog();
        ?>
        <div id="page-wrapper">
            <div style="padding: 30px" class="row">
                <div class="col-lg-6 col-lg-offset-3 col-md-4 col-md-offset-4 col-sm-12 col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Recupera Dati</div>
                        <div class="panel-body">
                            <form>
                                <div class="form-group">
                                    <label for="mail">Iserisci la tua mail:</label>
                                    <input type="text" class="form-control" id="mail" placeholder="mail">
                                </div>
                                <div id="alertD" class="messaggi alert alert-danger">
                                    <strong>Mail Errata</strong>
                                    <br>Questa meil non è registrata nel sistema,
                                    <br> Se il problema persiste contatta lo staff tramite: <a href="#" class="alert-link">torneosupernova@gmail.com</a>.
                                </div>
                                <div id="alertW" class="messaggi alert alert-warning">
                                    <strong>Attenzione!</strong> Inserisci la mail collegata al tuo account.
                                </div>
                                <div class="form-group">
                                    <button type="button" onclick="inviamail()" class="btn btn-primary btn-block">Reimposta dati</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->

                <!-- Modal -->
                <div class="modal fade" id="messaggio" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                Mail Inviata
                            </div>
                            <div class="modal-body">
                                <p>Ti è stata inviata una mail con il tuo username e il link per poter modificare la pasword.<br>
                                    Controlla la tua casella di posta.
                                </p>
                            </div>
                            <div class="modal-footer"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    </body>
</html>
