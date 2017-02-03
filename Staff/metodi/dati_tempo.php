<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 10/01/2017
 * Time: 20:10
 */
$id_partita = filter_input(INPUT_GET, "id_p",FILTER_SANITIZE_STRING);
$id_sq1 = filter_input(INPUT_GET,"sq1",FILTER_SANITIZE_STRING);
$id_sq2 = filter_input(INPUT_GET,"sq2",FILTER_SANITIZE_STRING);
include "../../connessione.php";
$tempi = array();
try{
    //Dati tutti i tempi
    echo "{";
    echo "\"id_tempi\" : [";
        foreach ($connessione->query("SELECT * FROM tempo WHERE 1") as $row){
            if($row['id_tempo']==1){
                echo $row['id_tempo'];
            } else{
                echo ",".$row['id_tempo'];
            }


        }
        echo "],";

    echo "\"nomi_tempi\" : [";
    foreach ($connessione->query("SELECT * FROM tempo WHERE 1") as $row){
        if($row['id_tempo']==1){
            echo "\"".$row['descrizione']."\"";
        } else{
            echo ",\"".$row['descrizione']."\"";
        }
    }
    echo "],";
    //Fine dati tempo

    echo "\"tempi_partita\" : [0";
    foreach ($connessione->query("SELECT tempo.id_tempo FROM `tempo` LEFT JOIN `sq_tempo` ON tempo.id_tempo = sq_tempo.id_tempo WHERE id_partita = '$id_partita' GROUP BY(tempo.id_tempo)") as $row){
            echo ",".$row['id_tempo'];
            $tempi[]= $row['id_tempo'];
    }
    echo "],";
    echo "\"punti_tempo_sq1\" : [0";
    foreach ($connessione->query("SELECT sq_tempo.punti FROM `tempo` LEFT JOIN `sq_tempo` ON tempo.id_tempo = sq_tempo.id_tempo WHERE id_partita = '$id_partita' AND sq_tempo.id_sq = '$id_sq1'") as $row){
        echo ",".$row['punti'];
    }
    echo "],";
    echo "\"punti_tempo_sq2\" : [0";
    foreach ($connessione->query("SELECT sq_tempo.punti FROM `tempo` LEFT JOIN `sq_tempo` ON tempo.id_tempo = sq_tempo.id_tempo WHERE id_partita = '$id_partita' AND sq_tempo.id_sq = '$id_sq2'") as $row){
        echo ",".$row['punti'];
    }
    echo "],";
    echo "\"sq1\" : {";
    echo "\"id_giocatori\":[\"0\"";
    foreach ($connessione->query("SELECT * FROM `utente` INNER JOIN sq_utente ON utente.username = sq_utente.username WHERE id_sq = '$id_sq1'") as $row){
        echo ","."\"".$row['username']."\"";
    }
    echo "],";
    echo "\"nomi_giocatori\":[\"0\"";
    foreach ($connessione->query("SELECT * FROM `utente` INNER JOIN sq_utente ON utente.username = sq_utente.username WHERE id_sq = '$id_sq1'") as $row){
        $nome = "\"".$row['nome']." ".$row['cognome']."\"";
        echo ",".$nome;
    }
    echo "]";
    echo "},";
    echo "\"sq2\" : {";
    echo "\"id_giocatori\":[\"0\"";
    foreach ($connessione->query("SELECT * FROM `utente` INNER JOIN sq_utente ON utente.username = sq_utente.username WHERE id_sq = '$id_sq2'") as $row){
        echo ","."\"".$row['username']."\"";
    }
    echo "],";
    echo "\"nomi_giocatori\":[\"0\"";
    foreach ($connessione->query("SELECT * FROM `utente` INNER JOIN sq_utente ON utente.username = sq_utente.username WHERE id_sq = '$id_sq2'") as $row){
        $nome = "\"".$row['nome']." ".$row['cognome']."\"";
        echo ",".$nome;
    }
    echo "]";
    echo "},";



    //oggetti per cartellini
    echo "\"cartellini_sq1\" : [";
        for($j=0;$j<count($tempi);$j++){
            if($j==0){
                echo"{";
            } else {
                echo",{";
            }
            echo "\"id_tempo\":".$tempi[$j].",";
            echo "\"id_cartellini\":[0";
                $sql1 = "SELECT id_info FROM `info_tempo`"
                    ." INNER JOIN sq_utente ON info_tempo.id_sq_utente = sq_utente.id_sq_utente "
                    ." WHERE id_tempo = '$tempi[$j]' AND id_sq='$id_sq1' AND id_partita = '$id_partita' AND punto =0";
                    foreach ($connessione->query($sql1) as $row){
                        echo ",".$row['id_info'];
                    }
            echo"],";
            echo "\"nome_g_cartellini\":[\"nessuno\"";
            $sql1 = "SELECT nome, cognome FROM `info_tempo` "
                ." INNER JOIN sq_utente ON info_tempo.id_sq_utente = sq_utente.id_sq_utente"
                ." INNER JOIN utente ON utente.username = sq_utente.username"
                ." WHERE id_tempo = '$tempi[$j]' AND id_sq='$id_sq1' AND id_partita = '$id_partita' AND punto =0";
            foreach ($connessione->query($sql1) as $row){
                $nome = $row['nome']." ".$row['cognome'];
                echo ",\"".$nome."\"";
            }
            echo"],";
            echo "\"colore_cartellini\":[\"N\"";
            $sql1 = "SELECT cartellino_giallo FROM `info_tempo`"
                ." INNER JOIN sq_utente ON info_tempo.id_sq_utente = sq_utente.id_sq_utente "
                ." WHERE id_tempo = '$tempi[$j]' AND id_sq='$id_sq1' AND id_partita = '$id_partita' AND punto =0";
            foreach ($connessione->query($sql1) as $row){
                if($row['cartellino_giallo']==1){
                    $colore = 'G';
                } else {
                    $colore = 'R';
                }
                echo ",\"".$colore."\"";
            }
            echo"]";
            echo"}";
        }
    echo "],";

    echo "\"cartellini_sq2\" : [";
    for($j=0;$j<count($tempi);$j++){
        if($j==0){
            echo"{";
        } else {
            echo",{";
        }
        echo "\"id_tempo\":".$tempi[$j].",";
        echo "\"id_cartellini\":[0";
        $sql1 = "SELECT id_info FROM `info_tempo`"
            ." INNER JOIN sq_utente ON info_tempo.id_sq_utente = sq_utente.id_sq_utente "
            ." WHERE id_tempo = '$tempi[$j]' AND id_sq='$id_sq2' AND id_partita = '$id_partita' AND punto =0";
        foreach ($connessione->query($sql1) as $row){
            echo ",".$row['id_info'];
        }
        echo"],";
        echo "\"nome_g_cartellini\":[\"nessuno\"";
        $sql1 = "SELECT nome, cognome FROM `info_tempo` "
            ." INNER JOIN sq_utente ON info_tempo.id_sq_utente = sq_utente.id_sq_utente"
            ." INNER JOIN utente ON utente.username = sq_utente.username"
            ." WHERE id_tempo = '$tempi[$j]' AND id_sq='$id_sq2' AND id_partita = '$id_partita' AND punto =0";
        foreach ($connessione->query($sql1) as $row){
            $nome = $row['nome']." ".$row['cognome'];
            echo ",\"".$nome."\"";
        }
        echo"],";
        echo "\"colore_cartellini\":[\"N\"";
        $sql1 = "SELECT cartellino_giallo FROM `info_tempo`"
            ." INNER JOIN sq_utente ON info_tempo.id_sq_utente = sq_utente.id_sq_utente "
            ." WHERE id_tempo = '$tempi[$j]' AND id_sq='$id_sq2' AND id_partita = '$id_partita' AND punto =0";
        foreach ($connessione->query($sql1) as $row){
            if($row['cartellino_giallo']==1){
                $colore = 'G';
            } else {
                $colore = 'R';
            }
            echo ",\"".$colore."\"";
        }
        echo"]";
        echo"}";
    }
    echo "]";

    //chiusura oggetto principale
    echo "}";

} catch (PDOException $e){
    echo "error; ".$e->getMessage();
}
$connessione = null;