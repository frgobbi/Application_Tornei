<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 03/05/2017
 * Time: 21:33
 */
?>
<html>
    <head>
        <?php
        include '../Componenti_Base/Head.php';
        LibrerieUnLog()
        ?>
<style type="text/css">
    .glyphicon{
        display: none;
    }
</style>
<script type="text/javascript">
    function controllaPass() {
        var pwd1 = $('#pwd1').val();
        var pwd2 = $('#pwd2').val();
        if(pwd1.localeCompare("")!=0) {
            if (pwd1.localeCompare(pwd2) != 0) {
                $('#labelpwd1').addClass('has-error has-feedback');
                $('#labelpwd2').addClass('has-error has-feedback');
                $('#labelpwd1').removeClass('has-success');
                $('#labelpwd2').removeClass('has-success');
                $('#x1').show();
                $('#x2').show();
                $('#v1').hide();
                $('#v2').hide();
            } else {
                $('#labelpwd1').removeClass('has-error');
                $('#labelpwd2').removeClass('has-error');
                $('#labelpwd1').addClass('has-success has-feedback');
                $('#labelpwd2').addClass('has-success has-feedback');
                $('#x1').hide();
                $('#x2').hide();
                $('#v1').show();
                $('#v2').show();
            }
        }
    }
    function changePass(username) {
        var pwd1 = $('#pwd1').val();
        var pwd2 = $('#pwd2').val();
        if(pwd1.localeCompare("")!=0) {
            if(pwd2.localeCompare("")!=0) {
                if (pwd1.localeCompare(pwd2) != 0) {
                    $(document).ready(function() {
                        $("#bottone").click(function(){
                            var nome = $("#nome").val();
                            var cognome = $("#cognome").val();
                            $.ajax({
                                type: "GET",
                                url: "metodi/changePassword.php",
                                data: "pwd="+pwd+"&user="+username,
                                dataType: "html",
                                success: function(risposta)
                                {
                                    if(risposta ==0) {
                                        $('#alertS').show();
                                        setTimeout(function(){window.location.href='../index.php'},5000);
                                    }
                                },
                                error: function()
                                {
                                    alert("Chiamata fallita, si prega di riprovare...");
                                }
                            });
                        });
                    });
                }
            }
        }
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
                    <div class="panel-heading">Modifica password</div>
                    <div class="panel-body">
                        <form>
                            <!-- has-error has-feedback -->
                            <div id="labelpwd1" class="form-group">
                                <label for="mail">Nuova password:</label>
                                <input type="password" id="pwd1" class="form-control" placeholder="Nuova Password">
                                <span id="x1" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                                <span id="v1" class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
                                <span id="inputError2Status" class="sr-only">(error)</span>
                            </div>

                            <div id="labelpwd2" class="form-group">
                                <label for="mail">Rinserisci nuova password:</label>
                                <input onblur="controllaPass()" type="password" id="pwd2" class="form-control" placeholder="Nuova Password">
                                <span id="x2" class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                                <span id="v2" class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
                                <span id="inputError2Status" class="sr-only">(error)</span>
                            </div>
                        <?php
                            echo "<div class=\"form-group\">"
                                ."<button type=\"button\" onclick=\"changePass($username)\" class=\"btn btn-primary btn-block\">Reimposta Password</button>"
                            ."</div>";
                        ?>
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
