<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 12/04/2017
 * Time: 08:23
 */
$id_t = filter_input(INPUT_GET,"id_torneo",FILTER_SANITIZE_STRING);

include "../../connessione.php";
try{
    $sql = "SELECT `id_torneo`,`nome_torneo`,`min_sq`,`max_sq`,`num_giocatori_min`,`num_giocatori_max`, DATE_FORMAT(data_inizio,'%d-%m-%Y') AS inizio, "
    ."`data_inizio`, DATE_FORMAT(data_f_iscrizioni,'%d-%m-%Y') AS Fiscirizioni,`data_f_iscrizioni`, DATE_FORMAT(data_fine,'%d-%m-%Y') AS fine,`data_fine`, "
    ."`info`,tipo_sport.descrizione AS sport, `min_anno`, `max_anno`, `fase_finale`,`finished` "
        . "FROM `torneo` INNER JOIN tipo_sport ON tipo_sport.id_tipo_sport = torneo.id_sport WHERE id_torneo= '$id_t'";
    $oggTorneo = $connessione->query($sql)->fetch(PDO::FETCH_OBJ);
    $squadre_iscritte = $connessione->query("SELECT COUNT(*) AS numero FROM `squadra` WHERE id_torneo = '$id_t' AND iscritta = 1")->fetch(PDO::FETCH_OBJ);
    $proposte_squadre = $connessione->query("SELECT COUNT(*) AS numero FROM `squadra` WHERE id_torneo = '$id_t' AND iscritta = 0")->fetch(PDO::FETCH_OBJ);
    echo "{";
        echo "\"nome_t\":"."\"$oggTorneo->nome_torneo\",";
        echo "\"min_sq\":"."\"$oggTorneo->min_sq\",";
        echo "\"max_sq\":"."\"$oggTorneo->max_sq\",";
        echo "\"num_g_min\":"."\"$oggTorneo->num_giocatori_min\",";
        echo "\"num_g_max\":"."\"$oggTorneo->num_giocatori_max\",";
        echo "\"data_inizio\":"."\"$oggTorneo->inizio\",";
        echo "\"data_f_iscrizioni\":"."\"$oggTorneo->Fiscirizioni\",";
        echo "\"data_fine\":"."\"$oggTorneo->fine\",";
        echo "\"max_anno\":"."\"$oggTorneo->max_anno\",";
        echo "\"min_anno\":"."\"$oggTorneo->min_anno\",";
        echo "\"info\":"."\"$oggTorneo->info\",";
        echo "\"tipo_sport\":"."\"$oggTorneo->sport\",";
        echo "\"sq_iscritte\":"."\"$squadre_iscritte->numero\",";
        echo "\"sq_n_confermate\":"."\"$proposte_squadre->numero\"";
    echo "}";
} catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;