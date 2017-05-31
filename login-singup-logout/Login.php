<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 29/11/2016
 * Time: 15:10
 */
?>
<html>
<head>
    <?php
    include '../Componenti_Base/Head.php';
    LibrerieUnLog()
    ?>
    <style type="text/css">
        #errore{
            display: none;
        }
        #warning{
            display: none;
        }
        #ruota{
            display: none;
        }
    </style>
    <script type="text/javascript">
        function tastoEnter() {
            var tasto = window.event.keyCode;
            if (tasto == 13) {
                accedi();
            }
        }
        function accedi() {
            $('#ruota').show();
            $(document).ready(function() {
                var user = $("#username").val();
                var pwd = $("#pwd").val();
                $.ajax({
                    type: "POST",
                    url: "metodi/accesso.php",
                    data: "user=" + user + "&pwd=" + pwd,
                    dataType: "html",
                    success: function(risposta)
                    {
                        console.log(risposta);
                        if(risposta==0){
                            $('#errore').hide();
                            $('#warning').hide();
                            window.location.href="../Home/home.php";
                        } else{
                            if(risposta==1) {
                                $('#errore').show();
                            }else {
                                $('#warning').show();
                            }
                        }
                        $('#ruota').hide();
                    },
                    error: function()
                    {
                        $('#ruota').hide();
                        alert("Chiamata fallita, si prega di riprovare...");
                    }
                });
            });
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
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3 col-md-4 col-md-offset-4 col-sm-12 col-sm-12">
                <br><br>
                <div class="panel panel-primary">
                    <div class="panel-heading">Login</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="post" action="metodi/accesso.php">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="username">Username:</label>
                                <div class="col-sm-10">
                                    <input type="text" autofocus class="form-control" id="username" name="username" placeholder="Username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="pwd">Password:</label>
                                <div class="col-sm-10">
                                    <input type="password" onkeyup="tastoEnter()" class="form-control" id="pwd" name="pwd" placeholder="Password">
                                </div>
                            </div>
                            <!--<div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div class="checkbox">
                                        <label><input type="checkbox"> Remember me</label>
                                    </div>
                                </div>
                            </div>-->
                            <div id="errore" class="alert alert-danger">
                                <strong>Errore!</strong> Username e/o Password errati!
                            </div>
                            <div id="warning" class="alert alert-warning">
                                <strong>Attenzione</strong> Questo account non è stato attivato. <br> controlla la tua mail
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-4 col-md-4">
                                    <button type="button" onclick="accedi()" class="btn btn-block btn-primary">Accedi <i id="ruota" class="fa fa-spinner fa-pulse fa-lg fa-fw"></i></button>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-4 col-md-4">
                                    <button type="button" onclick="window.location.href='Reimposta.php'" class="btn btn-link">Hai problemi con l'accesso?</button>
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