<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 07/04/2017
 * Time: 20:24
 */
$id_cartella = filter_input(INPUT_GET,"id_f",FILTER_SANITIZE_STRING);
$del = filter_input(INPUT_GET,"del",FILTER_SANITIZE_STRING);
$esito = 1;
include "../../connessione.php";
try{
    $sql = "SELECT `id_foto`, `nome_foto`, nome_cartella FROM `foto` "
        ."INNER JOIN cartelle_f ON foto.id_c = cartelle_f.id_c WHERE cartelle_f.id_c = '$id_cartella'";
    foreach ($connessione->query($sql) as $row){
        $id_f = $row['id_foto'];
        $nome_cartella = $row['nome_cartella'];
        $percorso = "../../Immagini/".$nome_cartella."/".$row['nome_foto'];
        unlink($percorso);
        $connessione->exec("DELETE FROM `foto` WHERE id_foto = '$id_f'");
    }
    $sql = "SELECT nome_cartella FROM `cartelle_f` WHERE cartelle_f.id_c = '$id_cartella'";
    $oggF=$connessione->query($sql)->fetch(PDO::FETCH_OBJ);
    if($del==1){
        $connessione->exec("DELETE FROM `cartelle_f` WHERE id_c = '$id_cartella'");
        $percorso = "../../Immagini/".$oggF->nome_cartella;
        rmdir($percorso);
    }
} catch (PDOException $e){
    $esito=0;
}
$connessione = null;
echo $esito;