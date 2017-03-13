<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 02/03/2017
 * Time: 20:47
 */
$id_cat = filter_input(INPUT_GET,"id",FILTER_SANITIZE_STRING);
$colore = filter_input(INPUT_GET,"colore",FILTER_SANITIZE_STRING);
$esito =1;
include "../../connessione.php";
try{
    $connessione->exec("UPDATE `cat_prodotto` SET `colore` = '$colore' WHERE `cat_prodotto`.`id_cat_prodotto` = '$id_cat';");
} catch (PDOException $e){
    $esito=0;
}
$connessione = null;
echo $esito;