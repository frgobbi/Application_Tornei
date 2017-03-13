<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 03/03/2017
 * Time: 18:16
 */
$id = filter_input(INPUT_GET,"id",FILTER_SANITIZE_STRING);
$stato = filter_input(INPUT_GET,"stato",FILTER_SANITIZE_STRING);
$esito = 1;
include "../../connessione.php";
try{
    $connessione->exec("UPDATE `prodotto` SET `vendibile`='$stato' WHERE `id_prodotto` = '$id'");
}catch (PDOException $e){
    $esito = 0;
}
$connessione = null;
echo $esito;
