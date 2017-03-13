<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 03/03/2017
 * Time: 19:53
 */
$id = filter_input(INPUT_GET,"id",FILTER_SANITIZE_STRING);
$nome = filter_input(INPUT_GET,"nome",FILTER_SANITIZE_STRING);
$prezzo = filter_input(INPUT_GET,"prezzo",FILTER_SANITIZE_STRING);
$esito = 1;
include "../../connessione.php";
try{
    $connessione->exec("UPDATE `prodotto` SET `nome_prodotto`='$nome', `prezzo`='$prezzo' WHERE `id_prodotto` = '$id'");
}catch (PDOException $e){
    $esito = 0;
}
$connessione = null;
echo $esito;