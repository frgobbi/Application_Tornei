<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 15/11/2016
 * Time: 14:08
 */
$tipo_sport = "INSERT INTO `tipo_sport`(`id_tipo_sport`, `descrizione`, `logo`, `colore`) VALUES "
        ."(NULL, 'Calcio','fa-futbol-o','red'),"
        ."(NULL, 'Calcio a 5','fa-futbol-o','yellow'),"
        ."(NULL, 'Calcio a 7','fa-futbol-o','success'),"
        ."(NULL, 'Beach-Volley','fa-trophy','primary'),"
        ."(NULL, 'Tennis','fa-trophy','green'),"
        ."(NULL, 'Biliardino','fa-trophy','info')";
$cat_utente = "INSERT INTO `cat_utente`(`id_cat_utente`, `nome_cat`) VALUES (NULL,'Admin'),(NULL,'Staff'),(NULL, 'Bar'),(NULL,'Utente')";
$pass= "123456";
$pass = password_hash($pass,PASSWORD_BCRYPT);
$utente = "INSERT INTO `utente`(`username`, `nome`, `cognome`, `data_nascita`, `codice_fiscale`, `luogo_nascita`, `sesso`, `residenza` ,`mail`, `tel`, `pass`, `attivo`, `foto`, `id_cat`,`card`, `new_pas`) "
    ."VALUES ('admin', 'admin', NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, '$pass', '1', 'utente.gif', '1', NULL,0),"
    ."('staff', 'staff', NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, '$pass', '1', 'utente.gif', '2', NULL,0),"
    ."('bar', 'bar', NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, '$pass', '1', 'utente.gif', '3', NULL,0),"
    ."('francesco.gobbi', 'Francesco', 'Gobbi', '1997-06-03', 'GBBFNC97H03G478G', 'Perugia', 'M', 'Via Montiano 5 Corciano', 'gobbi03.fg@gmail.com', '3475057671', '$pass', '1', 'utente.gif', '4', NULL,'0')";
$funzioni = "INSERT INTO `funzioni`(`id_funzione`, `nome_funzione`, `colore`, `src`, `icona`) VALUES "
    ."(NULL, 'Tornei','red','Staff/Torneo.php','fa-calendar-o'),"
    ."(NULL, 'Bar', 'yellow', 'Bar/Bar.php', 'fa-shopping-basket'),"
    ."(NULL, 'Notizie', 'link', 'News/Notizie.php', 'fa-newspaper-o'),"
    ."(NULL, 'Foto', 'success', 'Gestine_Foto/Foto.php', 'fa-camera-retro'),"
    ."(NULL, 'Iscrizione', 'primary', 'Utente/Tornei_disp.php', 'fa-pencil-square-o'),"
    ."(NULL, 'Squadre', 'info', 'Utente/My_Tornei.php', 'fa fa-cog')";
$funzioni_cat_utente = "INSERT INTO `funzioni_cat_utente` (`id_cat_utente`, `id_funzione`, `abilitato`)"
." VALUES ('1', '1', '1'), ('2', '1', '1'), ('1', '2', '1'), ('3', '2', '1'), ('1', '3', '1'), ('2', '3', '1')"
.",('1', '4', '1'), ('2', '4', '1'),('4','5','1'),('4','6','1')";
$tempo = "INSERT INTO `tempo` (`id_tempo`,`descrizione`) VALUES"
    ."(NULL, '1° Tempo'),"
    ."(NULL, '2° Tempo'),"
    ."(NULL, '1° Tempo supplementare'),"
    ."(NULL, '2° Tempo supplementare'),"
    ."(NULL, 'Rigori'),"
    ."(NULL, '1° Set'),"
    ."(NULL, '2° Set'),"
    ."(NULL, '3° Set'),"
    ."(NULL, '4° Set'),"
    //."(NULL, '5° Set'),"
    ."(NULL, 'Tie Break')";
$gironi ="INSERT INTO `girone` (`id_girone`, `nome_girone`) VALUES "
    ."(NULL, 'A'), "
    ."(NULL, 'B'), "
    ."(NULL, 'C'), "
    ."(NULL, 'D'), "
    ."(NULL, 'E'), "
    ."(NULL, 'F'), "
    ."(NULL, 'G'), "
    ."(NULL, 'H'), "
    ."(NULL, 'I'), "
    ."(NULL, 'Fasi Finali'),"
    ."(NULL, 'Fasi Finali Torneo Superiore'),"
    ."(NULL, 'Fasi Finali Torneo Inferiore')";
$cartelle_c = "INSERT INTO `cartelle_f`(`id_c`, `nome_cartella`, `colore`) VALUES (NULL,'Vecchi_Tornei','primary')";
include "../connessione.php";
try{
    $connessione->exec($tipo_sport);
    $connessione->exec($cat_utente);
    $connessione->exec($utente);
    $connessione->exec($funzioni);
    $connessione->exec($funzioni_cat_utente);
    $connessione->exec($tempo);
    $connessione->exec($gironi);
    $connessione->exec($cartelle_c);
} catch (PDOException $e){
    echo "error: ".$e->getMessage();
}
$connessione = null;