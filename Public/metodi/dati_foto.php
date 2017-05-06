<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 05/05/2017
 * Time: 14:18
 */
$id_cartella = filter_input(INPUT_GET,"id_cartella",FILTER_SANITIZE_STRING);
include "../../connessione.php";
try{
    $oggC = $connessione->query("SELECT * FROM `cartelle_f` WHERE id_c = '$id_cartella'")->fetch(PDO::FETCH_OBJ);
    $array_foto = array();
    foreach ($connessione->query("SELECT * FROM foto WHERE id_c = '$id_cartella'") as $row){
        $array_foto[] = $row['nome_foto'];
    }
    echo "{";
    echo "\"nome_cartella\":\"$oggC->nome_cartella\",";
    echo "\"foto\":[";
        for($i=0;$i<count($array_foto);$i++){
            if($i==0){
                echo "\"$array_foto[$i]\"";
            } else{
                echo ",\"$array_foto[$i]\"";
            }
        }
    echo"]";
    echo "}";
} catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;