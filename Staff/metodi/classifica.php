<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 16/02/2017
 * Time: 10:49
 */
$torneo = filter_input(INPUT_GET,"id_t",FILTER_SANITIZE_STRING);

include "../../connessione.php";
try {
    echo "{";
    $oggT = $connessione->query("SELECT nome_torneo, torneo.id_sport, finished, fase_finale FROM `torneo` WHERE id_torneo = '$torneo'")->fetch(PDO::FETCH_OBJ);
    echo "\"nome_torneo\":\"".$oggT->nome_torneo."\",";
    echo "\"fase_finale\":".$oggT->fase_finale.",";
    echo "\"finished\":".$oggT->finished."";
    $vincitore = null;
    if($oggT->finished == 1){
        $oggV = $connessione->query("SELECT nome_sq FROM `squadra` WHERE `id_torneo` = '$torneo' AND `eliminata` == 0")->fetch(PDO::FETCH_OBJ);
        $vincitore = $oggV->nome_sq;
    }
    echo "\"nome_torneo\":\"".$vincitore."\",";
    echo "\"classifica\": [";
    $sql_g = "SELECT girone.id_girone, girone.nome_girone FROM `squadra`"
            ."INNER JOIN girone ON girone.id_girone = squadra.id_girone "
            ."WHERE id_torneo = '$torneo' GROUP BY(id_girone)";
        foreach ($connessione->query($sql_g) as $row) {
            $id_girone = $row['id_girone'];
            $nome_g = $row['nome_girone'];
            echo "{";
            echo "\"id_girone\":\"".$id_girone."\",";
            echo "\"nome_girone\":\"".$nome_g."\",";
            $squadre = array();
            $sql_sq_g = "SELECT squadra.id_sq, nome_sq, ((SUM(vittoria)*3)+SUM(pareggio)) AS punti FROM `squadra` "
                ."INNER JOIN sq_partita ON sq_partita.id_sq = squadra.id_sq "
                ."INNER JOIN partita ON sq_partita.id_partita = partita.id_partita "
                ."WHERE id_torneo = '$torneo' AND id_girone = '$id_girone' AND fase_finale = 0 "
                ."GROUP BY(squadra.id_sq) ORDER BY (punti) DESC";

            foreach ($connessione->query($sql_sq_g) as $row){
                $sq = $row['id_sq'];
                $sql_gol_f = "SELECT COUNT(punto) AS golF FROM `info_tempo`"
                ."INNER JOIN sq_utente ON sq_utente.id_sq_utente = info_tempo.id_sq_utente "
                ."INNER JOIN partita ON info_tempo.id_partita = partita.id_partita "
                ."WHERE id_sq = '$sq' AND punto = 1 AND fase_finale = 0 "
                ."GROUP BY (punto)";
                $oggGF = $connessione->query($sql_gol_f)->fetch(PDO::FETCH_OBJ);
                $golsubiti = 0;
                foreach ($connessione->query("SELECT partita.id_partita FROM `partita` INNER JOIN sq_partita ON partita.id_partita = sq_partita.id_partita WHERE id_sq = '$sq'") as $riga){
                    $id_p = $riga['id_partita'];
                    $sql_gs = "SELECT COALESCE(SUM(punto),0) AS golS FROM `info_tempo`"
                    ."INNER JOIN sq_utente ON sq_utente.id_sq_utente = info_tempo.id_sq_utente "
                    ."INNER JOIN partita ON info_tempo.id_partita = partita.id_partita "
                    ."WHERE id_sq != '$sq' AND punto = 1 AND fase_finale = 0 AND partita.id_partita = '$id_p' "
                    ."GROUP BY (punto)";
                    $oggGS = $connessione->query($sql_gs)->fetch(PDO::FETCH_OBJ);
                    if($oggGS != NULL){
                        $golsubiti += $oggGS->golS;
                    }
                }
                $dif_gol = intval($oggGF->golF)-intval($golsubiti);
                $squadre[] = array($row['id_sq'],$row['nome_sq'],$row['punti'],$oggGF->golF,$golsubiti,$dif_gol);
            }

            for($i =0;$i<(count($squadre)-1);$i++){
                for($j=$i+1;$j<count($squadre);$j++){
                    if($squadre[$i][0]==$squadre[$j][0]){
                        $ogg_p = $connessione->query()->fetch(PDO::FETCH_OBJ);
                        
                    }
                }
            }
            echo "}";
        }
    echo "],";

    /*if($oggT->fase_finale == 0) {
        foreach ($connessione->query("SELECT id_girone FROM `squadra` WHERE id_torneo = '$torneo' GROUP BY(id_girone)") as $row) {
            $id_girone = $row['id_girone'];

        }
    } else {
        foreach ($connessione->query("SELECT id_girone FROM `squadra` WHERE id_torneo = '$torneo' AND id_girone > 9 GROUP BY(id_girone)") as $row) {
            $id_girone = $row['id_girone'];

        }
    }*/
    echo"}";
}catch (PDOException $e){
    echo "errore:  ".$e->getMessage();
}
$connessione = null;