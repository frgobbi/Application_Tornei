<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 09/12/2016
 * Time: 14:47
 */
$torneo = filter_input(INPUT_GET,"id",FILTER_SANITIZE_STRING);
$nome_torneo = filter_input(INPUT_GET,"nomeT",FILTER_SANITIZE_STRING);
$dataOra = $data = date("Y-m-d_G-i-s");
$nomeFile = "Giocatori_$nome_torneo" . $dataOra . '.pdf';

require "../../Librerie/PDF/PDF.php";

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('L','A4',0);
$pdf->SetFont('Arial','B',35);
$pdf->setY(105);
$pdf->setX(60);
$pdf->Cell(150,40,'Polisportica Castelvieto A.S.D',0,0,'C');
$pdf->setY($pdf->getY()+20);
$pdf->setX(60);
$pdf->setFontSize(24);
$pdf->Cell(150,40,'Elenco Giocatori Torneo: '.$nome_torneo,0,0,'C');



include "../../connessione.php";
try{
    foreach ($connessione->query("SELECT * FROM squadra WHERE id_torneo = '$torneo' ORDER BY(iscritta) DESC") as $row) {
        $pdf->AddPage('L','A4',0);
        $pdf->headerVuoto();
        $pdf->setX(8);
        $pdf->SetFontSize(12);
        $squadra = $row['id_sq'];
        $nome = $row['nome_sq'];
        $pdf->Cell(276, 10, $nome, 1, 0, 'C');
        $pdf->SetX(30);
        $pdf->setY($pdf->GetY() + 10);
        $pdf->SetX(8);
        $pdf->Cell(46, 10, 'Nome', 1, 0, 'C');
        $pdf->setX(54);
        $pdf->Cell(46, 10, 'Cognome', 1, 0, 'C');
        $pdf->setX(100);
        $pdf->Cell(34, 10, 'Data di Nascita', 1, 0, 'C');
        $pdf->setX(134);
        $pdf->Cell(40, 10, 'Luogo di Nascita', 1, 0, 'C');
        $pdf->setX(174);
        $pdf->Cell(46, 10, 'Codice Fiscale', 1, 0, 'C');
        $pdf->setX(220);
        $pdf->Cell(64, 10, 'Residenza', 1, 0, 'C');

        $pdf->SetFont('Arial','',12);
        foreach ($connessione->query("SELECT nome,cognome,DATE_FORMAT(data_nascita,'%d-%m-%Y') AS data,codice_fiscale,luogo_nascita,residenza FROM `utente` INNER JOIN sq_utente ON utente.username = sq_utente.username WHERE sq_utente.id_sq = '$squadra' ORDER BY(nome) ASC") as $riga) {
            $nome_u = $riga['nome'];
            $cognome_u = $riga['cognome'];
            $data = $riga['data'];
            $codice = $riga['codice_fiscale'];
            $luogo_d = $riga['luogo_nascita'];
            $residenza = $riga['residenza'];
            $pdf->setY($pdf->GetY() + 10);
            $pdf->SetX(8);
            $pdf->Cell(46, 10, $nome_u, 1, 0, 'C');
            $pdf->setX(54);
            $pdf->Cell(46, 10, $cognome_u, 1, 0, 'C');
            $pdf->setX(100);
            $pdf->Cell(34, 10, $data, 1, 0, 'C');
            $pdf->setX(134);
            $pdf->Cell(40, 10, $luogo_d, 1, 0, 'C');
            $pdf->setX(174);
            $pdf->Cell(46, 10, $codice, 1, 0, 'C');
            $pdf->setX(220);
            $pdf->Cell(64, 10, $residenza, 1, 0, 'C');

        }
    }

} catch (PDOException $e){
    echo "error: ".$e->getMessage();
}
$connessione = null;

$percorso = "files/$nomeFile";
$pdf->Output('F', $percorso);

$pdf->Close();
echo $nomeFile;