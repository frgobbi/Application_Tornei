<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 29/11/2016
 * Time: 10:45
 */
$esito = 0;
$user = filter_input(INPUT_GET, "user",FILTER_SANITIZE_STRING);
include "../../connessione.php";
try{
    $utente = $connessione->query("SELECT * FROM utente WHERE username = $user")->fetch(PDO::FETCH_OBJ);
} catch(PDOException $e){
    echo "error:".$e->getMessage();
}
$connessione = null;


include "../../Librerie/Mail/Prototipo_Mail.php";
include "../../Librerie/Mail/oggettoMail.php";
$mittente = $utente->nome." ".$utente->cognome;
$mail->addAddress($utente->mail, $mittente);     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('torneosupernova@gmail.com', 'Staff Supernova');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML
$corpo = mailIscrizione($utente->nome,$utente->cognome,$utente->username);
$mail->Subject = 'Sei Iscritto';
$mail->Body    = $corpo;
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients";
if(!$mail->send()) {
    //echo 'Message could not be sent.';
    //echo 'Mailer Error: ' . $mail->ErrorInfo;
    $esito = 1;
} else {
    //echo 'Message has been sent';
}
$mail = null;
echo $esito;