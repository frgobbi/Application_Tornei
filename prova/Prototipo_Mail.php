<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 23/11/2016
 * Time: 14:19
 */
function mailIscrizione($nome, $cognome, $username)
{
    $dominio = $_SERVER['SERVER_NAME'];
    $url = "$dominio/login-singup-logout/metodi/abilitazione.php?utente=$username";
    $body = "<div style=\"width: 400px; height:500px; border: 2px solid #428bca;\">"
        . "<div style=\"padding: 10px;\">"
        . "<h3 style=\"font-family: Comic Sans MS; font-size: 25px; text-align: center; color: #55ccff;\">Ciao francesco Gobbi Completa la tua iscrizione!</h3>"
        . "</div>"
        . "<div style=\"padding: 2px;\">"
        . "<p style=\"text-align: center; font-family: Comic Sans MS; font-size: 20px; font-weight: bold;\">Per completare la tua iscrizione clicca sul bottone sottostante</p>"
        . "</div>"
        . "<div style=\"padding: 5px;\"><a href=\"$url\"><button style=\"background-color: #5cb85c; width: 100%; height: 50px; border-radius: 15px; font-family: Comic Sans MS; font-size: 22px; text-align: center; color: white; font-weight: bold;\" type=\"button\">Conferma la tua iscrizione</button></a></div>"
        . "</div>";
    return $body;
}
