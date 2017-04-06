<?php
/**
 * Created by PhpStorm.
 * User: gobbi
 * Date: 04/04/2017
 * Time: 22:29
 */
set_time_limit(0);
$num_f = filter_input(INPUT_POST,"num",FILTER_SANITIZE_STRING);
$id_cart = filter_input(INPUT_POST,"id_c",FILTER_SANITIZE_STRING);
include "../../connessione.php";
try{
    $oggC = $connessione->query("SELECT `id_c`, `nome_cartella`, `colore` FROM `cartelle_f` WHERE id_c = '$id_cart'")->fetch(PDO::FETCH_OBJ);
    for($i=0;$i<$num_f;$i++){
        $key = "foto".$i;

        $nomeF = $_FILES[$key]['name'];
        $estensione = $_FILES[$key]['type'];
        echo $nomeF;
        $c=0;
        foreach ($connessione->query("SELECT * FROM `foto` WHERE `id_c` = '$id_cart' AND `nome_foto` = '$nomeF'") as $row){
            $c++;
        }
        if($c!=0){
            $parti_nome = explode(".",$nomeF = $_FILES[$key]['name']);
            $nome_new= "";
            for($j=0;$j<count($parti_nome)-1;$j++){
                $nome_new .= $parti_nome[$j];
            }
            $app = explode("/", $estensione);
            $ex = $app[1];
            $nome_new = $nome_new."($c).".$ex;
        } else{
            $nome_new = $nomeF;
        }


        $percorso =  "../../Immagini/".$oggC->nome_cartella."/".$nome_new;
        echo $percorso;
        //$nomeF =$matricola.".".$estensione;
        $tmpNome = $_FILES[$key]['tmp_name'];
        move_uploaded_file($tmpNome, $percorso);

        $connessione->exec("INSERT INTO `foto`(`id_foto`, `nome_foto`, `id_c`) VALUES (NULL, '$nome_new','$oggC->id_c')");


    }
}catch (PDOException $e){
    echo $e->getMessage();
}
$connessione = null;
