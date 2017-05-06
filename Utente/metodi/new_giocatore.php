<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 05/05/2017
 * Time: 17:51
 */
$id_t = filter_input(INPUT_GET, "id_t", FILTER_SANITIZE_STRING);
$id_sq = filter_input(INPUT_GET, "id_sq", FILTER_SANITIZE_STRING);

$keyN = "nome";
$keyC = "cognome";
$keyD = "data";
$keyL = "luogo";
$keyCod = "cod";
$keyR = "res";
$keyS = "sesso";

$nome = filter_input(INPUT_POST, $keyN, FILTER_SANITIZE_STRING);
$cognome = filter_input(INPUT_POST, $keyC, FILTER_SANITIZE_STRING);
$data = filter_input(INPUT_POST, $keyD, FILTER_SANITIZE_STRING);
$luogo = filter_input(INPUT_POST, $keyL, FILTER_SANITIZE_STRING);
$cod = filter_input(INPUT_POST, $keyCod, FILTER_SANITIZE_STRING);
$res = filter_input(INPUT_POST, $keyR, FILTER_SANITIZE_STRING);
$sesso = filter_input(INPUT_POST, $keyS, FILTER_SANITIZE_STRING);


$sql = "SELECT `id_torneo`,`nome_torneo`,`min_sq`,`max_sq`,`num_giocatori_min`,`num_giocatori_max`, DATE_FORMAT(data_inizio,'%d-%m-%Y') AS inizio, `data_inizio`, DATE_FORMAT(data_f_iscrizioni,'%d-%m-%Y') AS Fiscirizioni,`data_f_iscrizioni`, DATE_FORMAT(data_fine,'%d-%m-%Y') AS fine,`data_fine`,`info`,tipo_sport.descrizione AS sport, `min_anno`, `max_anno`, `fase_finale`,`finished` "
    . "FROM `torneo` INNER JOIN tipo_sport ON tipo_sport.id_tipo_sport = torneo.id_sport WHERE id_torneo= '$id_t'";

