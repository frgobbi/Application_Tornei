<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 29/03/2017
 * Time: 21:54
 */
$id = filter_input(INPUT_GET,"id",FILTER_SANITIZE_STRING);
include "../../connessione.php";
try{
    $sql = "SELECT * FROM `squadra` "
        ."WHERE id_torneo = '$id'";
    foreach ($connessione->query($sql)as $row){
        $sq = $row['id_sq'];
        $key = "sel".$sq;
        $new_g = filter_input(INPUT_POST,$key,FILTER_SANITIZE_STRING);
        if($new_g !=0){
            $connessione->exec("UPDATE `squadra` SET `id_girone` = '$new_g' WHERE `squadra`.`id_sq` = '$sq'");
        }else{
            $connessione->exec("UPDATE `squadra` SET `eliminata` = '1' WHERE `squadra`.`id_sq` = '$sq'");
        }
    }
    $connessione->exec("UPDATE `torneo` SET `fase_finale` = '1' WHERE `torneo`.`id_torneo` = '$id'");
    foreach ($connessione->query("SELECT * FROM `sq_utente` INNER JOIN squadra on squadra.id_sq = sq_utente.id_sq WHERE squadra.id_torneo = '$id'") as $row){
        $id_g = $row['id_sq_utente'];
        $connessione->exec("UPDATE `info_tempo` SET `valido`= '0' WHERE id_sq_utente = '$id_g' AND cartellino_giallo = '1'");
        $connessione->exec("UPDATE `info_tempo` SET `valido`= '0' WHERE id_sq_utente = '$id_g' AND cartellino_rosso = '1'");
    }
} catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;
header("Location:../Admin_Torneo.php?id=".$id."");