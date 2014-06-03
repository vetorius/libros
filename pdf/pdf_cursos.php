<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo pdf_cursos.php
 *
 * Genera un PDF con el total de libros pedidos por curso
 *
 */

include "../inc/seguridad.inc.php";

require_once ("pdfl.inc.php");
require_once ("../inc/mysql.class.php");
include "../inc/config.inc.php";

$curso = array ("1º ESO", "2º ESO", "3º ESO", "4º ESO", "1º Bach.", "2º Bach.");
$w = array (30,55,85,40,20);

// conexion con la base de datos
$base = new DBmy();
$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ("conexion erronea");

// ajustes previos del documento
$pdf=new PDF('L');
$pdf->SetMargins(30,30);

// una página por curso
for ($i = 1; $i <= 6; $i++) {
	if ($i>4) {
		$a=$i-4;
		$etapa=" {$a}BACH";
	} else {
		$etapa=" {$i}ESO";
	}
// consulta para el curso $i

$sql  = "SELECT ed.editorial, ma.materia, li.titulo, li.isbn, count(*) ";
$sql .= "FROM facturas fa INNER JOIN fact_lib using(id_factura) ";
$sql .= "INNER JOIN libros li using(id_libro) ";
$sql .= "INNER JOIN editoriales ed using(id_editorial) INNER JOIN materias ma using(id_materia) ";
$sql .= "WHERE fa.id_pedido=0 and ma.id_curso=".$i;
$sql .= " GROUP BY id_libro ORDER BY id_editorial";

$base->consulta($sql) or die("consulta erronea");

if ($base->numregistros()>0) {
	$pdf->AddPage();
	// muestra el título
	$pdf->SetFont('helvetica','',12);
	$pdf->SetY(20);
	$titulo = "Listado con cantidades de libros pedidos para ".$curso[$i-1];
	$titulo .= " - " . date('j/n/Y - G:i');
	$pdf->MultiCell(0,8,$titulo,0,C);
	$pdf->Ln(5);

	// muestra cada libro
	$pdf->SetFont('helvetica','',9);
	$header = array ("Editorial","Materia","Título","ISBN","Cantidad");
	for($j=0;$j<count($header);$j++)
		$pdf->Cell($w[$j],7,$header[$j],1,0,'C');
	$pdf->Ln();
	while ($fila = $base->obtenerfila()) {

		$pdf->Cell($w[0],5,$fila[0],1);
		$pdf->Cell($w[1],5,str_replace($etapa,'',$fila[1]),1);
		$pdf->Cell($w[2],5,$fila[2],1);
		$pdf->Cell($w[3],5,$fila[3],1,0,'C');
		$pdf->Cell($w[4],5,$fila[4],1,0,'R');
		$pdf->Ln();
		}
	}
}
// mandamos el PDF
$pdf->Output();
?>
