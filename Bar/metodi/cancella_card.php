<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 02/03/2017
 * Time: 14:01
 */
$username = filter_input(INPUT_GET,"user",FILTER_SANITIZE_STRING);
include "../../connessione.php";
try{
    $connessione->exec("UPDATE `utente` SET `saldo` = '0' WHERE `utente`.`username` = '$username';");
    $connessione->exec("UPDATE `utente` SET `card` = NULL WHERE `utente`.`username` = '$username';");
} catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;
header("Location:../Bar.php");