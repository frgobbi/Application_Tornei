<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 29/11/2016
 * Time: 15:25
 */
session_start();
$esito = 0;
include "../../connessione.php";
$username = filter_input(INPUT_POST, "user", FILTER_SANITIZE_STRING);
$pass = filter_input(INPUT_POST, "pwd", FILTER_SANITIZE_STRING);
try{
    $utente = $connessione->query("SELECT * FROM `utente` WHERE `username` = '$username'")->fetch(PDO::FETCH_OBJ);
   if(!$utente){
       $esito = 1;
   } else {
       if(password_verify($pass,$utente->pass)){
           $_SESSION['login'] = TRUE;
           $_SESSION['tipo_utente'] = $utente->id_cat;
           $_SESSION['nome_utente'] = $utente->nome." ".$utente->cognome;
           $_SESSION['username'] = $utente->username;
       } else{
           $esito = 1;
       }
   }
} catch (PDOException $e){
    echo "error:".$e;
    $esito = 1;
}
$connessione = null;
echo $esito;