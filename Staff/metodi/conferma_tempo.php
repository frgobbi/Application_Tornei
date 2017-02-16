<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 13/02/2017
 * Time: 19:08
 */
$gol = filter_input(INPUT_GET, "gol",FILTER_SANITIZE_STRING);
$sq = filter_input(INPUT_GET, "id_sq",FILTER_SANITIZE_STRING);
$tempo = filter_input(INPUT_GET, "id_tempo",FILTER_SANITIZE_STRING);
$partita = filter_input(INPUT_GET, "id_p",FILTER_SANITIZE_STRING);
$giocatori = array();
for($i=0;$i<$gol;$i++){
    $key ="g".$i;
    $giocatori[] = filter_input(INPUT_GET, $key,FILTER_SANITIZE_STRING);
}
$esito = 1;
include "../../connessione.php";
try{
    for($i=0; $i<$gol;$i++){
        $giocatore = $giocatori[$i];
        $ogg_g = $connessione->query("SELECT * FROM `sq_utente` WHERE `username` = '$giocatore' AND `id_sq` ='$sq'")->fetch(PDO::FETCH_OBJ);
        $sql_gol="INSERT INTO `info_tempo`(`id_info`, `id_sq_utente`, `id_tempo`, `id_partita`, `punto`, `cartellino_giallo`, `cartellino_rosso`)"
            ." VALUES (NULL,'$ogg_g->id_sq_utente','$tempo','$partita','1','0','0')";
        $connessione->exec($sql_gol);
    }

    $sql_conferma_t = "UPDATE `sq_tempo` SET `conclused`='1' WHERE `id_sq` = '$sq' AND `id_partita` = '$partita' AND `id_tempo`= '$tempo'";
    $connessione->exec($sql_conferma_t);
} catch (PDOException $e){
    $esito = 0;
}
$connessione = null;
echo $esito;

