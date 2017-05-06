<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 03/12/2016
 * Time: 14:42
 */
$mail = filter_input(INPUT_GET, "mail",FILTER_SANITIZE_STRING);
include "../../connessione.php";
$esito = 0;
try{
    $oggU = $connessione->query("SELECT * FROM utente WHERE mail = '$mail'")->fetch(PDO::FETCH_OBJ);
    if($oggU == NULL){
        $esito = 2;
    } else{
        $connessione->exec("UPDATE `utente` SET `new_pas` = '1' WHERE `utente`.`username` = '$oggU->username'");
        $dominio = $_SERVER['SERVER_NAME'];
        $url = "$dominio/login-singup-logout/Reimposta.php?utente=$oggU->username";
        $corpo = "<p>Ciao $oggU->nome $oggU->cognome, il tuo username e' $oggU->username</p>"
            ."<p>Per reimpostare la password clicca sul bottone qua sotto</p>"
            ."<a href=\"$url\"><button style='width: 300px; height:70px;  border: 1px solid; border-radius: 15px; background-color: #0099FF;'>Reimposta la password</button></a>";

        include "../../Librerie/Mail/Prototipo_Mail.php";
        include "../../Librerie/Mail/oggettoMail.php";

        $mail->addAddress($oggU->mail, $oggU->nome);     // Add a recipient
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = "Recupero Dati";
        $mail->Body    = $corpo;
        if(!$mail->send()) {
            $esito = 1;
            //echo 'Message could not be sent.';
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            //echo 'Message has been sent';
        }
        $mail = null;
    }
} catch (PDOException $e){
    $e->getMessage();
}
$connessione = NULL;
echo $esito;