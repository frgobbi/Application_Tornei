<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 30/11/2016
 * Time: 18:47
 */
session_start();
$utente = $_SESSION['username'];
$pwd_precedente = filter_input(INPUT_POST, "attuale",FILTER_SANITIZE_STRING);
$pwd_new = filter_input(INPUT_POST,"nuova",FILTER_SANITIZE_STRING);
$esito = 0;
include "../../connessione.php";
try{
   $oggUtente = $connessione->query("SELECT * FROM utente WHERE username = '$utente'")->fetch(PDO::FETCH_OBJ);
} catch (PDOException $e){
    echo "error: ".$e->getMessage();
}

if(password_verify($pwd_precedente,$oggUtente->pass)){
        $pwd = password_hash($pwd_new, PASSWORD_BCRYPT);
        try{
            $oggUtente = $connessione->exec("UPDATE utente SET pass = '$pwd' WHERE username = '$utente'");
        } catch (PDOException $e){
            echo "error: ".$e->getMessage();
            $esito = 1;
        }
} else {
    $esito = 2;
}
$connessione = null;
echo $esito;