<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 06/05/2017
 * Time: 15:18
 */
$id_sq = filter_input(INPUT_GET,"id_sq",FILTER_SANITIZE_STRING);
include "../../connessione.php";
try{
    $sqlMake = "SELECT nome, cognome, utente.username, data_nascita, luogo_nascita, codice_fiscale, residenza FROM utente "
                ."INNER JOIN sq_utente ON utente.username = sq_utente.username"
                ."WHERE id_sq = '$id_sq'";
    $sqlL = "SELECT username FROM `sq_utente` WHERE id_sq = '$id_sq' AND make = '1'";
    $oggM = $connessione->query($sqlMake)->fetch(PDO::FETCH_OBJ);
    echo "{";
    echo "\"usernameMake\": \"$oggM->username\"";
    echo "}";
}catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;