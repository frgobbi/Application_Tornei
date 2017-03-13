<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 30/11/2016
 * Time: 15:13
 */
session_start();
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
$tel = filter_input(INPUT_POST,"tel",FILTER_SANITIZE_STRING);
$utente= $_SESSION['username'];
include "../../connessione.php";
try{
    $connessione->exec("UPDATE `utente` SET `mail` = '$email' WHERE `utente`.`username` = '$utente'");
    $connessione->exec("UPDATE `utente` SET `tel` = '$tel' WHERE `utente`.`username` = '$utente'");
}
catch (PDOException $e){
    echo"errore: ".$e->getMessage();
}

if(isset($_FILES['foto_profilo']) && $_FILES['foto_profilo']['tmp_name']) {
    try {
        $oggUtente = $connessione->query("SELECT * FROM utente WHERE username = '$utente'")->fetch(PDO::FETCH_OBJ);

    //$nomeFoto = $utente->nome."_".$utente->cognome;


    if(strcmp($oggUtente->foto,"utente.gif") !=0){
        if (is_file("../../Immagini/Immagini_Profilo/".$oggUtente->foto)) {
            unlink("../../Immagini/Immagini_Profilo/".$oggUtente->foto);
        }
    }

    $nomeF = $_FILES['foto_profilo']['name'];
    $estensione = $_FILES['foto_profilo']['type'];

    $app = explode("/", $estensione);
    $ex = $app[1];


    //$nomeF =$matricola.".".$estensione;
    $foto = $oggUtente->nome . "_" . $oggUtente->cognome . "." . $ex;
    $tmpNome = $_FILES['foto_profilo']['tmp_name'];
    move_uploaded_file($tmpNome, "../../Immagini/Immagini_Profilo/" . $foto);

        $connessione->exec("UPDATE `utente` SET `foto` = '$foto' WHERE `utente`.`username` = '$utente'");
    } catch (PDOException $e) {
        echo "error: " . $e->getMessage();
    }
}
$connessione=null;
header("Location:../Profilo.php");