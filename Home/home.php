<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 29/11/2016
 * Time: 19:05
 */
session_start();
if (!$_SESSION['login']) {
    header("Location:../index.php");
}
include "../connessione.php";
try {
    $utente = $_SESSION['username'];
    $oggU = $connessione->query("SELECT * FROM utente WHERE username ='$utente'")->fetch(PDO::FETCH_OBJ);
    if ($oggU->id_cat == 4) {
        if ($oggU->mail != NULL) {
            if (strcmp($oggU->mail, "") == 0) {
                echo "<script type='text/javascript'>window.location.href='Aggiungi_mail.php'</script>";
            }
        } else {
            echo "<script type='text/javascript'>window.location.href='Aggiungi_mail.php'</script>";
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
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
    navLogin();
    ?>
    <div id="page-wrapper">
        <div style="padding-top: 30px; " class="row">
            <?php
            include "../connessione.php";
            try {
                $cat = $_SESSION['tipo_utente'];
                foreach ($connessione->query("SELECT `nome_funzione`, `src`,`icona`,`colore`  FROM funzioni INNER JOIN funzioni_cat_utente ON funzioni.id_funzione = funzioni_cat_utente.id_funzione WHERE id_cat_utente = $cat AND funzioni_cat_utente.abilitato = 1") as $row) {
                    $src = $row['src'];
                    $n_funzione = $row['nome_funzione'];
                    $icona = $row['icona'];
                    $colore = $row['colore'];
                    echo "<div class=\"col-lg-3 col-md-6\">"
                        . "<a href=\"../$src\">"
                        . "<div class=\"panel panel-$colore\">"
                        . "<div class=\"panel-heading\">"
                        . "<div class=\"row\">"
                        . "<div class=\"col-xs-3\">"
                        . "<i class=\"fa $icona fa-5x\" aria-hidden=\"true\"></i>"
                        . "</div>"
                        . "<div class=\"col-xs-9 text-right\">"
                        . "<h3>$n_funzione</h3>"
                        . "</div>"
                        . "</div>"
                        . "</div>"
                        . "<div class=\"panel-footer\">"
                        . "<span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>"
                        . "<div class=\"clearfix\"></div>"
                        . "</div>"
                        . "</div>"
                        . "</a>"
                        . "</div>";
                }
                echo "<div class=\"col-lg-3 col-md-6\">"
                    . "<a href=\"../Utente/Profilo.php\">"
                    . "<div class=\"panel panel-primary\">"
                    . "<div class=\"panel-heading\">"
                    . "<div class=\"row\">"
                    . "<div class=\"col-xs-3\">"
                    . "<i class=\"fa fa-user fa-5x\" aria-hidden=\"true\"></i>"
                    . "</div>"
                    . "<div class=\"col-xs-9 text-right\">"
                    . "<h3>My Profile</h3>"
                    . "</div>"
                    . "</div>"
                    . "</div>"
                    . "<div class=\"panel-footer\">"
                    . "<span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>"
                    . "<div class=\"clearfix\"></div>"
                    . "</div>"
                    . "</div>"
                    . "</a>"
                    . "</div>";
            } catch (PDOException $e) {
                echo "error: " . $e->getMessage();
            }
            $connessione = null;
            
            controlloDimensione();
            ?>
        </div>
    </div>
</div>
</body>
</html>




