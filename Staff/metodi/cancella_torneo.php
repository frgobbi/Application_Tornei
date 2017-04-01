<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 09/12/2016
 * Time: 23:09
 */
$oggi = date("d-m-Y");
$torneo = filter_input(INPUT_GET,"id",FILTER_SANITIZE_STRING);
$data = filter_input(INPUT_GET,"data",FILTER_SANITIZE_STRING);

//echo $torneo."___".$oggi."___".$data;
//echo $data;
//echo " ".$oggi;
$oggiTime = strtotime($oggi);
$dataTime = strtotime($data);

//echo "<br>".$dataTime;
//echo " ".$oggiTime;
if ($oggiTime < $dataTime){
    $esito = 0;
    include "../../connessione.php";
    try{
        $connessione->beginTransaction();
        foreach ($connessione->query("SELECT `id_sq` FROM `squadra` WHERE `id_torneo` = '$torneo'") as $row){
            $id_sq = $row['id_sq'];
            foreach ($connessione->query("SELECT * FROM `sq_partita` WHERE id_sq = '$id_sq'") as $riga){
                $p = $riga['id_partita'];
                $connessione->exec("DELETE FROM `info_tempo` WHERE `id_partita` = '$p'");
                $connessione->exec("DELETE FROM `sq_tempo` WHERE `id_partita` = '$p'");
            }
            $connessione->exec("DELETE FROM `sq_partita` WHERE `id_sq` = '$id_sq'");
            $connessione->exec("DELETE FROM `sq_utente` WHERE `id_sq` = '$id_sq'");
            $connessione->exec("DELETE FROM `squadra` WHERE `id_sq` = '$id_sq'");
        }
        $connessione->exec("DELETE FROM `torneo` WHERE `id_torneo` = '$torneo'");
        $connessione->commit();
    } catch (PDOException $e){
        $connessione->rollBack();
        echo $e->getMessage();
    }
    $connessione = null;
}
else {
    $esito = 2;
}
echo $esito;