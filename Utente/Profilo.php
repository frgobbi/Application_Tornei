<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 29/11/2016
 * Time: 19:53
 */
session_start();
if (!$_SESSION['login']) {
    header("Location:../index.php");
}
?>
<html>
<head>
    <?php
    include '../Componenti_Base/Head.php';
    LibrerieLogin();
    ?>
    <style type="text/css">
    </style>
    <script type="text/javascript">
        function submit_f(){
            var pwd1 = $('#pwd_n').val();
            var pwd2 = $('#pwd_c').val();
            var pwd3 = $('#pwd_p').val();

            if((pwd1.localeCompare("")!=0)&&(pwd2.localeCompare("")!=0)&&(pwd3.localeCompare("")!=0)){
                if(pwd1.localeCompare(pwd2)==0){
                    $.ajax({
                        // definisco il tipo della chiamata
                        type: "POST",
                        // specifico la URL della risorsa da contattare
                        url: "metodi/Modifica_password.php",
                        // passo dei dati alla risorsa remota
                        data: "nuova="+pwd1+"&attuale="+pwd3,
                        // definisco il formato della risposta
                        dataType: "html",
                        // imposto un'azione per il caso di successo
                        success: function(risposta){
                            if(risposta == 0){
                                alert("Password cambiata con successo");
                                document.getElementById('Fpwd').reset();
                            } else {
                                if(risposta == 2){
                                    alert("Password corrente errata");
                                } else {
                                    if(risposta == 1){
                                        alert("qualcosa e' andato storto...risporva piu' tardi");
                                    }
                                }
                            }
                        },
                        // ed una per il caso di fallimento
                        error: function(){
                            alert("Chiamata fallita!!!");
                        }
                    });
                } else{
                    alert("Password non corrette");
                }
            } else{
                alert("Compila tutti i campi");
            }

        }

        function reset_f() {
            document.getElementById('Fpwd').reset();
        }
    </script>
