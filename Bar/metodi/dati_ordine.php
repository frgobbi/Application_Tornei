<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 11/03/2017
 * Time: 13:04
 */
$num_ord= filter_input(INPUT_GET,"id_ord",FILTER_SANITIZE_STRING);
$id_giorno = filter_input(INPUT_GET,"id_giorno",FILTER_SANITIZE_STRING);
$sql = "SELECT prodotto.nome_prodotto, COUNT(*) AS num, prezzo FROM `ordine_p` "
    ." INNER JOIN prodotto ON ordine_p.id_prodotto = prodotto.id_prodotto "
    ." WHERE id_giorno = '$id_giorno' AND num_ordine = '$num_ord' GROUP BY(ordine_p.id_prodotto)";
include "../../connessione.php";
try{
    echo "{";
        echo "\"desc_ord\": [0";
            foreach ($connessione->query($sql) as $row){
                $desc = $row['nome_prodotto'];
                echo ",\"$desc\"";
            }
            foreach ($connessione->query("SELECT varie FROM `ordine_v` WHERE id_giorno = '$id_giorno' AND num_ordine = '$num_ord'") as $row){
                echo ",\"Varie\"";
            }
        echo "],";

        echo "\"num_p\": [0";
            foreach ($connessione->query($sql) as $row){
                $num = $row['num'];
                echo ",$num";
            }
            foreach ($connessione->query("SELECT varie FROM `ordine_v` WHERE id_giorno = '$id_giorno' AND num_ordine = '$num_ord'") as $row){
                echo ",1";
            }
        echo "],";

        echo "\"prezzo\": [0";
            foreach ($connessione->query($sql) as $row){
                $prezzo = $row['prezzo'];
                echo ",$prezzo";
            }
            foreach ($connessione->query("SELECT varie FROM `ordine_v` WHERE id_giorno = '$id_giorno' AND num_ordine = '$num_ord'") as $row){
                $p = $row['varie'];
                echo ",$p";
            }
        echo "]";
    echo"}";
} catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;