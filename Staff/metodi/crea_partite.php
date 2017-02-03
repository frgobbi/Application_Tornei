<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 18/12/2016
 * Time: 02:02
 */
$torneo = filter_input(INPUT_GET,"id",FILTER_SANITIZE_STRING);
$sql_gironi = "SELECT squadra.id_girone FROM `torneo` INNER JOIN squadra ON squadra.id_torneo = torneo.id_torneo WHERE torneo.id_torneo = '$torneo'  AND squadra.iscritta = 1 GROUP BY(squadra.id_girone)";

include "../../connessione.php";
try{
   $gironi = array();
    foreach ($connessione->query($sql_gironi) as $row){
        //echo $row['id_girone'];
        $gironi[] = $row['id_girone'];
    }

    for($i=0;$i < count($gironi);$i++){
        $id_girone = $gironi[$i];
        $sql_squadre = "SELECT squadra.id_sq FROM `torneo` INNER JOIN squadra ON squadra.id_torneo = torneo.id_torneo WHERE torneo.id_torneo = '$torneo' AND squadra.id_girone = '$id_girone' AND squadra.iscritta = 1";
        $squadre = array();
        foreach ($connessione->query($sql_squadre) as $row){
            $squadre[] = $row['id_sq'];
        }

        for($j=0;$j<count($squadre)-1;$j++){
            $squadra1= $squadre[$j];
            for($z=$j+1;$z<count($squadre);$z++){
                $squadra2 = $squadre[$z];
                $connessione->exec("INSERT INTO `partita` (`id_partita`, `data_partita`, `ora_partita`, `luogo`, `fase_finale`) VALUES (NULL, NULL, NULL, 'Campo 1', '0')");
                $oggPartita = $connessione->query("SELECT MAX(id_partita) AS id_partita FROM `partita` WHERE 1")->fetch(PDO::FETCH_OBJ);
                $connessione->exec("INSERT INTO `sq_partita` (`id_sq`, `id_partita`, `vittoria`, `sconfitta`, `pareggio`, `sconfitta_punti`) VALUES ('$squadra1', '$oggPartita->id_partita', '0', '0', '0', '0')");
                $connessione->exec("INSERT INTO `sq_partita` (`id_sq`, `id_partita`, `vittoria`, `sconfitta`, `pareggio`, `sconfitta_punti`) VALUES ('$squadra2', '$oggPartita->id_partita', '0', '0', '0', '0')");

            }
        }
        
    }
} catch (PDOException $e){echo $e->getMessage();}
$connessione = null;
header("Location:../Admin_Torneo.php?id=$torneo");