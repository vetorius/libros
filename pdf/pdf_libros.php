<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo pdf_grat.php
 *
 * Genera un PDF con los libros de gratuidad
 *
 */

include "../inc/seguridad.inc.php";

require_once ("pdfl.inc.php");
require_once ("../inc/mysql.class.php");
include "../inc/config.inc.php";

$curso = array ("1� ESO", "2� ESO", "3� ESO", "4� ESO", "1� Bach.", "2� Bach.");
$w = array (30,55,85,40,20);

// conexion con la base de datos
$base = new DBmy();
$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ("conexion erronea");

// ajustes previos del documento
$pdf=new PDF('L');
$pdf->SetMargins(30,25);

// una p�gina por curso
for ($i = 1; $i <= 6; $i++) {
	if ($i>4) {
		$a=$i-4;
		$etapa=" {$a}BACH";
	} else {
		$etapa=" {$i}ESO";
	}
// consulta para el curso $i
$sql  = "SELECT l.titulo, l.isbn, m.materia, e.editorial, l.precio ";
$sql .= "FROM materias m INNER JOIN libros l USING (id_materia) ";
$sql .= "INNER JOIN editoriales e USING (id_editorial) ";
$sql .= "WHERE m.id_curso=".$i." AND l.id_editorial<>11 ";
$sql .= "ORDER BY e.editorial";

$base->consulta($sql) or die("consulta erronea");

if ($base->numregistros()>0) {

	$pdf->AddPage();
	
	// muestra el t�tulo
	$pdf->SetFont('helvetica','',12);
	$pdf->SetY(25);
	$titulo = "Listado completo de libros para ".$curso[$i-1];
	$titulo .= "\n" . date('j/n/Y - G:i');
	$pdf->MultiCell(0,10,$titulo,0,C);
	$pdf->Ln(5);

	// muestra cada libro
	$pdf->SetFont('helvetica','',9);
	$header = array ("Editorial","Materia","T�tulo","ISBN","Precio");
	for($j=0;$j<count($header);$j++)
		$pdf->Cell($w[$j],7,$header[$j],1,0,'C');
	$pdf->Ln();

	while ($fila = $base->obtenerfila()) {

		$pdf->Cell($w[0],5,$fila[3],'LRB');
		$pdf->Cell($w[1],5,str_replace($etapa,'',$fila[2]),'LRB');
		$pdf->Cell($w[2],5,$fila[0],'LRB');
		$pdf->Cell($w[3],5,$fila[1],'LRB');
		$pdf->Cell($w[4],5,number_format($fila[4],2,',','.'),'LRB');
		$pdf->Ln();

		}
	}
}
// mandamos el PDF
$pdf->Output();
?>
