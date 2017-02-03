<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 10/01/2017
 * Time: 17:09
 */
$id_partita = filter_input(INPUT_GET, "id_p", FILTER_SANITIZE_STRING);
$torneo = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
$data = filter_input(INPUT_POST, "data", FILTER_SANITIZE_STRING);
$ora = filter_input(INPUT_POST, "ora",FILTER_SANITIZE_STRING);
$luogo = filter_input(INPUT_POST,"luogo", FILTER_SANITIZE_STRING);
 //echo $id_torneo."<br>".$torneo."<br>".$data."<br>".$ora."<br>".$luogo;
include "../../connessione.php";
try{
    $sql = "UPDATE `partita` SET "
        ."`data_partita`= '$data',"
        ."`ora_partita`= '$ora',"
        ."`luogo`= '$luogo'"
        ."WHERE `partita`.`id_partita` = '$id_partita'";
    $connessione->exec($sql);
} catch (PDOException $e){
    echo "error: ".$e->getMessage();
}
$connessione = null;
header("Location:../Admin_Torneo.php?id=$torneo");