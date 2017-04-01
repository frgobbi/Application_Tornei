<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 01/04/2017
 * Time: 13:37
 */
$id = filter_input(INPUT_GET,"id_t",FILTER_SANITIZE_STRING);
include "../../connessione.php";
try{
    $connessione->exec("UPDATE `torneo` SET `finished` = '1' WHERE `torneo`.`id_torneo` = '$id';");
}catch (PDOException $e){
    echo $e->getMessage();
}
$connessione=null;