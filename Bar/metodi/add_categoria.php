<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 02/03/2017
 * Time: 15:36
 */
$nome = filter_input(INPUT_POST,"nome_cat",FILTER_SANITIZE_STRING);
$colore = filter_input(INPUT_POST,"colore",FILTER_SANITIZE_STRING);
include "../../connessione.php";
try{
    $connessione->exec("INSERT INTO `cat_prodotto`(`id_cat_prodotto`, `nome_cat`, `colore`) VALUES (NULL,'$nome','$colore')");
}catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;
header("Location:../Bar.php");