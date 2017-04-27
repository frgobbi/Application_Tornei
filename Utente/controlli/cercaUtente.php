<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 15/04/2017
 * Time: 19:54
 */
$nome = filter_input(INPUT_GET,"nome",FILTER_SANITIZE_STRING);
$nome= ucfirst($nome);
$cognome = filter_input(INPUT_GET,"cognome",FILTER_SANITIZE_STRING);
$cognome = ucfirst($cognome);

include "../../connessione.php";
try{
    $array = array();
    $num = $connessione->query("SELECT * FROM `utente` WHERE nome = '$nome' AND cognome = '$cognome'")->rowCount();
    foreach ($connessione->query("SELECT * FROM `utente` WHERE nome = '$nome' AND cognome = '$cognome'") as $row){
        $array[]= array($row['username'],$row['nome'],$row['cognome'],$row['data_nascita'],$row['luogo_nascita'],$row['codice_fiscale'],$row['residenza']);
    }
    echo "{";
        echo "\"numero\":$num,";
        echo "\"username\":[";
            for($i=0;$i<$num;$i++){
                if($i==0){
                    echo "\"".$array[$i][0]."\"";
                }else{
                    echo ",\"".$array[$i][0]."\"";
                }
            }
        echo "],";

        echo "\"nome\":[";
            for($i=0;$i<$num;$i++){
                if($i==0){
                    echo "\"".$array[$i][1]."\"";
                }else{
                    echo ",\"".$array[$i][1]."\"";
                }
            }
        echo "],";

        echo "\"cognome\":[";
            for($i=0;$i<$num;$i++){
                if($i==0){
                    echo "\"".$array[$i][2]."\"";
                }else{
                    echo ",\"".$array[$i][2]."\"";
                }
            }
        echo "],";

        echo "\"data_nascita\":[";
            for($i=0;$i<$num;$i++){
                if($i==0){
                    echo "\"".$array[$i][3]."\"";
                }else{
                    echo ",\"".$array[$i][3]."\"";
                }
            }
        echo "],";

        echo "\"luogo_nascita\":[";
            for($i=0;$i<$num;$i++){
                if($i==0){
                    echo "\"".$array[$i][4]."\"";
                }else{
                    echo ",\"".$array[$i][4]."\"";
                }
            }
        echo "],";

        echo "\"codice_fiscale\":[";
        for($i=0;$i<$num;$i++){
            if($i==0){
                echo "\"".$array[$i][5]."\"";
            }else{
                echo ",\"".$array[$i][5]."\"";
            }
        }
        echo "],";

        echo "\"residenza\":[";
            for($i=0;$i<$num;$i++){
                if($i==0){
                    echo "\"".$array[$i][6]."\"";
                }else{
                    echo ",\"".$array[$i][6]."\"";
                }
            }
        echo "]";

    echo "}";
} catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;