<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 09/05/2017
 * Time: 21:42
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
    </script>
</head>
<body>
<div id="wrapper">
    <?php
    require '../Componenti_Base/Nav-SideBar.php';
    navNotMail();
    ?>
    <div id="page-wrapper">
        <div style="padding-top: 30px; " class="row">
            <div class="col-lg-12">
                <div class="alert alert-info">
                    <strong>Attenzione!!</strong> Per poter utilizzare l'applicazione devi aver inserito la tua email!
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-2 col-sm-12 col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <?php
                            $username = $_SESSION['username'];
                            echo "<form method='post' action='metodi/add_mail.php?username=$username'>";
                            echo "<div class=\"form-group\">"
                                    ."<label for=\"email\">Email:</label>"
                                    ."<input type=\"email\" class=\"form-control\" id=\"email\" name='email' required placeholder='email'>"
                                ."</div>";
                            echo "<div class=\"form-group\">"
                                    ."<button type=\"submit\" class=\"btn btn-primary btn-block\">Invia</button>"
                                ."</div>";
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>




