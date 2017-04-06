<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 05/04/2017
 * Time: 22:52
 */
$id_f = filter_input(INPUT_GET,"id_f",FILTER_SANITIZE_STRING);
$esito = 1;
include "../../connessione.php";
try{
    $sql = "SELECT `id_foto`, `nome_foto`, nome_cartella FROM `foto` "
    ."INNER JOIN cartelle_f ON foto.id_c = cartelle_f.id_c WHERE id_foto = '$id_f'";
    $oggF=$connessione->query($sql)->fetch(PDO::FETCH_OBJ);
    $percorso = "../../Immagini/".$oggF->nome_cartella."/".$oggF->nome_foto;
    unlink($percorso);
    $connessione->exec("DELETE FROM `foto` WHERE id_foto = '$id_f'");
} catch (PDOException $e){
    $esito=0;
}
$connessione = null;
echo $esito;