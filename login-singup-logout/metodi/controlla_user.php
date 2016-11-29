<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 22/11/2016
 * Time: 09:58
 */
$nome_user = filter_input(INPUT_GET, "user", FILTER_SANITIZE_STRING);
$nome_user = strtolower($nome_user);
include "../../connessione.php";
try{
    $utenti = $connessione->query("SELECT * FROM `utente` WHERE `username` = '$nome_user'")->rowCount();
    echo $utenti;
}catch (PDOException $e){
    echo "errore: ".!$e->getMessage();
}
$connessione = null;
