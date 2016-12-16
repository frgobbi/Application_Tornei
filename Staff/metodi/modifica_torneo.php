<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 09/12/2016
 * Time: 09:17
 */
$torneo = filter_input(INPUT_GET, "id",FILTER_SANITIZE_STRING);

$nome = filter_input(INPUT_POST, "nome",FILTER_SANITIZE_STRING);
$inizio = filter_input(INPUT_POST, "inizio",FILTER_SANITIZE_STRING);
$iscrizioni = filter_input(INPUT_POST,"iscrizioni",FILTER_SANITIZE_STRING);
$fine = filter_input(INPUT_POST, "fine", FILTER_SANITIZE_STRING);
$min_sq = filter_input(INPUT_POST,"min_sq",FILTER_SANITIZE_STRING);
$max_sq = filter_input(INPUT_POST, "max_sq", FILTER_SANITIZE_STRING);
$num_giocatori = filter_input(INPUT_POST,"num_giocatori", FILTER_SANITIZE_STRING);
$info = filter_input(INPUT_POST, "info" , FILTER_SANITIZE_STRING);

$sql_modifica = "UPDATE `torneo` SET "
    ."`nome_torneo`='$nome',"
    ."`min_sq`='$min_sq',"
    ."`max_sq`='$max_sq',"
    ."`num_giocatori`='$num_giocatori',"
    ."`data_inizio`='$inizio',"
    ."`data_f_iscrizioni`='$iscrizioni',"
    ."`data_fine`='$fine',"
    ."`info`='$info'"
    ."WHERE id_torneo = '$torneo'";
echo $sql_modifica;
include "../../connessione.php";
try{
    $connessione->exec($sql_modifica);
} catch (PDOException $e){
    echo "errore: ".$e->getMessage();
}
$connessione = null;
header("Location:../Admin_Torneo.php?id=$torneo");