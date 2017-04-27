<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 15/04/2017
 * Time: 11:58
 */
$nome_sq = filter_input(INPUT_GET,"nome_sq",FILTER_SANITIZE_STRING);
$id_t = filter_input(INPUT_GET,"id_t",FILTER_SANITIZE_STRING);
$c=0;
include "../../connessione.php";
try{
    $parti_nome = explode(" ",$nome_sq);
    $nome="";
    for ($i=0;$i<count($parti_nome);$i++){
        $nome.=$parti_nome[$i];
    }
    $nome=strtoupper($nome);
    foreach ($connessione->query("SELECT * FROM `squadra` WHERE id_torneo = '$id_t'") as $row){
        $parti_nome = explode(" ",$row['nome_sq']);
        $nomeC="";
        for ($i=0;$i<count($parti_nome);$i++){
            $nomeC.=$parti_nome[$i];
        }
        $nomeC=strtoupper($nomeC);
        if(strcmp($nome,$nomeC)==0){
            $c=1;
        }
    }
} catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;
echo $c;