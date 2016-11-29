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
    ."data_inizio DATETIME,"
    ."data_fine DATETIME,"
    ."logo_torneo TEXT,"
    ."color VARCHAR(255)"
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
    ."residenza TEXT,"
    ."mail VARCHAR(255),"
    ."tel VARCHAR(255),"
    ."pass VARCHAR(255),"
    ."attivo INT NOT NULL DEFAULT '0',"
    ."foto TEXT,"
    ."id_cat INT,"
    ."FOREIGN KEY(id_cat) REFERENCES cat_utente(id_cat_utente)"
.")";
include "../connessione.php";
try{
    $connessione->exec($tipo_sport);
    $connessione->exec($torneo);
    $connessione->exec($funzioni);
    $connessione->exec($cat_utente);
    $connessione->exec($funzioni_cat_utente);
    $connessione->exec($utente);
} catch (PDOException $e){
    echo "error: ".$e->getMessage();
}
$connessione = null;