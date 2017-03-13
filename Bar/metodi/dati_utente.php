<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 22/02/2017
 * Time: 20:08
 */
$username_u = filter_input(INPUT_GET,"user",FILTER_SANITIZE_STRING);
include "../../connessione.php";
try{
    $oggU =$connessione->query("SELECT * FROM `utente` WHERE username = '$username_u'")->fetch(PDO::FETCH_OBJ);
    $dati= array(
        "nome"=>$oggU->nome,
        "cognome"=>$oggU->cognome,
        "foto"=>$oggU->foto,
        "card"=>$oggU->card,
        "saldo"=>$oggU->saldo
    );
    echo json_encode($dati);
}catch (PDOException $e){
    echo $e->getMessage();
}
$connesione=null;