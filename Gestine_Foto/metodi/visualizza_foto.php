<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 03/04/2017
 * Time: 13:27
 */
$cartella = filter_input(INPUT_GET, "cartella",FILTER_SANITIZE_STRING);
//echo $cartella;
include "../../connessione.php";
try{
    $oggC = $connessione->query("SELECT `id_c`, `nome_cartella`, `colore` FROM `cartelle_f` WHERE id_c = '$cartella'")->fetch(PDO::FETCH_OBJ);
    echo "{";
    echo "\"id_c\":".$oggC->id_c.",";
    echo "\"nome_c\":\"".$oggC->nome_cartella."\",";
    echo "\"id_f\": [0";
    foreach ($connessione->query("SELECT `id_foto`, `nome_foto`, `id_c` FROM `foto` WHERE id_c = '$oggC->id_c'") as $row){
        $file = $row['id_foto'];
        echo ",".$file;
    }
    echo "],";

    echo "\"nome_f\": [0";
    foreach ($connessione->query("SELECT `id_foto`, `nome_foto`, `id_c` FROM `foto` WHERE id_c = '$oggC->id_c'") as $row){
        $file = $row['nome_foto'];
        echo ",\"".$file."\"";
    }
    echo "]";

    echo "}";
}catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;