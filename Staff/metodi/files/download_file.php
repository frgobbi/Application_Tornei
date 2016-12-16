<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 09/12/2016
 * Time: 20:41
 */
$file = filter_input(INPUT_GET, "file", FILTER_SANITIZE_STRING);


header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=" . $file);
header("Content-Transfer-Encoding: binary");
// Leggo il contenuto del file
readfile($file);

unlink($file);



echo "<cript>window.close();</cript>";