<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 08/02/2017
 * Time: 12:48
 */
$id_cartellino = filter_input(INPUT_GET,"id_cartellino",FILTER_SANITIZE_STRING);
include "../../connessione.php";
try{
    $connessione->exec("DELETE FROM `info_tempo` WHERE id_info = '$id_cartellino'");
    echo "1";
}catch(PDOException $e){
    echo "0";
}
$connessione = null;