<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 20/12/2016
 * Time: 15:50
 */
$torneo = filter_input(INPUT_GET,"id",FILTER_SANITIZE_STRING);
$data = filter_input(INPUT_POST,"data",FILTER_SANITIZE_STRING);
$ora  = filter_input(INPUT_POST,"ora",FILTER_SANITIZE_STRING);
$luogo = filter_input(INPUT_POST,"luogo",FILTER_SANITIZE_STRING);
$sq1 = filter_input(INPUT_POST,"sq1",FILTER_SANITIZE_STRING);
$sq2 = filter_input(INPUT_POST,"sq2",FILTER_SANITIZE_STRING);
$tipo = filter_input(INPUT_POST,"tipo_parita",FILTER_SANITIZE_STRING);

include "../../connessione.php";
try{
    $connessione->exec("INSERT INTO `partita`(`id_partita`, `data_partita`, `ora_partita`, `luogo`, `fase_finale`) VALUES (NULL,'$data','$ora','$luogo','$tipo')");
    $ogg_p = $connessione->query("SELECT MAX(id_partita) AS id_partita FROM `partita` WHERE 1")->fetch(PDO::FETCH_OBJ);
    $connessione->exec("INSERT INTO `sq_partita`(`id_sq`, `id_partita`, `vittoria`, `sconfitta`, `pareggio`, `tie_break`) VALUES ('$sq1','$ogg_p->id_partita','0','0','0','0')");
    $connessione->exec("INSERT INTO `sq_partita`(`id_sq`, `id_partita`, `vittoria`, `sconfitta`, `pareggio`, `tie_break`) VALUES ('$sq2','$ogg_p->id_partita','0','0','0','0')");
} catch (PDOException $e){echo $e->getMessage();}
$connessione = null;
header("Location:../Admin_Torneo.php?id=$torneo");

