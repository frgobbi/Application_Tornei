<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 20/01/2017
 * Time: 20:06
 */
$id_partita = filter_input(INPUT_GET,"id_partita",FILTER_SANITIZE_STRING);
$id_tempo = filter_input(INPUT_GET,"tempo",FILTER_SANITIZE_STRING);
$squadre = array();
include "../../connessione.php";
try{
    foreach ($connessione->query("SELECT * FROM `sq_partita` INNER JOIN squadra ON squadra.id_sq = sq_partita.id_sq WHERE id_partita = '$id_partita'") as $row ){
        $sq = $row['id_sq'];
        $squadre[] = array($row['id_sq'], $row['nome_sq']);
        $connessione->exec("INSERT INTO `sq_tempo`(`id_sq`, `id_partita`, `id_tempo`) VALUES ('$sq','$id_partita','$id_tempo')");
        $oggTempo = $connessione->query("SELECT * FROM `tempo` WHERE id_tempo = '$id_tempo'")->fetch(PDO::FETCH_OBJ);
    }
    echo "{";
        echo"\"esito\":1,";
        echo"\"nome_tempo\":\"".$oggTempo->descrizione."\",";
        echo"\"id_tempo\":".$id_tempo.",";
        echo"\"id_sq1\":\"".$squadre[0][0]."\",";
        echo"\"nome_sq1\":\"".$squadre[0][1]."\",";
        echo"\"id_sq2\":\"".$squadre[1][0]."\",";
        echo"\"nome_sq2\":\"".$squadre[1][1]."\",";
        $id_sq1 = $squadre[0][0];
        $id_sq2 = $squadre[1][0];
    echo "\"sq1\" : {";
    echo "\"id_giocatori\":[\"0\"";
    foreach ($connessione->query("SELECT * FROM `utente` INNER JOIN sq_utente ON utente.username = sq_utente.username WHERE id_sq = '$id_sq1'") as $row){
        echo ","."\"".$row['username']."\"";
    }
    echo "],";
    echo "\"nomi_giocatori\":[\"0\"";
    foreach ($connessione->query("SELECT * FROM `utente` INNER JOIN sq_utente ON utente.username = sq_utente.username WHERE id_sq = '$id_sq1'") as $row){
        $nome = "\"".$row['nome']." ".$row['cognome']."\"";
        echo ",".$nome;
    }
    echo "]";
    echo "},";
    echo "\"sq2\" : {";
    echo "\"id_giocatori\":[\"0\"";
    foreach ($connessione->query("SELECT * FROM `utente` INNER JOIN sq_utente ON utente.username = sq_utente.username WHERE id_sq = '$id_sq2'") as $row){
        echo ","."\"".$row['username']."\"";
    }
    echo "],";
    echo "\"nomi_giocatori\":[\"0\"";
    foreach ($connessione->query("SELECT * FROM `utente` INNER JOIN sq_utente ON utente.username = sq_utente.username WHERE id_sq = '$id_sq2'") as $row){
        $nome = "\"".$row['nome']." ".$row['cognome']."\"";
        echo ",".$nome;
    }
    echo "]";
    echo "}";
} catch (PDOException $e){
    echo "errore: ".$e->getMessage();
}
$connessione = null;
echo "}";