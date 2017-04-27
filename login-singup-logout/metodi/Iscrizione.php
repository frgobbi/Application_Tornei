<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$nome = filter_input(INPUT_POST, "nome_utente", FILTER_SANITIZE_STRING);
$nome = ucfirst($nome);
$cognome = filter_input(INPUT_POST, "cognome_utente", FILTER_SANITIZE_STRING);
$cognome = ucfirst($cognome);
$data_nascita = filter_input(INPUT_POST, "data_utente", FILTER_SANITIZE_STRING);
$luogo_nascita = filter_input(INPUT_POST, "luogo_utente", FILTER_SANITIZE_STRING);
$luogo_nascita = ucfirst($luogo_nascita);
$cod_fiscale = filter_input(INPUT_POST, "codice_utente", FILTER_SANITIZE_STRING);
$residenza = filter_input(INPUT_POST, "residenza_utente", FILTER_SANITIZE_STRING);
$residenza = ucfirst($residenza);
$username = filter_input(INPUT_POST, "username_utente", FILTER_SANITIZE_STRING);
$mail_utente = filter_input(INPUT_POST, "email_utente", FILTER_SANITIZE_STRING);
$pwd = filter_input(INPUT_POST, "pass_utente", FILTER_SANITIZE_STRING);
$pwd_criptata = password_hash($pwd, PASSWORD_BCRYPT);
$telefono = filter_input(INPUT_POST, "tel_utente", FILTER_SANITIZE_STRING);
$sesso = filter_input(INPUT_POST, "sesso", FILTER_SANITIZE_STRING);


//echo $nome."<br>".$cognome."<br>".$data_nascita."<br>".$luogo_nascita."<br>"
  //  .$cod_fiscale."<br>".$residenza."<br>".$username."<br>".$mail."<br>".$pwd_criptata."<br>".$telefono;

include "../../connessione.php";
try{
    if(strcmp($telefono, "")==0){
        $connessione->exec("INSERT INTO `utente` (`username`, `nome`, `cognome`, `data_nascita`, `codice_fiscale`, `luogo_nascita`, `sesso`, `residenza`, `mail`, `tel`, `pass`, `attivo`, `foto`, `id_cat`,`card`)"
            ." VALUES ('$username', '$nome', '$cognome', '$data_nascita', '$cod_fiscale', '$luogo_nascita', '$sesso', '$residenza', '$mail_utente', NULL, '$pwd_criptata', '0', 'utente.gif', '4', NULL)");
    } else {
        $connessione->exec("INSERT INTO `utente` (`username`, `nome`, `cognome`, `data_nascita`, `codice_fiscale`, `luogo_nascita`, `sesso`, `residenza`, `mail`, `tel`, `pass`, `attivo`, `foto`, `id_cat`,`card`)"
            ." VALUES ('$username', '$nome', '$cognome', '$data_nascita', '$cod_fiscale', '$luogo_nascita', '$sesso', '$residenza', '$mail_utente', '$telefono', '$pwd_criptata', '0', 'utente.gif', '4', NULL)");
    }
} catch (PDOException $e){
    echo"<script>alert('Non e\' stato possibile eseguire l\'iscrizione... Riprova piu\' tardi ');</script>";
    header('Refresh: 0.05; url=../Sing_up.php');
}
$connessione = null;

include "../../Librerie/Mail/Prototipo_Mail.php";
include "../../Librerie/Mail/oggettoMail.php";

$mail->addAddress($mail_utente, $nome);     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('torneosupernova@gmail.com', 'Staff Supernova');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML
$corpo = mailIscrizione($nome,$cognome,$username);
$mail->Subject = 'Sei Iscritto';
$mail->Body    = $corpo;
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients";
if(!$mail->send()) {
    //echo 'Message could not be sent.';
    //echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    //echo 'Message has been sent';
}
$mail = null;
echo "<script type='text/javascript'>window.location.href='../Iscritto.php?user=$username'</script>";
//header('Refresh: 0.05; url=../Iscritto.php?user='.$username);
?>


