<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 05/03/2017
 * Time: 14:32
 */
$oggi = date("Y-m-d");
$esito =1;
$incasso = null;
$ogg = null;
include "../../connessione.php";
try{
    $thisSerata = $connessione->query("SELECT * FROM `giorno` WHERE `data_g` LIKE '$oggi'")->rowCount();
    $serateAperte = $connessione->query("SELECT * FROM `giorno` WHERE chiuso = 0")->rowCount();

    if($serateAperte==0){
        if($thisSerata==0){
            $connessione->query("INSERT INTO `giorno`(`id_giorno`, `data_g`, `chiuso`) VALUES (NULL,'$oggi','0')");
            $ogg = $connessione->query("SELECT id_giorno FROM `giorno` WHERE `data_g` LIKE '$oggi'")->fetch(PDO::FETCH_OBJ);
            $incasso =0;
            $array = array(
                "esito"=>$esito,
                "data"=>date("d-m-Y"),
                "incasso"=>$incasso,
                "id_giorno"=>$ogg->id_giorno
            );
        }else{
            $esito = 2;
            $array = array(
                "esito"=>$esito,
                "data"=>null,
                "incasso"=>null,
                "id_giorno"=>null
            );
        }
    } else{
        $esito =0;
        $array = array(
            "esito"=>$esito,
            "data"=>null,
            "incasso"=>null,
            "id_giorno"=>null
        );
    }
} catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;

echo json_encode($array);