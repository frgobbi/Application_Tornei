<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 14/02/2017
 * Time: 14:40
 */
$partita = filter_input(INPUT_GET,"id_p",FILTER_SANITIZE_STRING);
$sq1 = filter_input(INPUT_GET,"id_sq1",FILTER_SANITIZE_STRING);
$sq2 = filter_input(INPUT_GET,"id_sq2",FILTER_SANITIZE_STRING);
$id_torneo = filter_input(INPUT_GET, "torneo",FILTER_SANITIZE_STRING);

include "../../connessione.php";
try{
    $esito = 1;
    $sql_T = "SELECT id_torneo , id_sport, descrizione FROM `torneo`"
            ."INNER JOIN tipo_sport ON torneo.id_sport = tipo_sport.id_tipo_sport "
            ."WHERE id_torneo = '$id_torneo'";
    $oggTorneo = $connessione->query($sql_T)->fetch(PDO::FETCH_OBJ);

    $punti_sq1=0;
    $punti_sq2=0;

    $oggPartita = $connessione->query("SELECT * FROM `partita` WHERE id_partita = '$partita'")->fetch(PDO::FETCH_OBJ);

    foreach ($connessione->query("SELECT * FROM `sq_tempo` WHERE `id_partita` = '$partita' GROUP BY(id_tempo)") as $row){
        $id_tempo = $row['id_tempo'];
        $oggP2 = $connessione->query("SELECT COUNT(*) AS gol FROM `info_tempo` INNER JOIN `sq_utente` ON info_tempo.id_sq_utente = sq_utente.id_sq_utente INNER JOIN `utente` ON utente.username = sq_utente.username WHERE `id_tempo` ='$id_tempo' AND `id_partita`='$partita' AND `id_sq` = '$sq2' AND punto = 1")->fetch(PDO::FETCH_OBJ);
        $oggP1 = $connessione->query("SELECT COUNT(*) AS gol FROM `info_tempo` INNER JOIN `sq_utente` ON info_tempo.id_sq_utente = sq_utente.id_sq_utente INNER JOIN `utente` ON utente.username = sq_utente.username WHERE `id_tempo` ='$id_tempo' AND `id_partita`='$partita' AND `id_sq` = '$sq1' AND punto = 1")->fetch(PDO::FETCH_OBJ);
        $punti_sq1 = $punti_sq1+$oggP1->gol;
        $punti_sq2 = $punti_sq2+$oggP2->gol;

        if($oggP1->gol == $oggP2->gol){
            $connessione->exec("UPDATE `sq_tempo` SET vittoria = 0, sconfitta = 0, pareggio = 1 WHERE id_tempo = '$id_tempo' AND id_sq = '$sq1' AND id_partita = '$partita'");
            $connessione->exec("UPDATE `sq_tempo` SET vittoria = 0, sconfitta = 0, pareggio = 1 WHERE id_tempo = '$id_tempo' AND id_sq = '$sq1' AND id_partita = '$partita'");
        } else {
            if($oggP1->gol > $oggP2->gol){
                $connessione->exec("UPDATE `sq_tempo` SET vittoria = 1, sconfitta = 0, pareggio = 0 WHERE id_tempo = '$id_tempo' AND id_sq = '$sq1' AND id_partita = '$partita'");
                $connessione->exec("UPDATE `sq_tempo` SET vittoria = 0, sconfitta = 1, pareggio = 0 WHERE id_tempo = '$id_tempo' AND id_sq = '$sq1' AND id_partita = '$partita'");
                if($oggPartita->fase_finale == 1){
                    $connessione->exec("UPDATE `squadra` SET `eliminata`='1' WHERE id_sq = '$sq2'");
                }
            } else {
                $connessione->exec("UPDATE `sq_tempo` SET vittoria = 0, sconfitta = 1, pareggio = 0 WHERE id_tempo = '$id_tempo' AND id_sq = '$sq1' AND id_partita = '$partita'");
                $connessione->exec("UPDATE `sq_tempo` SET vittoria = 1, sconfitta = 0, pareggio = 0 WHERE id_tempo = '$id_tempo' AND id_sq = '$sq1' AND id_partita = '$partita'");
                if($oggPartita->fase_finale == 1){
                    $connessione->exec("UPDATE `squadra` SET `eliminata`='1' WHERE id_sq = '$sq1'");
                }
            }
        }
    }
    if($oggTorneo->id_sport != 4){
        if($punti_sq2==$punti_sq1){
            $connessione->exec("UPDATE `sq_partita` SET vittoria = 0, sconfitta = 0, pareggio = 1 WHERE id_sq = '$sq1' AND id_partita = '$partita'");
            $connessione->exec("UPDATE `sq_partita` SET  vittoria = 0, sconfitta = 0, pareggio = 1 WHERE id_sq = '$sq2' AND id_partita = '$partita'");
        }else{
            if($punti_sq1>$punti_sq2){
                $connessione->exec("UPDATE `sq_partita` SET vittoria = 1, sconfitta = 0, pareggio = 0 WHERE id_sq = '$sq1' AND id_partita = '$partita'");
                $connessione->exec("UPDATE `sq_partita` SET  vittoria = 0, sconfitta = 1, pareggio = 0 WHERE id_sq = '$sq2' AND id_partita = '$partita'");
            }else{
                $connessione->exec("UPDATE `sq_partita` SET vittoria = 0, sconfitta = 1, pareggio = 0 WHERE id_sq = '$sq1' AND id_partita = '$partita'");
                $connessione->exec("UPDATE `sq_partita` SET  vittoria = 1, sconfitta = 0, pareggio = 0 WHERE id_sq = '$sq2' AND id_partita = '$partita'");
            }
        }
    } else {
        $set_sq1 =0;
        $set_sq2 =0;
        foreach ($connessione->query("SELECT * FROM `sq_tempo` WHERE `id_partita` = '$partita' GROUP BY(id_tempo)") as $row){
            $oggSet = $connessione->query("SELECT * FROM sq_tempo WHERE id_tempo = '$id_tempo' AND id_sq = '$sq1' AND id_partita = '$partita'")->fetch(PDO::FETCH_OBJ);
            if ($oggSet->vittoria == 1){
                $set_sq1 = $set_sq1 +1;
            } else{
                $set_sq1 = $set_sq1 +1;
            }
        }

        if($set_sq1>$set_sq2){
            if($set_sq2 == 2){
                $connessione->exec("UPDATE `sq_partita` SET vittoria = 1, sconfitta = 0, pareggio = 0, tie_break = 1 WHERE id_sq = '$sq1' AND id_partita = '$partita'");
                $connessione->exec("UPDATE `sq_partita` SET  vittoria = 0, sconfitta = 1, pareggio = 0, tie_break = 1 WHERE id_sq = '$sq2' AND id_partita = '$partita'");
            } else{
                $connessione->exec("UPDATE `sq_partita` SET vittoria = 1, sconfitta = 0, pareggio = 0, tie_break = 0 WHERE id_sq = '$sq1' AND id_partita = '$partita'");
                $connessione->exec("UPDATE `sq_partita` SET  vittoria = 0, sconfitta = 1, pareggio = 0, tie_break = 0 WHERE id_sq = '$sq2' AND id_partita = '$partita'");
            }
        } else{
            if($set_sq1 == 2){
                $connessione->exec("UPDATE `sq_partita` SET vittoria = 1 sconfitta = 0 pareggio = 0 tie_break = 1 WHERE id_sq = '$sq2' AND id_partita = '$partita'");
                $connessione->exec("UPDATE `sq_partita` SET  vittoria = 0 sconfitta = 1 pareggio = 0 tie_break = 1 WHERE id_sq = '$sq1' AND id_partita = '$partita'");
            } else{
                $connessione->exec("UPDATE `sq_partita` SET vittoria = 1 sconfitta = 0 pareggio = 0 tie_break = 0 WHERE id_sq = '$sq2' AND id_partita = '$partita'");
                $connessione->exec("UPDATE `sq_partita` SET  vittoria = 0 sconfitta = 1 pareggio = 0 tie_break = 0 WHERE id_sq = '$sq1' AND id_partita = '$partita'");
            }
        }
    }
    $connessione->exec("UPDATE `partita` SET finish = 1 WHERE id_partita = '$partita'");
    $connessione->exec("UPDATE `partita` SET finish = 1 WHERE id_partita = '$partita'");
}catch (PDOException $e){
   $esito = 0;
    echo $e->getMessage();
}
$connessione = null;
echo $esito;