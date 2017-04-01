<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 15/11/2016
 * Time: 14:08
 */
$tipo_sport = "INSERT INTO `tipo_sport`(`id_tipo_sport`, `descrizione`, `logo`)"
    ." VALUES (NULL, 'Calcio','fa-futbol-o'),(NULL, 'Calcio a 5','fa-futbol-o'),(NULL, 'Calcio a 7','fa-futbol-o'),"
    ."(NULL, 'Beach-Volley',NULL),(NULL, 'Tennis',NULL)";

$cat_utente = "INSERT INTO `cat_utente`(`id_cat_utente`, `nome_cat`) VALUES (NULL,'Admin'),(NULL,'Staff'),(NULL, 'Bar'),(NULL,'Utente')";

$pass= "123456";
$pass = password_hash($pass,PASSWORD_BCRYPT);

$utente = "INSERT INTO `utente`(`username`, `nome`, `cognome`, `data_nascita`, `codice_fiscale`, `luogo_nascita`, `sesso`, `residenza` ,`mail`, `tel`, `pass`, `attivo`, `foto`, `id_cat`,`card`) "
    ."VALUES ('admin', 'admin', NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, '$pass', '1', 'utente.gif', '1', NULL),"
    ."('staff', 'staff', NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, '$pass', '1', 'utente.gif', '2', NULL),"
    ."('bar', 'bar', NULL, NULL, NULL, NULL, 'M', NULL, NULL, NULL, '$pass', '1', 'utente.gif', '3', NULL),"
    ."('francesco.gobbi', 'Francesco', 'Gobbi', '1997-06-03', 'GBBFNC97H03G478G', 'Perugia', 'M', 'Via Montiano 5 Corciano', 'gobbi03.fg@gmail.com', '3475057671', '$pass', '1', 'utente.gif', '4', NULL),"
    ."('criambro', 'Cristiano', 'Ambrogi', '1998-07-06', NULL, 'Perugia', 'M', NULL, NULL, NULL, '$pass', 1, 'utente.gif', 4, NULL),"
    ."('megafono', 'Massimiliano', 'Avanai', '1998-11-22', NULL, 'Perugia', 'M', NULL, NULL, NULL, '$pass', 1, 'utente.gif', 4, NULL),"
    ."('tosca', 'Dante', 'Toscano', '1997-11-13', NULL, 'Perugia', 'M', NULL, 'riccardomigni@gmail.com', 'NULL', '$pass', 1, 'utente.gif', 4, NULL),"
    ."('tommicacc', 'Cacchiata', 'Tommaso', '1997-01-12', NULL, 'Perugia', 'M', NULL, NULL, NULL, '$pass', 1, 'utente.gif', 4, NULL);";

$funzioni = "INSERT INTO `funzioni`(`id_funzione`, `nome_funzione`, `colore`, `src`, `icona`) VALUES "
    ."(NULL, 'Tornei','red','Staff/Torneo.php','fa-calendar-o'),"
    ."(NULL, 'Bar', 'yellow', 'Bar/Bar.php', 'fa-shopping-basket'),"
    ."(NULL, 'Notizie', 'link', 'Staff/Notizie.php', 'fa-newspaper-o'),"
    ."(NULL, 'Foto', 'success', 'Staff/Foto.php', 'fa-camera-retro')";

$funzioni_cat_utente = "INSERT INTO `funzioni_cat_utente` (`id_cat_utente`, `id_funzione`, `abilitato`)"
." VALUES ('1', '1', '1'), ('2', '1', '1'), ('1', '2', '1'), ('3', '2', '1'), ('1', '3', '1'), ('2', '3', '1')"
.",('1', '4', '1'), ('2', '4', '1')";

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
    

include "../connessione.php";
try{
    $connessione->exec($tipo_sport);
    $connessione->exec($cat_utente);
    $connessione->exec($utente);
    $connessione->exec($funzioni);
    $connessione->exec($funzioni_cat_utente);
    $connessione->exec($tempo);
    $connessione->exec($gironi);
} catch (PDOException $e){
    echo "error: ".$e->getMessage();
}
$connessione = null;