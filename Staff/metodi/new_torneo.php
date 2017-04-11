<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 03/12/2016
 * Time: 00:57
 */
$nome_torneo = filter_input(INPUT_POST, "nome_torneo",FILTER_SANITIZE_STRING);
$data_inizio = filter_input(INPUT_POST, "data_inizio",FILTER_SANITIZE_STRING);
$data_fine = filter_input(INPUT_POST, "data_fine",FILTER_SANITIZE_STRING);
$data_fine_iscrizioni = filter_input(INPUT_POST, "data_fine_iscrizioni",FILTER_SANITIZE_STRING);
$min_squadre = filter_input(INPUT_POST, "min_sq",FILTER_SANITIZE_STRING);
$max_squadre = filter_input(INPUT_POST, "max_sq",FILTER_SANITIZE_STRING);
$num_sq_min = filter_input(INPUT_POST, "giocatori_sq_min",FILTER_SANITIZE_STRING);
$num_sq_max = filter_input(INPUT_POST, "giocatori_sq_max",FILTER_SANITIZE_STRING);
$Sport = filter_input(INPUT_POST, "Sport",FILTER_SANITIZE_STRING);
$info = filter_input(INPUT_POST,"info",FILTER_SANITIZE_STRING);
$eta_min = filter_input(INPUT_POST,"eta_min",FILTER_SANITIZE_STRING);
$eta_max = filter_input(INPUT_POST,"eta_max",FILTER_SANITIZE_STRING);

if(strcmp($eta_min,"")==0){
    $eta_min = 0;
}

if(strcmp($eta_max,"")==0){
    $eta_max = 0;
}

include "../../connessione.php";
try{
    $sql_new_torneo ="INSERT INTO `torneo`(`id_torneo`, `nome_torneo`, `id_sport`, `min_sq`, `max_sq`, `num_giocatori_min`, `num_giocatori_max`, `data_inizio`, `data_f_iscrizioni`, `data_fine`, `min_anno`, `max_anno`, `logo_torneo`, `color`, `info`, `finished`) VALUES "
        ."(NULL, '$nome_torneo', '$Sport', '$min_squadre', '$max_squadre', '$num_sq_min', '$num_sq_max', '$data_inizio', '$data_fine_iscrizioni', '$data_fine', '$eta_min','$eta_max', 'logo_tornei.png', NULL, '$info', '0');";
    $connessione->exec($sql_new_torneo);
}
catch (PDOException $e){
    echo "<script type='text/javascript'>alert('Qualcosa e\' andato storto.... Riprovare piu\' tardi' );</script>";
}
$connessione = null;
header('Refresh: 0.005;url=../Torneo.php');