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
    ."logo_torneo TEXT,"
    ."color VARCHAR(255),"
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
    ."FOREIGN KEY(id_torneo) REFERENCES torneo(id_torneo)"
.")";

$sq_utente = "CREATE TABLE sq_utente("
    ."username VARCHAR(255),"
    ."FOREIGN KEY(username) REFERENCES utente(username),"
    ."id_sq INT,"
    ."FOREIGN KEY(id_sq) REFERENCES squadra(id_sq),"
    ."make INT NOT NULL DEFAULT '0',"
    ."giocatore INT NOT NULL DEFAULT '1'"
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
} catch (PDOException $e){
    echo "error: ".$e->getMessage();
}
$connessione = null;