<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 03/03/2017
 * Time: 13:12
 */
$nome = filter_input(INPUT_POST,"nome_p",FILTER_SANITIZE_STRING);
$prezzo = filter_input(INPUT_POST,"prezzo",FILTER_SANITIZE_STRING);
$cat = filter_input(INPUT_POST,"categoria",FILTER_SANITIZE_STRING);
$vendibile = filter_input(INPUT_POST,"vendibile",FILTER_SANITIZE_STRING);
$prezzo = doubleval($prezzo);
if(strcmp($vendibile,"")==0){
    $vendibile =0;
}

include "../../connessione.php";
try{
    $connessione->exec("INSERT INTO `prodotto` (`id_prodotto`, `nome_prodotto`, `prezzo`, `vendibile`, `id_cat_prodotto`) VALUES (NULL, '$nome', '$prezzo', '$vendibile', '$cat');");
}catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;
header("Location:../Bar.php");
