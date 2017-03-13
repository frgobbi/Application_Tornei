<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 23/02/2017
 * Time: 15:12
 */
$user_utente = filter_input(INPUT_GET,"user",FILTER_SANITIZE_STRING);
$codice = filter_input(INPUT_POST,"codice",FILTER_SANITIZE_STRING);
include "../../connessione.php";
try{
    $connessione->exec("UPDATE `utente` SET `card`= '$codice' WHERE username = '$user_utente'");
}catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;
header("Location:../Bar.php");