<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html>
    <head>
        <?php
        include '../Componenti_Base/Head.php';
        LibrerieUnLog()
        ?>
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
                                <form  method="post" action="metodi/Iscrizione.php">
                                    <div class="form-group">
                                        <label for="nomeUtente" class="control-label">Nome: </label>
                                        <input type="text" class="form-control" id="nome_utente" name="nome_utente" placeholder="Nome" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cognome_utente" class="control-label">Cognome: </label>
                                        <input type="text" class="form-control" id="cognome_utente" name="cognome_utente" placeholder="Nome" required>
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


