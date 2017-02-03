<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 15/11/2016
 * Time: 10:17
 */

$tipo_sport = "CREATE TABLE tipo_sport("
	." id_tipo_sport INT PRIMARY KEY AUTO_INCREMENT,"
    ." descrizione VARCHAR(255) NOT NULL,"
    ." logo TEXT"
.")";

$torneo = "CREATE TABLE torneo ("
    ."id_torneo INT PRIMARY KEY AUTO_INCREMENT,"
    ."nome_torneo VARCHAR(255) NOT NULL,"
    ."id_sport INT,"
    ."FOREIGN KEY(id_sport) REFERENCES tipo_sport(id_tipo_sport),"
    ."min_sq INT NOT NULL,"
    ."max_sq INT NOT NULL,"
    ."num_giocatori INT NOT NULL,"
    ."data_inizio DATE,"
    ."data_f_iscrizioni DATE,"
    ."data_fine DATE,"
    ."min_anno INT,"
    ."max_anno INT,"
    ."logo_torneo TEXT,"
    ."color VARCHAR(255),"
    ."info TEXT,"
    ."finished INT NOT NULL DEFAULT '0'"
.")";

$funzioni = "CREATE TABLE funzioni("
    ."id_funzione INT PRIMARY KEY AUTO_INCREMENT,"
    ."nome_funzione VARCHAR(255) NOT NULL,"
    ."colore TEXT,"
    ."src TEXT,"
    ."icona TEXT"
.")";

$cat_utente = "CREATE TABLE cat_utente("
    ."id_cat_utente INT PRIMARY KEY AUTO_INCREMENT,"
    ."nome_cat VARCHAR(255)"
.")";

$funzioni_cat_utente = "CREATE TABLE funzioni_cat_utente("
    ."id_cat_utente INT,"
    ."FOREIGN KEY(id_cat_utente) REFERENCES cat_utente(id_cat_utente),"
    ."id_funzione INT,"
    ."FOREIGN KEY(id_funzione) REFERENCES funzioni(id_funzione),"
    ."abilitato INT NOT NULL DEFAULT '1',"
    ."PRIMARY KEY(id_cat_utente, id_funzione)"
.")";

$utente = "CREATE TABLE utente ("
    ."username VARCHAR(255) PRIMARY KEY,"
    ."nome VARCHAR(255),"
    ."cognome VARCHAR(255),"
    ."data_nascita DATE,"
    ."codice_fiscale VARCHAR(20),"
    ."luogo_nascita VARCHAR(255),"
    ."sesso VARCHAR(1),"
    ."residenza TEXT,"
    ."mail VARCHAR(255),"
    ."tel VARCHAR(255),"
    ."pass VARCHAR(255),"
    ."attivo INT NOT NULL DEFAULT '0',"
    ."foto TEXT,"
    ."id_cat INT,"
    ."FOREIGN KEY(id_cat) REFERENCES cat_utente(id_cat_utente),"
    ."card varchar(10)"
.")";

$girone = "CREATE TABLE girone ("
    ."id_girone INT PRIMARY KEY AUTO_INCREMENT,"
    ."nome_girone VARCHAR(255)"
.")";

$squadra = "CREATE TABLE squadra ("
    ."id_sq INT PRIMARY KEY AUTO_INCREMENT,"
    ."nome_sq VARCHAR(255),"
    ."id_girone INT,"
    ."FOREIGN KEY(id_girone) REFERENCES girone(id_girone),"
    ."id_torneo INT,"
    ."FOREIGN KEY(id_torneo) REFERENCES torneo(id_torneo),"
    ."iscritta INT NOT NULL DEFAULT '0',"
    ."eliminata INT NOT NULL DEFAULT '0'"
.")";

$sq_utente = "CREATE TABLE sq_utente("
    ."id_sq_utente INT PRIMARY KEY AUTO_INCREMENT,"
    ."username VARCHAR(255),"
    ."FOREIGN KEY(username) REFERENCES utente(username),"
    ."id_sq INT,"
    ."FOREIGN KEY(id_sq) REFERENCES squadra(id_sq),"
    ."make INT NOT NULL DEFAULT '0',"
    ."giocatore INT NOT NULL DEFAULT '1'"
.")";

$partita ="CREATE TABLE partita ("
    ."id_partita INT PRIMARY KEY AUTO_INCREMENT,"
    ."data_partita DATE,"
    ."ora_partita TIME,"
    ."luogo VARCHAR(255) NOT NULL DEFAULT 'Campo 1',"
    ."fase_finale INT NOT NULL DEFAULT '0',"
    ."finish INT NOT NULL DEFAULT '0'"
.")";

$sq_partita = "CREATE TABLE sq_partita("
    ."id_sq INT,"
    ."FOREIGN KEY(id_sq) REFERENCES squadra(id_sq),"
    ."id_partita INT,"
    ."FOREIGN KEY(id_partita) REFERENCES partita(id_partita),"
    ."vittoria INT NOT NULL DEFAULT '0',"
    ."sconfitta INT NOT NULL DEFAULT '0',"
    ."pareggio INT NOT NULL DEFAULT '0',"
    ."sconfitta_punti INT NOT NULL DEFAULT '0',"
    ."PRIMARY KEY(id_sq,id_partita)"
.")";

$tempo = "CREATE TABLE tempo("
    ."id_tempo INT PRIMARY KEY AUTO_INCREMENT,"
    ."descrizione VARCHAR(255)"
.")";

$sq_tempo = "CREATE TABLE sq_tempo("
    ."id_sq INT,"
    ."id_partita INT,"
    ."id_tempo INT,"
    ."FOREIGN KEY(id_sq) REFERENCES squadra(id_sq),"
    ."FOREIGN KEY(id_partita) REFERENCES partita(id_partita),"
    ."FOREIGN KEY(id_tempo) REFERENCES tempo(id_tempo),"
    ."punti INT NOT NULL DEFAULT '0',"
    ."PRIMARY KEY(id_sq,id_partita,id_tempo),"
    ."conclused INT NOT NULL DEFAULT '0'"
.")";

$info_tempo = "CREATE TABLE info_tempo("
    ."id_info INT PRIMARY KEY AUTO_INCREMENT,"
    ."id_sq_utente INT,"
    ."id_tempo INT,"
    ."id_partita INT,"
    ."FOREIGN KEY(id_partita) REFERENCES partita(id_partita),"
    ."FOREIGN KEY(id_sq_utente) REFERENCES sq_utente(id_sq_utente),"
    ."FOREIGN KEY(id_tempo) REFERENCES tempo(id_tempo),"
    ."punto INT NOT NULL DEFAULT '0',"
    ."cartellino_giallo INT NOT NULL DEFAULT '0',"
    ."cartellino_rosso INT NOT NULL DEFAULT '0'"
.")";

include "../connessione.php";
try{
    $connessione->exec($tipo_sport);
    $connessione->exec($torneo);
    $connessione->exec($funzioni);
    $connessione->exec($cat_utente);
    $connessione->exec($funzioni_cat_utente);
    $connessione->exec($utente);
    $connessione->exec($girone);
    $connessione->exec($squadra);
    $connessione->exec($sq_utente);
    $connessione->exec($partita);
    $connessione->exec($sq_partita);
    $connessione->exec($tempo);
    $connessione->exec($sq_tempo);
    $connessione->exec($info_tempo);
} catch (PDOException $e){
    echo "error: ".$e->getMessage();
}
$connessione = null;