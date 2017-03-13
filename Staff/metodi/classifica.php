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
    echo "\"finished\":".$oggT->finished.",";
    $vincitore = null;
    if($oggT->finished == 1){
        $oggV = $connessione->query("SELECT nome_sq FROM `squadra` WHERE `id_torneo` = '$torneo' AND `eliminata` == 0")->fetch(PDO::FETCH_OBJ);
        $vincitore = $oggV->nome_sq;
    }
    echo "\"gironi_torneo\" : [0";
    $sql_g = "SELECT girone.id_girone, girone.nome_girone FROM `squadra`"
        ."INNER JOIN girone ON girone.id_girone = squadra.id_girone "
        ."WHERE id_torneo = '$torneo' AND girone.id_girone < 10 GROUP BY(id_girone)";
    foreach ($connessione->query($sql_g) as $row) {
        echo ",".$row['id_girone'];
    }
    echo "],";
    echo "\"vincitore\":\"".$vincitore."\",";
    echo "\"classifica\": [{";
    echo "\"id_girone\":\"0\",";
    echo "\"nome_girone\":\"nessuno\"";
    echo "}";
    $sql_g = "SELECT girone.id_girone, girone.nome_girone FROM `squadra`"
            ."INNER JOIN girone ON girone.id_girone = squadra.id_girone "
            ."WHERE id_torneo = '$torneo' GROUP BY(id_girone)";
        foreach ($connessione->query($sql_g) as $row) {
            $id_girone = $row['id_girone'];
            $nome_g = $row['nome_girone'];
            echo ",{";
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
                $gF =0;
                if($oggGF != NULL){
                    $gF = $oggGF->golF;
                }
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
                $dif_gol = intval($gF)-intval($golsubiti);
                $squadre[] = array($row['id_sq'],$row['nome_sq'],$row['punti'],$gF,$golsubiti,$dif_gol);
            }
            for($i =0;$i<(count($squadre)-1);$i++){
                for($j=$i+1;$j<count($squadre);$j++){
                    if($squadre[$i][2]==$squadre[$j][2]){
                        $sq1 = $squadre[$i][0];
                        $sq2 = $squadre[$j][0];
                        $sql = "SELECT partita.id_partita FROM `partita` INNER JOIN sq_partita ON sq_partita.id_partita = partita.id_partita WHERE (id_sq = '$sq1' || id_sq = '$sq2') AND fase_finale = 0 GROUP BY(partita.id_partita)";

                        $punti_sq1=0;
                        $punti_sq2=0;
                        foreach ($connessione->query($sql) as $riga){
                            $partita = $riga['id_partita'];
                            foreach ($connessione->query("SELECT * FROM `sq_tempo` WHERE `id_partita` = '$partita' GROUP BY(id_tempo)") as $riga1) {
                                $id_tempo = $riga1['id_tempo'];
                                $oggP2 = $connessione->query("SELECT COUNT(*) AS gol FROM `info_tempo` INNER JOIN `sq_utente` ON info_tempo.id_sq_utente = sq_utente.id_sq_utente INNER JOIN `utente` ON utente.username = sq_utente.username WHERE `id_tempo` ='$id_tempo' AND `id_partita`='$partita' AND `id_sq` = '$sq2' AND punto = 1")->fetch(PDO::FETCH_OBJ);
                                $oggP1 = $connessione->query("SELECT COUNT(*) AS gol FROM `info_tempo` INNER JOIN `sq_utente` ON info_tempo.id_sq_utente = sq_utente.id_sq_utente INNER JOIN `utente` ON utente.username = sq_utente.username WHERE `id_tempo` ='$id_tempo' AND `id_partita`='$partita' AND `id_sq` = '$sq1' AND punto = 1")->fetch(PDO::FETCH_OBJ);
                                $punti_sq1 = $punti_sq1 + $oggP1->gol;
                                $punti_sq2 = $punti_sq2 + $oggP2->gol;
                            }
                        }

                        if($punti_sq2>$punti_sq1){

                            $app1 = $squadre[$i][0];
                            $app2 = $squadre[$i][1];
                            $app3 = $squadre[$i][2];
                            $app4 = $squadre[$i][3];
                            $app5 = $squadre[$i][4];
                            $app6 = $squadre[$i][5];

                            $squadre[$i][0] = $squadre[$j][0];
                            $squadre[$i][1] = $squadre[$j][1];
                            $squadre[$i][2] = $squadre[$j][2];
                            $squadre[$i][3] = $squadre[$j][3];
                            $squadre[$i][4] = $squadre[$j][4];
                            $squadre[$i][5] = $squadre[$j][5];

                            $squadre[$j][0] = $app1;
                            $squadre[$j][1] = $app2;
                            $squadre[$j][2] = $app3;
                            $squadre[$j][3] = $app4;
                            $squadre[$j][4] = $app5;
                            $squadre[$j][5] = $app6;

                        } else{
                            if($punti_sq1==$punti_sq2){
                                if($squadre[$j][5]>$squadre[$i][$i]){

                                    $app1 = $squadre[$i][0];
                                    $app2 = $squadre[$i][1];
                                    $app3 = $squadre[$i][2];
                                    $app4 = $squadre[$i][3];
                                    $app5 = $squadre[$i][4];
                                    $app6 = $squadre[$i][5];

                                    $squadre[$i][0] = $squadre[$j][0];
                                    $squadre[$i][1] = $squadre[$j][1];
                                    $squadre[$i][2] = $squadre[$j][2];
                                    $squadre[$i][3] = $squadre[$j][3];
                                    $squadre[$i][4] = $squadre[$j][4];
                                    $squadre[$i][5] = $squadre[$j][5];

                                    $squadre[$j][0] = $app1;
                                    $squadre[$j][1] = $app2;
                                    $squadre[$j][2] = $app3;
                                    $squadre[$j][3] = $app4;
                                    $squadre[$j][4] = $app5;
                                    $squadre[$j][5] = $app6;
                                }
                            }
                        }

                    }
                }
            }

            echo "\"id_sq\": [";
            for($i=0;$i<count($squadre);$i++){
                if($i==0){
                    echo $squadre[$i][0];
                } else {
                    echo",".$squadre[$i][0];
                }
            }
            echo"],";

            echo "\"nome_sq\": [";
            for($i=0;$i<count($squadre);$i++){
                if($i==0){
                    echo "\"".$squadre[$i][1]."\"";
                } else {
                    echo",\"".$squadre[$i][1]."\"";
                }
            }
            echo"],";

            echo "\"punti\": [";
            for($i=0;$i<count($squadre);$i++){
                if($i==0){
                    echo $squadre[$i][2];
                } else {
                    echo",".$squadre[$i][2];
                }
            }
            echo"],";

            echo "\"gol_fatti\": [";
            for($i=0;$i<count($squadre);$i++){
                if($i==0){
                    echo $squadre[$i][3];
                } else {
                    echo",".$squadre[$i][3];
                }
            }
            echo"],";

            echo "\"gol_subiti\": [";
            for($i=0;$i<count($squadre);$i++){
                if($i==0){
                    echo $squadre[$i][4];
                } else {
                    echo",".$squadre[$i][4];
                }
            }
            echo"],";

            echo "\"dif_reti\": [";
            for($i=0;$i<count($squadre);$i++){
                if($i==0){
                    echo $squadre[$i][5];
                } else {
                    echo",".$squadre[$i][5];
                }
            }
            echo "],";


            $query_marcatori = "SELECT utente.nome, utente.cognome , COUNT(*) AS num_gol FROM `info_tempo` "
            ."INNER JOIN sq_utente ON sq_utente.id_sq_utente = info_tempo.id_sq_utente "
            ."INNER JOIN squadra ON sq_utente.id_sq = squadra.id_sq "
            ."INNER JOIN utente ON utente.username = sq_utente.username "
            ."INNER JOIN partita on partita.id_partita = info_tempo.id_partita "
            ."WHERE punto = 1 AND fase_finale = 0 AND id_girone = '$id_girone' GROUP BY (utente.username)";
            echo "\"marcatori_nome\":[0";
            foreach ($connessione->query($query_marcatori) as $row){
                $nome = $row['nome'];
                echo ",\"$nome\"";
            }
            echo "],";

            echo "\"marcatori_cognome\":[0";
            foreach ($connessione->query($query_marcatori) as $row){
                $cognome = $row['cognome'];
                echo ",\"$cognome\"";
            }
            echo "],";

            echo "\"marcatori_num_gol\":[0";
            foreach ($connessione->query($query_marcatori) as $row){
                $num = $row['num_gol'];
                echo ",$num";
            }
            echo "]";

            echo "}";
        }
    echo "]";



    if($oggT->fase_finale == 1) {
        $sql_g = "SELECT girone.id_girone, girone.nome_girone FROM `squadra`"
            ."INNER JOIN girone ON girone.id_girone = squadra.id_girone "
            ."WHERE id_torneo = '$torneo' AND girone.id_girone > 9 GROUP BY(id_girone)";
        foreach ($connessione->query("SELECT id_girone FROM `squadra` WHERE id_torneo = '$torneo' GROUP BY(id_girone)") as $row) {
            $id_girone = $row['id_girone'];

        }
    }
    echo"}";
}catch (PDOException $e){
    echo "errore:  ".$e->getMessage();
}
$connessione = null;