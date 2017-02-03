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
    "finish"=>$oggPartita->finish
);
echo json_encode($dati);