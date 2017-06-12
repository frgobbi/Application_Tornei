<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 09/03/2017
 * Time: 20:44
 */
include "../../connessione.php";
try {
    $giorno = $connessione->query("SELECT * FROM giorno WHERE chiuso = 0")->fetch(PDO::FETCH_OBJ);
    $ogg_P= $connessione->query("SELECT SUM(prezzo) as Totale FROM `ordine_p` INNER JOIN prodotto ON ordine_p.id_prodotto = prodotto.id_prodotto WHERE id_giorno = '$giorno->id_giorno'")->fetch(PDO::FETCH_OBJ);
    $ogg_v = $connessione->query("SELECT SUM(varie) AS TotaleVarie FROM ordine_v WHERE id_giorno = '$giorno->id_giorno'")->fetch(PDO::FETCH_OBJ);
    $ogg_PC= $connessione->query("SELECT SUM(prezzo) as Totale FROM `ordine_p` INNER JOIN prodotto ON ordine_p.id_prodotto = prodotto.id_prodotto WHERE id_giorno = '$giorno->id_giorno' AND credito = 1")->fetch(PDO::FETCH_OBJ);
    $ogg_vC = $connessione->query("SELECT SUM(varie) AS TotaleVarie FROM ordine_v WHERE id_giorno = '$giorno->id_giorno' AND credito = 1")->fetch(PDO::FETCH_OBJ);
    $sql = "SELECT id_giorno, num_ordine, ora FROM ordine_p WHERE ordine_p.id_giorno = '$giorno->id_giorno' "
          ."UNION "
          ."SELECT id_giorno, num_ordine, ora FROM ordine_v WHERE ordine_v.id_giorno = '$giorno->id_giorno'"
          ."ORDER BY(num_ordine) DESC";
    
        $incasso = 0;
        $incasso = floatval($incasso)+floatval($ogg_P->Totale);
        $incasso = floatval($incasso)+floatval($ogg_v->TotaleVarie);

        $incassoC = 0;
        $incassoC = floatval($incassoC)+floatval($ogg_PC->Totale);
        $incassoC = floatval($incassoC)+floatval($ogg_vC->TotaleVarie);

    echo "{";
        echo "\"id_giorno\":".$giorno->id_giorno.",";
        echo "\"incasso\": $incasso,";
        echo "\"incassoC\": $incassoC,";
        echo "\"id_ord\":[0";
        foreach ($connessione->query($sql) as $row){
            echo ",".$row['num_ordine'];
        }
        echo "],";
        echo "\"ora_ord\":[0";
        foreach ($connessione->query($sql) as $row){
            echo ",\"".$row['ora']."\"";
        }
        echo "]";

    echo "}";
}catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;