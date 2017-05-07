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
    $sqlMake = "SELECT username FROM `sq_utente` WHERE id_sq = '$id_sq' AND make = '1'";
    $sqlL = "SELECT nome, cognome, utente.username, DATE_FORMAT(data_nascita,'%d-%m-%Y') AS data , luogo_nascita, codice_fiscale, residenza FROM utente "
        ."INNER JOIN sq_utente ON utente.username = sq_utente.username "
        ."WHERE id_sq = '$id_sq'";
    $oggM = $connessione->query($sqlMake)->fetch(PDO::FETCH_OBJ);
    echo "{";
        echo "\"usernameMake\": \"$oggM->username\",";
        echo "\"nome_g\": [0";
            foreach ($connessione->query($sqlL) as $row){
                $var = $row['nome'];
                echo ",\"$var\"";
            }
        echo "],";
        echo "\"cognome_g\": [0";
        foreach ($connessione->query($sqlL) as $row){
            $var = $row['cognome'];
            echo ",\"$var\"";
        }
        echo "],";
        echo "\"username_g\": [0";
        foreach ($connessione->query($sqlL) as $row){
            $var = $row['username'];
            echo ",\"$var\"";
        }
        echo "],";
        echo "\"data_g\": [0";
        foreach ($connessione->query($sqlL) as $row){
            $var = $row['data'];
            echo ",\"$var\"";
        }
        echo "],";
        echo "\"luogo_g\": [0";
        foreach ($connessione->query($sqlL) as $row){
            $var = $row['luogo_nascita'];
            echo ",\"$var\"";
        }
        echo "],";
        echo "\"cod_g\": [0";
        foreach ($connessione->query($sqlL) as $row){
            $var = $row['codice_fiscale'];
            echo ",\"$var\"";
        }
        echo "],";
        echo "\"res_g\": [0";
        foreach ($connessione->query($sqlL) as $row){
            $var = $row['residenza'];
            echo ",\"$var\"";
        }
        echo "]";
    echo "}";
}catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;