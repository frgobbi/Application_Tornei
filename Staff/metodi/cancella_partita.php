<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 15/02/2017
 * Time: 15:10
 */

$id_p = filter_input(INPUT_GET,"id_partita",FILTER_SANITIZE_STRING);
include "../../connessione.php";
$esito = 1;
try{
    $connessione->exec("DELETE FROM `info_tempo` WHERE id_partita ='$id_p'");
    $connessione->exec("DELETE FROM `sq_tempo` WHERE `id_partita` = '$id_p'");
    $connessione->exec("DELETE FROM `sq_partita` WHERE `id_partita` ='$id_p'");
    $connessione->exec("DELETE FROM `partita` WHERE `id_partita` = '$id_p'");

}catch (PDOException $e){
    $esito = 0;
}
$connessione = null;
echo $esito;