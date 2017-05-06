<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 12/12/2016
 * Time: 18:40
 */
$torneo = filter_input(INPUT_GET,"id",FILTER_SANITIZE_STRING);
$num_gironi = filter_input(INPUT_POST,"num_gironi",FILTER_SANITIZE_STRING);
$num_sq = filter_input(INPUT_POST,"num_sq",FILTER_SANITIZE_STRING);

include "../../connessione.php";
/*try{
    $gironi = array();
    foreach ($connessione->query("SELECT * FROM `girone` WHERE `id_girone` <= '$num_gironi'") as $row){
        $gironi[] = array($row['id_girone'],$row['nome_girone']);
    }
}catch (PDOException $e){
    echo "error: ".$e->getMessage();
}*/

try{
    $squadre = array();
    foreach ($connessione->query("SELECT id_sq FROM `squadra` WHERE id_torneo = '$torneo' AND iscritta = 1") as $row){
        $squadre[] = array($row['id_sq'],null);
    }
}catch (PDOException $e){
    echo "error: ".$e->getMessage();
}

for ($i=0; $i<count($squadre);$i++){
    do {
        $valore = rand(1, $num_gironi);
        $c = 0;
        for($j=0;$j<count($squadre);$j++){
            if($squadre[$j][1]==$valore){
                $c++;
            }
        }
    }while($c >= $num_sq);
    $squadre[$i][1]= $valore;
}

for ($i=0; $i<count($squadre);$i++){
    $girone_sq = $squadre[$i][1];
    $squadra = $squadre[$i][0];
    try{
       $connessione->exec("UPDATE `squadra` SET `id_girone` = '$girone_sq' WHERE `squadra`.`id_sq` = '$squadra'");
    }catch (PDOException $e){
        echo "error: ".$e->getMessage();
    }
}
$connessione = null;
header("Location:../Admin_Torneo.php?id=$torneo");