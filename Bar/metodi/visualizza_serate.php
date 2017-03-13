<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 05/03/2017
 * Time: 18:59
 */
include "../../connessione.php";
try {
    echo "{";
    echo "\"id\": [0";
    foreach ($connessione->query("SELECT id_giorno, DATE_FORMAT(data_g,'%d-%m-%Y') AS data, chiuso FROM `giorno` WHERE  1") as $row) {
        $id_giorno = $row['id_giorno'];
        echo ",".$id_giorno;
    }
    echo "],";

    echo "\"data\": [0";
    foreach ($connessione->query("SELECT id_giorno, DATE_FORMAT(data_g,'%d-%m-%Y') AS data, chiuso FROM `giorno` WHERE  1") as $row) {
        $data = $row['data'];
        echo ",\"".$data."\"";
    }
    echo "],";

    echo "\"incasso\": [0";
    foreach ($connessione->query("SELECT id_giorno, DATE_FORMAT(data_g,'%d-%m-%Y') AS data, chiuso FROM `giorno` WHERE  1") as $row) {
        $id_giorno = $row['id_giorno'];
        $incasso = 0;
            $ogg_P= $connessione->query("SELECT SUM(prezzo) as Totale FROM `ordine_p` INNER JOIN prodotto ON ordine_p.id_prodotto = prodotto.id_prodotto WHERE id_giorno = '$id_giorno'")->fetch(PDO::FETCH_OBJ);
                $incasso = floatval($incasso)+floatval($ogg_P->Totale);
            $ogg_v = $connessione->query("SELECT SUM(varie) AS TotaleVarie FROM ordine_v WHERE id_giorno = '$id_giorno'")->fetch(PDO::FETCH_OBJ);
                $incasso = floatval($incasso)+floatval($ogg_v->TotaleVarie);
        echo",".$incasso;

    }
    echo "],";

    echo "\"chiuso\": [0";
    foreach ($connessione->query("SELECT id_giorno, DATE_FORMAT(data_g,'%d-%m-%Y') AS data, chiuso FROM `giorno` WHERE  1") as $row) {
        $data = $row['chiuso'];
        echo ",".$data;
    }
    echo "]";
    echo "}";
} catch (PDOException $e) {
    echo $e->getMessage();
}
$connessione = null;