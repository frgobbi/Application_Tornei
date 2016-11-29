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

$cat_utente = "INSERT INTO `cat_utente`(`id_cat_utente`, `nome_cat`) VALUES (NULL,'Admin'),(NULL,'Staff'),(NULL,'Utente')";

$pass= "123456";
$pass = password_hash($pass,PASSWORD_BCRYPT);

$utente = "INSERT INTO `utente`(`username`, `nome`, `cognome`, `data_nascita`, `codice_fiscale`, `luogo_nascita`, `mail`, `tel`, `pass`, `attivo`, `foto`, `id_cat`) "
    ."VALUES ('admin','admin',NULL,NULL,NULL,NULL,NULL,NULL,'$pass',1,NULL, 1)";

include "../connessione.php";
try{
    $connessione->exec($tipo_sport);
    $connessione->exec($cat_utente);
    $connessione->exec($utente);
} catch (PDOException $e){
    echo "error: ".$e->getMessage();
}
$connessione = null;