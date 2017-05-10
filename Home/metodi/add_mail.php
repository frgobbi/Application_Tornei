<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 10/05/2017
 * Time: 09:01
 */
$utente = filter_input(INPUT_GET,"username",FILTER_SANITIZE_STRING);
$mail_u = filter_input(INPUT_POST,"email",FILTER_SANITIZE_STRING);
include "../../connessione.php";
try{
    $connessione->exec("UPDATE `utente` SET `mail` = '$mail_u' WHERE `utente`.`username` = '$utente'");
} catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;
echo "<script type='text/javascript'>window.location.href='../home.php'</script>";