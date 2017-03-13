<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 23/02/2017
 * Time: 14:34
 */

$user_utente = filter_input(INPUT_GET,"user",FILTER_SANITIZE_STRING);
$credito = filter_input(INPUT_POST,"credito",FILTER_SANITIZE_STRING);
include "../../connessione.php";
try{
    $oggU =$connessione->query("SELECT * FROM `utente` WHERE username = '$user_utente'")->fetch(PDO::FETCH_OBJ);
    $nuovo_credito = doubleval($credito)+doubleval($oggU->saldo);
    $connessione->exec("UPDATE `utente` SET `saldo`= $nuovo_credito WHERE username = '$user_utente'");
}catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;
header("Location:../Bar.php");