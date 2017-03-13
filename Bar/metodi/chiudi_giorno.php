<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 05/03/2017
 * Time: 15:35
 */
$id_giorno = filter_input(INPUT_GET,"id_giorno",FILTER_SANITIZE_STRING);
$esito =1;
include "../../connessione.php";
try{
    $connessione->exec("UPDATE `giorno` SET `chiuso`=1 WHERE `giorno`.`id_giorno` = '$id_giorno'");
} catch (PDOException $e){
  $esito =0;
}
$connessione = null;
echo $esito;