<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 02/07/2017
 * Time: 19:09
 */
session_start();
$dim = filter_input(INPUT_POST,"dim",FILTER_SANITIZE_STRING);
$_SESSION['dim_barra']= $dim;