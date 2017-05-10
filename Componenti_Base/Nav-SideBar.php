<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function navIndex()
{
    ?>
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <!--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>-->
            <a class="navbar-brand" href="index.php">Tornei</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <li>
                <a href="login-singup-logout/Sing_up.php">
                    <i class="fa fa-user" aria-hidden="true"></i> Sing Up
                </a>
            </li>
            <li>
                <a href="login-singup-logout/Login.php">
                    <i class="fa fa-sign-in" aria-hidden="true"></i> Login
                </a>
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->
    </nav>
    <?php
}

function navUnLog()
{
    ?>
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <!--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>-->
            <a class="navbar-brand" href="../index.php">Tornei</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <li>
                <a href="../login-singup-logout/Sing_up.php">
                    <i class="fa fa-user" aria-hidden="true"></i> Sing Up
                </a>
            </li>
            <li>
                <a href="../login-singup-logout/Login.php">
                    <i class="fa fa-sign-in" aria-hidden="true"></i> Login
                </a>
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->
    </nav>
    <?php
}

function sideBar()
{
    //tolgo eventuali connessioni non chiuse;
    $connessione = null;
    $utente = $_SESSION['username'];
    include "../connessione.php";
    try {
        $oggUtente = $connessione->query("SELECT * FROM utente WHERE username = '$utente'")->fetch(PDO::FETCH_OBJ);


    echo "<div class=\"navbar-default sidebar\" role=\"navigation\">"
        . "<div class=\"sidebar-nav navbar-collapse\">"
        . "<ul class=\"nav\" id=\"side-menu\">"
        . "<li class=\"text-center h5\">"
        . "<a href = \"../Utente/Profilo.php\">"
        . "<img src=\"../Immagini/Immagini_Profilo/$oggUtente->foto\" class=\"img-rounded img-thumbnail img\" width=\"35px\"/>&nbsp; $oggUtente->nome $oggUtente->cognome"
        . "</a>"
        . "</li>"

        . "<li>"
        . "<a href=\"../Home/home.php\"><i class=\"fa fa-dashboard fa-fw\"></i> Dashboard</a>"
        . "</li>";

            foreach ($connessione->query("SELECT `nome_funzione`, `src`,`icona` FROM funzioni INNER JOIN funzioni_cat_utente ON funzioni.id_funzione = funzioni_cat_utente.id_funzione WHERE id_cat_utente = $oggUtente->id_cat") as $row){
                $src = $row['src'];
                $n_funzione = $row['nome_funzione'];
                $icona = $row['icona'];
                echo "<li>"
                . "<a href=\"../$src\"><i class=\"fa $icona fa-fw\"></i> $n_funzione</a>"
                . "</li>";
            }

        echo "<li>"
        . "<a href=\"../Utente/Profilo.php\"><i class=\"fa fa-user\" aria-hidden=\"true\"></i> My Profile</a>"
        . "</li>"
        . "</ul>"
        . "</div>"
        . "</div>";

    } catch (PDOException $e) {
        echo "error: " . $e->getMessage();
    }
    $connessione = null;
}

function navLogin()
{
    ?>
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../home/home.php">Tornei</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <li>
                <a href="../login-singup-logout/Logout.php">
                    <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
                </a>
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->
        <?php
        sideBar();
        ?>
    </nav>
    <?php
}


function navNotMail()
{
    ?>
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../home/home.php">Tornei</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <li>
                <a href="../login-singup-logout/Logout.php">
                    <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
                </a>
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->
        <?php
        sideBarNotMail();
        ?>
    </nav>
    <?php
}

function sideBarNotMail()
{
    //tolgo eventuali connessioni non chiuse;
    $connessione = null;
    $utente = $_SESSION['username'];
    include "../connessione.php";
    try {
        $oggUtente = $connessione->query("SELECT * FROM utente WHERE username = '$utente'")->fetch(PDO::FETCH_OBJ);


        echo "<div class=\"navbar-default sidebar\" role=\"navigation\">"
            . "<div class=\"sidebar-nav navbar-collapse\">"
            . "<ul class=\"nav\" id=\"side-menu\">"
            . "<li class=\"text-center h5\">"
            . "<a href = \"#\">"
            . "<img src=\"../Immagini/Immagini_Profilo/$oggUtente->foto\" class=\"img-rounded img-thumbnail img\" width=\"35px\"/>&nbsp; $oggUtente->nome $oggUtente->cognome"
            . "</a>"
            . "</li>"

            . "<li>"
            . "<a href=\"../Home/home.php\"><i class=\"fa fa-dashboard fa-fw\"></i> Dashboard</a>"
            . "</li>";

        foreach ($connessione->query("SELECT `nome_funzione`, `src`,`icona` FROM funzioni INNER JOIN funzioni_cat_utente ON funzioni.id_funzione = funzioni_cat_utente.id_funzione WHERE id_cat_utente = $oggUtente->id_cat") as $row){
            $src = $row['src'];
            $n_funzione = $row['nome_funzione'];
            $icona = $row['icona'];
            echo "<li>"
                . "<a href=\"#\"><i class=\"fa $icona fa-fw\"></i> $n_funzione</a>"
                . "</li>";
        }

        echo "<li>"
            . "<a href=\"#\"><i class=\"fa fa-user\" aria-hidden=\"true\"></i> My Profile</a>"
            . "</li>"
            . "</ul>"
            . "</div>"
            . "</div>";

    } catch (PDOException $e) {
        echo "error: " . $e->getMessage();
    }
    $connessione = null;
}