include "../../connessione.php";
try {
    $connessione->beginTransaction();
    $oggA = $connessione->query("SELECT nome,cognome,mail FROM `squadra` INNER JOIN sq_utente ON sq_utente.id_sq = squadra.id_sq INNER JOIN utente ON sq_utente.username = utente.username WHERE squadra.id_sq = '$id_sq' AND make = 1")->fetch(PDO::FETCH_OBJ);
    $oggTorneo = $connessione->query($sql)->fetch(PDO::FETCH_OBJ);
    $oggS = $connessione->query("SELECT * FROM `squadra` WHERE id_sq = '$id_sq'")->fetch(PDO::FETCH_OBJ);

    $oggG = $connessione->query("SELECT * FROM `utente` WHERE nome = '$nome' AND cognome= '$cognome' AND codice_fiscale = '$cod'")->fetch(PDO::FETCH_OBJ);
    if ($oggG == NULL) {
        $username = strtolower($nome) . "." . strtolower($cognome);
        $contatore = 0;
        foreach ($connessione->query("SELECT * FROM `utente` WHERE username = '$username'") as $row) {
            $contatore++;
        }
        if ($contatore != 0) {
            $username .= $contatore;
        }
        $pwd = random_string(8);
        $pwd_cript = password_hash($pwd, PASSWORD_BCRYPT);
        $nomeNew = $nome;
        $nomeNew = ucfirst($nomeNew);
        $cognomeNew = $cognome;
        $cognomeNew = ucfirst($cognomeNew);
        $dataNew = $data;
        $luogoNew = $luogo;
        $codNew = $cod;
        $resNew = $res;
        $sessoNew = $sesso;

        $anno_g = explode("-", $dataNew);

        $esito_i = 1;

        if ($oggTorneo->min_anno != 0) {
            if ($oggTorneo->max_anno != 0) {
                if ($anno_g[0] >= $oggTorneo->max_anno && $anno_g[0] <= $oggTorneo->min_anno) {
                    $sql = "INSERT INTO `utente`(`username`, `nome`, `cognome`, `data_nascita`, `codice_fiscale`, `luogo_nascita`, `sesso`, `residenza`, `mail`, `tel`, `pass`, `attivo`, `foto`, `id_cat`, `card`, `saldo`, `new_pas`) VALUES "
                        . "('$username','$nomeNew','$cognomeNew','$dataNew','$codNew','$luogoNew','$sessoNew','$resNew',NULL,NULL,'$pwd_cript','1','utente.gif','4',NULL,'0','0')";
                    $connessione->exec($sql);
                    $connessione->exec("INSERT INTO `sq_utente` (`id_sq_utente`, `username`, `id_sq`, `make`, `giocatore`) VALUES (NULL, '$username', '$oggS->id_sq', '0', '1')");
                    $esito_i = 0;
                }
            } else {
                if ($anno_g[0] <= $oggTorneo->min_anno) {
                    $sql = "INSERT INTO `utente`(`username`, `nome`, `cognome`, `data_nascita`, `codice_fiscale`, `luogo_nascita`, `sesso`, `residenza`, `mail`, `tel`, `pass`, `attivo`, `foto`, `id_cat`, `card`, `saldo`, `new_pas`) VALUES "
                        . "('$username','$nomeNew','$cognomeNew','$dataNew','$codNew','$luogoNew','$sessoNew','$resNew',NULL,NULL,'$pwd_cript','1','utente.gif','4',NULL,'0','0')";
                    $connessione->exec($sql);
                    $connessione->exec("INSERT INTO `sq_utente` (`id_sq_utente`, `username`, `id_sq`, `make`, `giocatore`) VALUES (NULL, '$username', '$oggS->id_sq', '0', '1')");
                    $esito_i = 0;
                }
            }
        } else{
            if ($oggTorneo->max_anno != 0) {
                if ($anno_g[0] >= $oggTorneo->max_anno) {
                    $sql = "INSERT INTO `utente`(`username`, `nome`, `cognome`, `data_nascita`, `codice_fiscale`, `luogo_nascita`, `sesso`, `residenza`, `mail`, `tel`, `pass`, `attivo`, `foto`, `id_cat`, `card`, `saldo`, `new_pas`) VALUES "
                        . "('$username','$nomeNew','$cognomeNew','$dataNew','$codNew','$luogoNew','$sessoNew','$resNew',NULL,NULL,'$pwd_cript','1','utente.gif','4',NULL,'0','0')";
                    $connessione->exec($sql);
                    $connessione->exec("INSERT INTO `sq_utente` (`id_sq_utente`, `username`, `id_sq`, `make`, `giocatore`) VALUES (NULL, '$username', '$oggS->id_sq', '0', '1')");
                    $esito_i = 0;

                }
            } else {
                $sql = "INSERT INTO `utente`(`username`, `nome`, `cognome`, `data_nascita`, `codice_fiscale`, `luogo_nascita`, `sesso`, `residenza`, `mail`, `tel`, `pass`, `attivo`, `foto`, `id_cat`, `card`, `saldo`,`new_pas`) VALUES "
                    . "('$username','$nomeNew','$cognomeNew','$dataNew','$codNew','$luogoNew','$sessoNew','$resNew',NULL,NULL,'$pwd_cript','1','utente.gif','4',NULL,'0','0')";
                $connessione->exec($sql);
                $connessione->exec("INSERT INTO `sq_utente` (`id_sq_utente`, `username`, `id_sq`, `make`, `giocatore`) VALUES (NULL, '$username', '$oggS->id_sq', '0', '1')");
                $esito_i = 0;
            }
        }

        if($esito_i == 0){
            include "../../Librerie/Mail/oggettoMail.php";

            $mail->addAddress($oggA->mail, $oggA->nome);     // Add a recipient
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Iscrizione Giocatore';
            $mail->Body = "<p>Nuovo Giocatore Inserito</p>"
                ."<p><ul>"
                    ."<li><b>Nome Giocatore:</b> $nomeNew</li>"
                    ."<li><b>Cognome Giocatore:</b> $cognomeNew</li>"
                    ."<li><b>Data di nascita:</b> $dataNew</li>"
                    ."<li><b>Username:</b> $username</li>"
                    ."<li><b>Password:</b> $pwd</li>"
                ."</ul></p>";
            if (!$mail->send()) {
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            }
            $mail = null;
            echo "<script type='application/javascript'>alert('Ti abbiamo inviato i dati del nuovo giocatore!');</script>";
        } else {
            echo "<script type='application/javascript'>alert('Giocatore non può giocare questo torneo');</script>";
        }
    } else {
        $sql = "SELECT * FROM `sq_utente` "
            . "INNER JOIN utente ON sq_utente.username = utente.username "
            . "INNER JOIN squadra ON sq_utente.id_sq = squadra.id_sq "
            . "WHERE utente.username = '$oggG->username' AND squadra.id_torneo = '$id_t'";
        $righe = $connessione->query($sql)->rowCount();
        if ($righe == 0) {
            $anno_g = explode("-", $oggG->data_nascita);
            $esito_i =1;

            if ($oggTorneo->min_anno != 0) {
                if ($oggTorneo->max_anno != 0) {
                    if ($anno_g[0] >= $oggTorneo->max_anno && $anno_g[0] <= $oggTorneo->min_anno) {
                        $connessione->exec("INSERT INTO `sq_utente` (`id_sq_utente`, `username`, `id_sq`, `make`, `giocatore`) VALUES (NULL, '$oggG->username', '$oggS->id_sq', '0', '1')");
                        $esito_i =0;
                    }
                } else {
                    if ($anno_g[0] <= $oggTorneo->min_anno) {
                        $connessione->exec("INSERT INTO `sq_utente` (`id_sq_utente`, `username`, `id_sq`, `make`, `giocatore`) VALUES (NULL, '$oggG->username', '$oggS->id_sq', '0', '1')");
                        $esito_i =0;
                    }
                }
            } else{
                if ($oggTorneo->max_anno != 0) {
                    if ($anno_g[0] >= $oggTorneo->max_anno) {
                        $connessione->exec("INSERT INTO `sq_utente` (`id_sq_utente`, `username`, `id_sq`, `make`, `giocatore`) VALUES (NULL, '$oggG->username', '$oggS->id_sq', '0', '1')");
                        $esito_i =0;
                    }
                }else {
                    $connessione->exec("INSERT INTO `sq_utente` (`id_sq_utente`, `username`, `id_sq`, `make`, `giocatore`) VALUES (NULL, '$oggG->username', '$oggS->id_sq', '0', '1')");
                    $esito_i =0;
                }
            }

            if($esito_i == 0){
                echo "<script type='application/javascript'>alert('Giocatore aggiunto...<br> Il giocatore è già registrato, i dati di accesso sono già in suo possesso');</script>";
            } else {
                echo "<script type='application/javascript'>alert('Giocatore non può giocare questo torneo');</script>";
            }

        } else {
            echo "<script type='application/javascript'>alert('Il giocatore è già iscritto al torneo!');</script>";
        }
    }

    $num_g = $connessione->query("SELECT * FROM `sq_utente` WHERE id_sq = '$oggS->id_sq'")->rowCount();

    if ($num_g >= $oggTorneo->num_giocatori_min) {
        $connessione->exec("UPDATE `squadra` SET `iscritta` = '1' WHERE `squadra`.`id_sq` = '$oggS->id_sq'");
        echo "<script type='application/javascript'>alert('Iscrizione al torneo completata correttamente!');</script>";
    }

    $connessione->commit();
} catch (PDOException $e) {
    echo $e->getMessage();
    $connessione->rollBack();
}
echo "<script type='application/javascript'>window.location.href='../adminMyTornei.php?id_sq=$id_sq&id_t=$id_t'</script>";
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