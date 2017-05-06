<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 03/05/2017
 * Time: 23:10
 */
$pass = filter_input(INPUT_GET,"pwd",FILTER_SANITIZE_STRING);
$username_u = filter_input(INPUT_GET,"user",FILTER_SANITIZE_STRING);