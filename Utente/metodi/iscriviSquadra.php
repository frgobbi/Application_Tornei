<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 18/04/2017
 * Time: 20:07
 */

/*
 * Legenda:
 * - esito = 0 tutto ha funzionato
 * - esito = 1 iscrizione non riuscita
 * - esito = 2 inseriti giocatori già iscritti con altre sq
 * - esito = 3 num giocatori non sufficente
 * - esito = 4 num giocatori non sufficente e giocatori già iscritti
 */

$username_u = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
$nome_sq = filter_input(INPUT_POST, "nome_sq", FILTER_SANITIZE_STRING);
$id_t = filter_input(INPUT_POST, "id_t", FILTER_SANITIZE_STRING);
$giocoAd = filter_input(INPUT_POST, "gioco", FILTER_SANITIZE_STRING);
$num_g = filter_input(INPUT_POST, "numero_g", FILTER_SANITIZE_STRING);
$giocatori = array();
for ($i = 0; $i <= $num_g; $i++) {
    $keyN = "nome" . $i;
    $keyC = "cognome" . $i;
    $keyD = "data" . $i;
    $keyL = "luogo" . $i;
    $keyCod = "cod" . $i;
    $keyR = "res" . $i;
    $keyS = "sesso" . $i;


    $nome = filter_input(INPUT_POST, $keyN, FILTER_SANITIZE_STRING);
    $cognome = filter_input(INPUT_POST, $keyC, FILTER_SANITIZE_STRING);
    $data = filter_input(INPUT_POST, $keyD, FILTER_SANITIZE_STRING);
    $luogo = filter_input(INPUT_POST, $keyL, FILTER_SANITIZE_STRING);
    $cod = filter_input(INPUT_POST, $keyCod, FILTER_SANITIZE_STRING);
    $res = filter_input(INPUT_POST, $keyR, FILTER_SANITIZE_STRING);
    $sesso = filter_input(INPUT_POST, $keyS, FILTER_SANITIZE_STRING);

    $giocatori[] = array($nome, $cognome, $data, $luogo, $cod, $res, $sesso);
}
$esito = 0;
require "../../Librerie/PDF/PDF.php";


