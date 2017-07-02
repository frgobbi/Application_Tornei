<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 03/02/2017
 * Time: 10:50
 */
$partita = filter_input(INPUT_GET,"id_p",FILTER_SANITIZE_STRING);
$tempo = filter_input(INPUT_GET,"id_tempo",FILTER_SANITIZE_STRING);
$squadra = filter_input(INPUT_GET,"id_sq",FILTER_SANITIZE_STRING);
$giocatore = filter_input(INPUT_GET,"giocatore",FILTER_SANITIZE_STRING);
$colore = filter_input(INPUT_GET,"colore",FILTER_SANITIZE_STRING);

include "../../connessione.php";
try{
    if(strcmp($giocatore,"0")!=0) {
        $oggSQ_utente = $connessione->query("SELECT `id_sq_utente` FROM `sq_utente` WHERE `id_sq` = '$squadra' AND `username` = '$giocatore'")->fetch(PDO::FETCH_OBJ);
        if (strcmp($colore, "G") == 0) {
            $sql_infoTempo = "INSERT INTO `info_tempo`(`id_info`, `id_sq_utente`, `id_tempo`, `id_partita`, `punto`, `cartellino_giallo`, `cartellino_rosso`,`valido`) " .
                "VALUES (NULL,'$oggSQ_utente->id_sq_utente','$tempo','$partita','0','1','0','1')";
            $sq_cartellino = "SELECT MAX(id_info) AS id_cartellino, nome, cognome FROM `info_tempo`"
                . "INNER JOIN sq_utente ON sq_utente.id_sq_utente = info_tempo.id_sq_utente "
                . "INNER JOIN utente ON utente.username = sq_utente.username "
                . "WHERE info_tempo.id_sq_utente = '$oggSQ_utente->id_sq_utente' AND info_tempo.id_tempo = '$tempo' AND info_tempo.id_partita = '$partita' AND info_tempo.cartellino_giallo = '1'";
        } else {
            $sql_infoTempo = "INSERT INTO `info_tempo`(`id_info`, `id_sq_utente`, `id_tempo`, `id_partita`, `punto`, `cartellino_giallo`, `cartellino_rosso`,`valido`) " .
                "VALUES (NULL,'$oggSQ_utente->id_sq_utente','$tempo','$partita','0','0','1','1')";
            $sq_cartellino = "SELECT MAX(id_info) AS id_cartellino, nome, cognome FROM `info_tempo`"
                . "INNER JOIN sq_utente ON sq_utente.id_sq_utente = info_tempo.id_sq_utente "
                . "INNER JOIN utente ON utente.username = sq_utente.username "
                . "WHERE info_tempo.id_sq_utente = '$oggSQ_utente->id_sq_utente' AND info_tempo.id_tempo = '$tempo' AND info_tempo.id_partita = '$partita' AND info_tempo.cartellino_rosso = '1'";
        }
        $connessione->exec($sql_infoTempo);
        $cartellino = $connessione->query($sq_cartellino)->fetch(PDO::FETCH_OBJ);
        $nome = $cartellino->nome . " " . $cartellino->cognome;
        $array = array(
            "esito" => 1,
            "id_cartellino" => $cartellino->id_cartellino,
            "nome_giocatore" => $nome,
            "colore" => $colore
        );
    } else{
        $array = array(
            "esito" => 0
        );
    }

} catch (PDOException $e){
    //echo "errore: ".$e->getMessage();
    $array = array(
        "esito"=>0
    );
}
$connessione = null;
echo json_encode($array);
