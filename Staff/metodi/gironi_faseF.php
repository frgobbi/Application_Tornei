<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 29/03/2017
 * Time: 12:44
 */
include "../../connessione.php";
try{
    echo "{";
        echo "\"id_g\": [ 0";
        foreach ($connessione->query("SELECT * FROM `girone` WHERE id_girone > 9") as $row){
            echo ",".$row['id_girone'];
        }
        echo "],";

    echo "\"desc_g\": [ \"Elimina Squadra\"";
        foreach ($connessione->query("SELECT * FROM `girone` WHERE id_girone > 9") as $row){
            echo ",\"".$row['nome_girone']."\"";
        }
        echo "]";
    echo "}";
}catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;