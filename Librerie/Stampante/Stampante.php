<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 08/03/2017
 * Time: 19:22
 */

$comando = $_GET['comando'];

set_time_limit(0);
$address = '95.233.10.40';
$port = 4096;
$server = array('server' => $address, 'porta' => $port);
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if (!($conn = socket_connect($socket, $server['server'], $server['porta']))) {
    echo "connessione non avvenuta";
    exit;
}

socket_write($socket, $comando);

socket_close($socket);

?>