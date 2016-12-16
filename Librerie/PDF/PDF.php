<?php

/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 10/05/2016
 * Time: 09:42
 */
require("fpdf/fpdf.php");
class PDF extends FPDF
{
    /*
    public static $logo = "../../../immagini/loghi/Logo-SosSnack.png";
    public static $logo_scuola;
    public static $titolo = "S.O.S Snack";
    //__construct()
*/


    function headerVuoto()
    {
        $this->SetFont('Arial','B',24);
        $this->SetX(0);
        $this->Ln(5);
    }
   
}
