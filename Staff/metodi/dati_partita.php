<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 10/01/2017
 * Time: 16:02
 */

/*Creare json
$array = array(
        "id"=>$id,
        "nome"=>$nome,
        "colore"=>$colore);
 * echo json_encode($array);
 */

$id_partita = filter_input(INPUT_GET,"id_p",FILTER_SANITIZE_STRING);

include "../../connessione.php";
try{
    $oggPartita = $connessione->query("SELECT `id_partita`, `data_partita`, `ora_partita`, `luogo`,`finish` FROM `partita` WHERE id_partita = '$id_partita'")->fetch(PDO::FETCH_OBJ);
    $arraySquadre = array();
    foreach ($connessione->query("SELECT squadra.id_sq, squadra.nome_sq FROM `partita` INNER JOIN sq_partita ON partita.id_partita = sq_partita.id_partita INNER JOIN squadra ON sq_partita.id_sq = squadra.id_sq WHERE partita.id_partita = '$id_partita'") as $row){
        $arraySquadre[] = array($row['id_sq'],$row['nome_sq']);
    }

    $esito = null;
    if($oggPartita->finish != 0){
        $punti_sq1=0;
        $punti_sq2=0;
        $sq1 =$arraySquadre[0][0];
        $sq2 =$arraySquadre[1][0];
        foreach ($connessione->query("SELECT * FROM `sq_tempo` WHERE `id_partita` = '$id_partita' GROUP BY(id_tempo)") as $row) {
            $id_tempo = $row['id_tempo'];

            $oggP2 = $connessione->query("SELECT COUNT(*) AS gol FROM `info_tempo` INNER JOIN `sq_utente` ON info_tempo.id_sq_utente = sq_utente.id_sq_utente INNER JOIN `utente` ON utente.username = sq_utente.username WHERE `id_tempo` ='$id_tempo' AND `id_partita`='$id_partita' AND `id_sq` = '$sq2' AND punto = 1")->fetch(PDO::FETCH_OBJ);
            $oggP1 = $connessione->query("SELECT COUNT(*) AS gol FROM `info_tempo` INNER JOIN `sq_utente` ON info_tempo.id_sq_utente = sq_utente.id_sq_utente INNER JOIN `utente` ON utente.username = sq_utente.username WHERE `id_tempo` ='$id_tempo' AND `id_partita`='$id_partita' AND `id_sq` = '$sq1' AND punto = 1")->fetch(PDO::FETCH_OBJ);
            $punti_sq1 = $punti_sq1 + $oggP1->gol;
            $punti_sq2 = $punti_sq2 + $oggP2->gol;
        }
        $esito = array($punti_sq1,$punti_sq2);
    }
} catch (PDOException $e){
    echo "errore: ".$e->getMessage();
}
$connessione=null;
$dati = array(
    "data"=>$oggPartita->data_partita,
    "ora"=>$oggPartita->ora_partita,
    "campo"=>$oggPartita->luogo,
    "id_sq1"=>$arraySquadre[0][0],
    "nome_sq1"=>$arraySquadre[0][1],
    "id_sq2"=>$arraySquadre[1][0],
    "nome_sq2"=>$arraySquadre[1][1],
    "finish"=>$oggPartita->finish,
    "esito"=>$esito
);
echo json_encode($dati);