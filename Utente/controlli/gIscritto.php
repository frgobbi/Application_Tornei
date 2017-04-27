<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 16/04/2017
 * Time: 16:38
 */
$id_t = filter_input(INPUT_GET,"id_t",FILTER_SANITIZE_STRING);
$cod = filter_input(INPUT_GET,"cod",FILTER_SANITIZE_STRING);
include "../../connessione.php";
try{
    $sql = "SELECT * FROM `sq_utente` "
        ."INNER JOIN utente ON sq_utente.username = utente.username "
        ."INNER JOIN squadra ON sq_utente.id_sq = squadra.id_sq "
        ."WHERE utente.codice_fiscale = '$cod' AND squadra.id_torneo = '$id_t'";
    $righe = $connessione->query($sql)->rowCount();
    echo $righe;
} catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;