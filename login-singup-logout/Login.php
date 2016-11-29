<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 29/11/2016
 * Time: 15:10
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
                    <div class="panel-heading">Login</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="post" action="metodi/accesso.php">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="username">Username:</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="username" name="username" placeholder="Username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="pwd">Password:</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Password">
                                </div>
                            </div>
                            <!--<div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div class="checkbox">
                                        <label><input type="checkbox"> Remember me</label>
                                    </div>
                                </div>
                            </div>-->
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-4 col-md-4">
                                    <button type="submit" class="btn btn-block btn-primary">Accedi</button>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-4 col-md-4">
                                    <button type="button" onclick="" class="btn btn-link">Hai problemi con l'accesso?</button>
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



