<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 29/11/2016
 * Time: 19:47
 */
session_start();
session_destroy();
header("Location:../index.php");