</head>
<body>
<div id="wrapper">
    <?php
    require '../Componenti_Base/Nav-SideBar.php';
    navLogin();
    ?>
    <div style="padding-bottom: 30px;" id="page-wrapper">
        <div class="row">
            <div class="well">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#home" data-toggle="tab">Profilo</a>
                    </li>
                    <li>
                        <a href="#change" data-toggle="tab">Modifica</a>
                    </li>
                    <li>
                        <a href="#profile" data-toggle="tab">Password</a>
                    </li>
                </ul>
                <?php
                echo "<div id=\"myTabContent\" class=\"tab-content\">"
                    . "<div class=\"tab-pane active in\" id=\"home\">"
                    . "<div style=\"padding-top: 15px;\" class=\"row\">";

                include "../connessione.php";
                try {
                    $utente = $_SESSION['username'];
                    $oggUtente = $connessione->query("SELECT `nome`, `cognome`,`luogo_nascita`, `username`,`sesso`,`residenza`,`mail`,`tel`,`foto`, DATE_FORMAT(`data_nascita`,'%d-%m-%Y') AS data_n FROM utente WHERE username = '$utente'")->fetch(PDO::FETCH_OBJ);
                } catch (PDOException $e) {
                    echo "errore: " . $e->getMessage();
                }
                $connessione = null;

                echo "<div style='padding-bottom: 20px;' class=\"col-lg-4 col-md-4 col-sm-4 col-xs-12\">"
                    . "<img class=\"img-circle img-responsive\" alt=\"\"  src=\"../Immagini/Immagini_Profilo/$oggUtente->foto\">"
                    . "</div>";

                echo "<div id=\"div_dati_utente\" class=\"col-lg8 col-md-8 col-sm-4 col-xs-12\">"
                    . "<ul id=\"dati_utente\" class=\"list-group\">"
                    . "<li class=\"list-group-item\"><i class=\"fa fa-user\" aria-hidden=\"true\"></i> $oggUtente->nome</li>"
                    . "<li class=\"list-group-item\"><i class=\"fa fa-user\" aria-hidden=\"true\"></i> $oggUtente->cognome</li>"
                    . "<li class=\"list-group-item\"><i class=\"fa fa-user\" aria-hidden=\"true\"></i> $oggUtente->username</li>"
                    . "<li class=\"list-group-item\"><i class=\"fa fa-birthday-cake\" aria-hidden=\"true\"></i> $oggUtente->data_n</li>"
                    . "<li class=\"list-group-item\"><i class=\"fa fa-building\" aria-hidden=\"true\"></i> $oggUtente->luogo_nascita</li>";
                if($oggUtente->sesso != NULL) {
                    if (strcmp($oggUtente->sesso, "M") == 0) {
                        echo "<li class=\"list-group-item\"><i class=\"fa fa-male\" aria-hidden=\"true\"></i> Maschio</li>";
                    } else {
                        echo "<li class=\"list-group-item\"><i class=\"fa fa-female\" aria-hidden=\"true\"></i> Femmina</li>";
                    }
                } else{
                    echo "<li class=\"list-group-item\"><i class=\"fa fa-male\" aria-hidden=\"true\"></i> </li>";
                }
                echo "<li class=\"list-group-item\"><i class=\"fa fa-home\" aria-hidden=\"true\"></i> $oggUtente->residenza</li>"
                    . "<li class=\"list-group-item\"><i class=\"fa fa-envelope\" aria-hidden=\"true\"></i> $oggUtente->mail</li>"
                    . "<li class=\"list-group-item\"><i class=\"fa fa-phone\" aria-hidden=\"true\"></i> $oggUtente->tel</li>"
                    . "</ul>"
                    . "</div>";

                echo "</div>"
                    . "</div>"
                    . "<div class=\"tab-pane fade\" id=\"change\">"
                        ."<div class='row'>"
                            ."<div class='col-lg-8 col-lg-offset-2 col-md-6 col-md-offset-3 col-sm-12 col-xs-12'>"
                                ."<br>"
                                ."<div class=\"panel panel-primary\">"
                                ."<div class=\"panel-body\">"
                                    ."<form method='post' action='metodi/modifica_profilo.php' enctype=\"multipart/form-data\">"
                                        ."<div class=\"form-group\">"
                                          ."<label for=\"email\">Email:</label>"
                                          ."<input type=\"text\" name='email' value='$oggUtente->mail' class=\"form-control\" id=\"email\">"
                                        ."</div>"
                                        ."<div class=\"form-group\">"
                                            ."<label for=\"tel\">Telefono:</label>"
                                            ."<input type=\"text\" name='tel' value='$oggUtente->tel' class=\"form-control\" id=\"tel\">"
                                        ."</div>"
                                        ."<div class=\"form-group\">"
                                            ."<label for=\"file\">Immagine Profilo:</label>"
                                            ."<input type='file' name='foto_profilo' id='file' class='form-control'>"
                                        ."</div>"
                                        ."<div class=\"form-group\">"
                                            ."<div class='row'>"
                                                ."<div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>"
                                                    ."<button class='btn btn-success btn-block' type='submit'>Modifica</button>"
                                                ."</div>"
                                                ."<div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>"
                                                    ."<button class='btn btn-danger btn-block' type='reset'>Reset</button>"
                                                ."</div>"
                                            ."</div>"
                                        ."</div>"
                                    ."</form>"
                                ."</div>"
                                ."</div>"
                            ."</div>"
                        ."</div>"
                    . "</div>"
                    . "<div class=\"tab-pane fade\" id=\"profile\">"
                        ."<div class='row'>"
                            ."<div class='col-lg-8 col-lg-offset-2 col-md-6 col-md-offset-3 col-sm-12 col-xs-12'>"
                                ."<br>"
                                ."<div class=\"panel panel-primary\">"
                                    ."<div class=\"panel-body\">"
                                        ."<form method='post' id='Fpwd' action='metodi/Modifica_password.php'>"
                                            ."<div class=\"form-group\">"
                                                ."<label for=\"pwd_p\">Password Attuale:</label>"
                                                ."<input type=\"password\" name='attuale' class=\"form-control\" id=\"pwd_p\">"
                                            ."</div>"
                                            ."<div class=\"form-group\">"
                                                ."<label for=\"pwd_n\">Nuova Password:</label>"
                                                ."<input type=\"password\" name='nuova' class=\"form-control\" id=\"pwd_n\">"
                                            ."</div>"
                                            ."<div class=\"form-group\">"
                                                ."<label for=\"pwd_c\">Conferma Password:</label>"
                                                ."<input type=\"password\" name='conferma' class=\"form-control\" id=\"pwd_c\">"
                                            ."</div>"
                                            ."<div class=\"form-group\">"
                                                ."<div class='row'>"
                                                    ."<div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>"
                                                        ."<button class='btn btn-success btn-block' type='button' onclick='submit_f()'>Modifica Password</button>"
                                                    ."</div>"
                                                    ."<div class='col-lg-6 col-md-6 col-sm-6 col-xs-6'>"
                                                        ."<button class='btn btn-danger btn-block' type='button' onclick='reset_f();'>Reset</button>"
                                                    ."</div>"
                                                ."</div>"
                                            ."</div>"
                                        ."</form>"
                                    ."</div>"
                                ."</div>"
                            ."</div>"
                        ."</div>"
                    . "</div>"
                . "</div>"
                ?>
            </div>
        </div>
    </div>
    <?php
    controlloDimensione();
    ?>
</body>
</html>