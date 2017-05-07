<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 07/05/2017
 * Time: 14:02
 */
$id_sq = filter_input(INPUT_GET,"id_sq",FILTER_SANITIZE_STRING);
include "../../connessione.php";
$sqlGol = "SELECT nome, cognome, COUNT(*) AS gol FROM `info_tempo` "
    ."INNER JOIN sq_utente ON sq_utente.id_sq_utente = info_tempo.id_sq_utente "
    ."INNER JOIN utente ON utente.username = sq_utente.username "
    ."WHERE id_sq = '$id_sq' AND punto = 1 GROUP BY(utente.username) ORDER BY (gol) DESC";
$sqlCartG = "SELECT nome, cognome, COUNT(*) AS cart FROM `info_tempo` "
    ."INNER JOIN sq_utente ON sq_utente.id_sq_utente = info_tempo.id_sq_utente "
    ."INNER JOIN utente ON utente.username = sq_utente.username "
    ."WHERE id_sq = '$id_sq' AND cartellino_giallo = 1 GROUP BY(utente.username) ORDER BY (cart) DESC";
$sqlCartR = "SELECT nome, cognome, COUNT(*) AS cart FROM `info_tempo` "
    ."INNER JOIN sq_utente ON sq_utente.id_sq_utente = info_tempo.id_sq_utente "
    ."INNER JOIN utente ON utente.username = sq_utente.username "
    ."WHERE id_sq = '$id_sq' AND cartellino_rosso = 1 GROUP BY(utente.username) ORDER BY (cart) DESC";
try{
    echo "{";
        echo "\"gol\":{";
            echo "\"nome\":[0";
            foreach ($connessione->query($sqlGol) as $row){
                $var = $row['nome'];
                echo ",\"$var\"";
            }
            echo "],";
            echo "\"cognome\":[0";
            foreach ($connessione->query($sqlGol) as $row){
                $var = $row['cognome'];
                echo ",\"$var\"";
            }
            echo "],";
            echo "\"num_gol\":[0";
            foreach ($connessione->query($sqlGol) as $row){
                $var = $row['gol'];
                echo ",\"$var\"";
            }
            echo "]";
        echo "},";

        echo "\"cartG\":{";
            echo "\"nome\":[0";
            foreach ($connessione->query($sqlCartG) as $row){
                $var = $row['nome'];
                echo ",\"$var\"";
            }
            echo "],";
            echo "\"cognome\":[0";
            foreach ($connessione->query($sqlCartG) as $row){
                $var = $row['cognome'];
                echo ",\"$var\"";
            }
            echo "],";
            echo "\"num_G\":[0";
            foreach ($connessione->query($sqlCartG) as $row){
                $var = $row['cart'];
                echo ",\"$var\"";
            }
            echo "]";
        echo "},";
    
        echo "\"cartR\":{";
            echo "\"nome\":[0";
            foreach ($connessione->query($sqlCartR) as $row){
                $var = $row['nome'];
                echo ",\"$var\"";
            }
            echo "],";
            echo "\"cognome\":[0";
            foreach ($connessione->query($sqlCartR) as $row){
                $var = $row['cognome'];
                echo ",\"$var\"";
            }
            echo "],";
            echo "\"num_R\":[0";
            foreach ($connessione->query($sqlCartR) as $row){
                $var = $row['cart'];
                echo ",\"$var\"";
            }
            echo "]";
        echo "}";
    echo "}";
} catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;