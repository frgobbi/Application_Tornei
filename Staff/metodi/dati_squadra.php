<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 24/01/2017
 * Time: 18:21
 */
$id_squadra = filter_input(INPUT_GET,"id_sq",FILTER_SANITIZE_STRING);
include "../../connessione.php";
try{
    echo "{ \"id_giocatori\":[\"0\"";
    foreach ($connessione->query("SELECT * FROM `utente` INNER JOIN sq_utente ON utente.username = sq_utente.username WHERE id_sq = '$id_squadra'") as $row){
        echo ","."\"".$row['username']."\"";
    }
    echo "],";
    echo "\"nomi_giocatori\":[\"0\"";
    foreach ($connessione->query("SELECT * FROM `utente` INNER JOIN sq_utente ON utente.username = sq_utente.username WHERE id_sq = '$id_squadra'") as $row){
        $nome = "\"".$row['nome']." ".$row['cognome']."\"";
        echo ",".$nome;
    }
    echo "]}";
} catch (PDOException $e){
    echo "errore: ".$e->getMessage();
}
$connessione = null;