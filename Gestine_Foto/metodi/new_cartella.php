<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 04/04/2017
 * Time: 13:03
 */
$nome = filter_input(INPUT_POST, "nome_c",FILTER_SANITIZE_STRING);
$colore = filter_input(INPUT_POST, "colore_c",FILTER_SANITIZE_STRING);

include "../../connessione.php";
try{
    $c =0;
    foreach ($connessione->query("SELECT * FROM `cartelle_f`") as $row) {
        if(strcmp($nome,$row['nome_cartella'])==0){
            $c++;
        }
    }
    if($c!=0){
        $nome.=" ($c)";
    }
    $percorso="../../Immagini/".$nome;
    mkdir($percorso);
    $connessione->exec("INSERT INTO `cartelle_f`(`id_c`, `nome_cartella`, `colore`) VALUES (NULL,'$nome','$colore')");
}catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;
header("Location:../Foto.php");