include "../../connessione.php";
try {

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('L', 'A4', 0);
    $pdf->SetFont('Arial', 'B', 35);
    $pdf->setX(8);
    $pdf->SetFontSize(12);
    $pdf->Cell(276, 10, $nome_sq, 1, 0, 'C');
    $pdf->SetX(284);
    $pdf->setY($pdf->GetY() + 10);
    $pdf->SetX(8);
    $pdf->Cell(46, 10, '', 1, 0, 'C');
    $pdf->setX(54);
    $pdf->Cell(46, 10, 'Nome', 1, 0, 'C');
    $pdf->setX(100);
    $pdf->Cell(46, 10, 'Cognome', 1, 0, 'C');
    $pdf->setX(146);
    $pdf->Cell(46, 10, 'Email', 1, 0, 'C');
    $pdf->setX(192);
    $pdf->Cell(46, 10, 'Username', 1, 0, 'C');
    $pdf->setX(238);
    $pdf->Cell(46, 10, 'Password', 1, 0, 'C');
    $pdf->setX(284);

    $connessione->beginTransaction();
    $connessione->exec("INSERT INTO `squadra` (`id_sq`, `nome_sq`, `id_girone`, `id_torneo`, `iscritta`, `eliminata`) VALUES (NULL, '$nome_sq', NULL, '$id_t', '0', '0')");
    $oggS = $connessione->query("SELECT * FROM `squadra` WHERE id_torneo = '$id_t' AND nome_sq = '$nome_sq'")->fetch(PDO::FETCH_OBJ);
    if (strcmp($giocoAd, "si") == 0) {
        $connessione->exec("INSERT INTO `sq_utente` (`id_sq_utente`, `username`, `id_sq`, `make`, `giocatore`) VALUES (NULL, '$username_u', '$oggS->id_sq', '1', '1')");
    } else {
        $connessione->exec("INSERT INTO `sq_utente` (`id_sq_utente`, `username`, `id_sq`, `make`, `giocatore`) VALUES (NULL, '$username_u', '$oggS->id_sq', '1', '0')");
    }
    $oggA = $connessione->query("SELECT * FROM utente WHERE username = '$username_u'")->fetch(PDO::FETCH_OBJ);
    $pdf->setY($pdf->GetY() + 10);
    $pdf->SetX(8);
    $pdf->Cell(46, 10, 'Responsabile', 1, 0, 'C');
    $pdf->setX(54);
    $pdf->Cell(46, 10, $oggA->nome, 1, 0, 'C');
    $pdf->setX(100);
    $pdf->Cell(46, 10, $oggA->cognome, 1, 0, 'C');
    $pdf->setX(146);
    $pdf->Cell(46, 10, $oggA->mail, 1, 0, 'C');
    $pdf->setX(192);
    $pdf->Cell(46, 10, $oggA->username, 1, 0, 'C');
    $pdf->setX(238);
    $pdf->Cell(46, 10, '', 1, 0, 'C');
    $pdf->setX(284);

    for ($i = 0; $i < count($giocatori); $i++) {
        if (strcmp($giocatori[$i][0], "") != 0) {
            $nomeG = $giocatori[$i][0];
            $cognomeG = $giocatori[$i][1];
            $codG = $giocatori[$i][4];

            $oggG = $connessione->query("SELECT * FROM `utente` WHERE nome = '$nomeG' AND cognome= '$cognomeG' AND codice_fiscale = '$codG'")->fetch(PDO::FETCH_OBJ);
            if ($oggG == NULL) {
                $username = strtolower($giocatori[$i][0]) . "." . strtolower($giocatori[$i][1]);
                $contatore = 0;
                foreach ($connessione->query("SELECT * FROM `utente` WHERE username = '$username'") as $row) {
                    $contatore++;
                }
                if ($contatore != 0) {
                    $username .= $contatore;
                }
                $pwd = random_string(8);
                $pwd_cript = password_hash($pwd, PASSWORD_BCRYPT);
                $nomeNew = $giocatori[$i][0];
                $nomeNew = ucfirst($nomeNew);
                $cognomeNew = $giocatori[$i][1];
                $cognomeNew = ucfirst($cognomeNew);
                $dataNew = $giocatori[$i][2];
                $luogoNew = $giocatori[$i][3];
                $codNew = $giocatori[$i][4];
                $resNew = $giocatori[$i][5];
                $sessoNew = $giocatori[$i][6];
                $sql = "INSERT INTO `utente`(`username`, `nome`, `cognome`, `data_nascita`, `codice_fiscale`, `luogo_nascita`, `sesso`, `residenza`, `mail`, `tel`, `pass`, `attivo`, `foto`, `id_cat`, `card`, `saldo`) VALUES "
                    . "('$username','$nomeNew','$cognomeNew','$dataNew','$codNew','$luogoNew','$sessoNew','$resNew',NULL,NULL,'$pwd_cript','1','utente.gif','4',NULL,'0')";
                $connessione->exec($sql);

                $connessione->exec("INSERT INTO `sq_utente` (`id_sq_utente`, `username`, `id_sq`, `make`, `giocatore`) VALUES (NULL, '$username', '$oggS->id_sq', '0', '1')");
                $pdf->setY($pdf->GetY() + 10);
                $pdf->SetX(8);
                $pdf->Cell(46, 10, 'Nuovo utente', 1, 0, 'C');
                $pdf->setX(54);
                $pdf->Cell(46, 10, $nomeNew, 1, 0, 'C');
                $pdf->setX(100);
                $pdf->Cell(46, 10, $cognomeNew, 1, 0, 'C');
                $pdf->setX(146);
                $pdf->Cell(46, 10, '', 1, 0, 'C');
                $pdf->setX(192);
                $pdf->Cell(46, 10, $username, 1, 0, 'C');
                $pdf->setX(238);
                $pdf->Cell(46, 10, $pwd, 1, 0, 'C');
                $pdf->setX(284);
            } else {
                $sql = "SELECT * FROM `sq_utente` "
                    . "INNER JOIN utente ON sq_utente.username = utente.username "
                    . "INNER JOIN squadra ON sq_utente.id_sq = squadra.id_sq "
                    . "WHERE utente.username = '$oggG->username' AND squadra.id_torneo = '$id_t'";
                $righe = $connessione->query($sql)->rowCount();
                if ($righe == 0) {
                    $connessione->exec("INSERT INTO `sq_utente` (`id_sq_utente`, `username`, `id_sq`, `make`, `giocatore`) VALUES (NULL, '$oggG->username', '$oggS->id_sq', '0', '1')");
                    $pdf->setY($pdf->GetY() + 10);
                    $pdf->SetX(8);
                    $pdf->Cell(46, 10, 'Account esistente', 1, 0, 'C');
                    $pdf->setX(54);
                    $pdf->Cell(46, 10, $oggG->nome, 1, 0, 'C');
                    $pdf->setX(100);
                    $pdf->Cell(46, 10, $oggG->cognome, 1, 0, 'C');
                    $pdf->setX(146);
                    $pdf->Cell(46, 10, $oggG->mail, 1, 0, 'C');
                    $pdf->setX(192);
                    $pdf->Cell(46, 10, $oggG->username, 1, 0, 'C');
                    $pdf->setX(238);
                    $pdf->Cell(46, 10, '', 1, 0, 'C');
                    $pdf->setX(284);
                } else {
                    $esito = 2;
                }
            }
        }
    }

    $num_g = $connessione->query("SELECT * FROM `sq_utente` WHERE id_sq = '$oggS->id_sq'")->rowCount();
    $oggT = $connessione->query("SELECT * FROM torneo WHERE id_torneo = '$id_t'")->fetch(PDO::FETCH_OBJ);
    if ($num_g < $oggT->num_giocatori_min) {
        if ($esito == 2) {
            $esito = 4;
        } else {
            $esito = 3;
        }
    } else {
        $connessione->exec("UPDATE `squadra` SET `iscritta` = '1' WHERE `squadra`.`id_sq` = '$oggS->id_sq'");
    }
    $connessione->commit();


    $nomefile = $nome_sq . ".pdf";
    $percorso = "../Files/$nomefile";
    $pdf->Output('F', $percorso);

    $pdf->Close();

    include "../../Librerie/Mail/oggettoMail.php";

    $mail->addAddress($oggA->mail, $oggA->nome);     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('torneosupernova@gmail.com', 'Staff Supernova');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

    $mail->addAttachment($percorso);         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Iscrizione Squadra';
    $mail->Body = 'In allegato il file con gli username e le password per accedere alla piattaforma, per i nuovi iscritti';
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients";
    if (!$mail->send()) {
        //echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        //echo 'Message has been sent';
    }
    $mail = null;

} catch (PDOException $e) {
    echo $e->getMessage();
    $connessione->rollBack();
    $esito = 1;
}
$connessione = null;

unlink($percorso);
echo $esito;
function random_string($length)
{
    $string = "";

    // genera una stringa casuale che ha lunghezza
    // uguale al multiplo di 32 successivo a $length
    for ($i = 0; $i <= ($length / 32); $i++)
        $string .= md5(time() + rand(0, 99));

    // indice di partenza limite
    $max_start_index = (32 * $i) - $length;

    // seleziona la stringa, utilizzando come indice iniziale
    // un valore tra 0 e $max_start_point
    $random_string = substr($string, rand(0, $max_start_index), $length);

    return $random_string;
}


