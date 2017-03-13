<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 11/03/2017
 * Time: 10:01
 */
$num = filter_input(INPUT_GET,"num_P",FILTER_SANITIZE_STRING);

$id_prodotti = array();
$prezzi = array();
$quant = array();
$desc = array();
for($i=0;$i<$num;$i++){
    $keyId ="id".$i;
    $keyPrezzi ="prezzi".$i;
    $keyQuant ="quant".$i;
    $keyDesc ="desc".$i;
    $id_prodotti[] = filter_input(INPUT_GET,$keyId,FILTER_SANITIZE_STRING);
    $prezzi[] = filter_input(INPUT_GET,$keyPrezzi,FILTER_SANITIZE_STRING);
    $quant[] = filter_input(INPUT_GET,$keyQuant,FILTER_SANITIZE_STRING);
    $desc[] = filter_input(INPUT_GET,$keyDesc,FILTER_SANITIZE_STRING);
}
$totale = 0;
for($i=0;$i<$num;$i++){
    $art = intval($quant[$i])*floatval($prezzi[$i]);
    $totale = floatval($totale)+floatval($art);
}
/*for($i=0;$i<$num;$i++) {
    echo $id_prodotti[$i] . "<br>";
    echo $prezzi[$i] . "<br>";
    echo $quant[$i] . "<br>";
    echo $desc[$i] . "<br>";
}*/
include "../../connessione.php";
try {
    $giorno = $connessione->query("SELECT * FROM giorno WHERE chiuso = 0")->fetch(PDO::FETCH_OBJ);
    $ordine_P = $connessione->query("SELECT MAX(num_ordine) AS numero FROM `ordine_p` WHERE id_giorno = '$giorno->id_giorno'")->fetch(PDO::FETCH_OBJ);
    if($ordine_P->numero == NULL){
        $num_p = 0;
    } else {
        $num_p = $ordine_P->numero;
    }
    $ordine_v = $connessione->query("SELECT MAX(num_ordine) AS numero FROM `ordine_v` WHERE id_giorno = '$giorno->id_giorno'")->fetch(PDO::FETCH_OBJ);
    if($ordine_v->numero == NULL){
        $num_v = 0;
    } else {
        $num_v = $ordine_v->numero;
    }
    if($num_p>$num_v){
        $num_ord = $num_p;
    } else{
        $num_ord = $num_v;
    }
    $num_ord++;

        $connessione->beginTransaction();
        $codice = filter_input(INPUT_GET,"codice",FILTER_SANITIZE_STRING);
        $esito=2;//non trovo nessuno con questo codice
        foreach ($connessione->query("SELECT * FROM utente WHERE card = '$codice'") as $row){
            $esito = 1;
            if($row['saldo']>=floatval($totale)){
                for ($i = 0; $i < $num; $i++) {
                    for ($j = 0; $j < $quant[$i]; $j++) {
                        if (strcmp($desc[$i], "Varie") != 0) {
                            $insert = "INSERT INTO `ordine_p`(`id_ordine_p`, `id_prodotto`, `id_giorno`, `ora`, `num_ordine`, `credito`) VALUES "
                                ."(NULL,$id_prodotti[$i],'$giorno->id_giorno',NOW(),'$num_ord','1')";
                            $connessione->exec($insert);
                        } else {
                            $valore = doubleval($prezzi[$i]);
                            $insert = "INSERT INTO `ordine_v`(`id_ordine_p`, `varie`, `id_giorno`, `ora`, `num_ordine`, `credito`) VALUES "
                                ."(NULL,$valore,'$giorno->id_giorno',NOW(),$num_ord,'1')";
                            $connessione->exec($insert);
                        }
                    }
                }
                $newSaldo = floatval($row['saldo'])-floatval($totale);
                $connessione->exec("UPDATE utente SET saldo = '$newSaldo' WHERE card = '$codice'");
            } else {
                $esito = 3; //non basta il denaro
            }
        }
        $connessione->commit();
} catch (PDOException $e){
    $connessione->rollBack();
    $esito = 0;
}
$connessione = null;
echo $esito;