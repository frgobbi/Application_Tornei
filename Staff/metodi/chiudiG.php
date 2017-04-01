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
} catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;
header("Location:../Admin_Torneo.php?id=".$id."");