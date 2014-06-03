<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo pdf_dpto.php
 *
 * Genera un PDF con los libros del departamento
 *
 * especificado en GET(num)= id y GET(dep)=nombre del departamento
 *
 */

include "../inc/seguridad.inc.php";

if (isset($_GET['num'])and (isset($_GET['dep']))) {

	require_once ("pdfp.inc.php");
	require_once ("../inc/mysql.class.php");
	include "../inc/config.inc.php";
	
	$num = $_GET['num'];
	$dep = $_GET['dep'];
	$curso = array ("1º ESO", "2º ESO", "3º ESO", "4º ESO", "1º Bachillerato", "2º Bachillerato");
	
	// conexion con la base de datos
	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ("conexion erronea");

	// ajustes previos del documento
	$pdf=new PDF();
	$pdf->SetMargins(20,25);
	$pdf->SetFont('helvetica','',12);

	$pdf->AddPage();
	$titulo = "Departamento de ".$dep;
	$pdf->MultiCell(0,8,$titulo,0,C);
	$pdf->Ln();
	for ($i = 1; $i <= 6; $i++) {
	// consulta para el curso $i
	$sql  = "SELECT l.titulo, l.isbn, l.precio, l.gratuidad, m.materia, e.editorial ";
	$sql .= "FROM materias m INNER JOIN libros l USING (id_materia) ";
	$sql .= "INNER JOIN editoriales e USING (id_editorial) ";
	$sql .= "WHERE m.id_curso=".$i." AND m.id_departamento=".$num;
	$sql .= " ORDER BY m.id_materia";
	
	$base->consulta($sql) or die("consulta erronea");
	
	if ($base->numregistros()>0) {
	
//			$pdf->AddPage();
		
		// muestra el título
//			$pdf->SetY(25);
//			$titulo = "Departamento: ".$dep;
			$titulo = "Libros para ".$curso[$i-1];
			$pdf->MultiCell(0,6,$titulo,0,C);
//			$pdf->Ln();
		// muestra cada libro
			while ($datos = $base->obtenerfila()) {
				$pdf->SetX(20);
				$pdf->Cell(0,6,$datos[4],0,1,L);
				$item = "título: " . $datos[0] . "    editorial:". $datos[5] ."\n";
				$item .= "ISBN: " . $datos[1] . " - precio: " . $datos[2] . " €";
				if ($datos[3]) $item .= " - GRATUIDAD";
				$pdf->SetX(30);
				$pdf->MultiCell(0,6,$item,0,L);
				$pdf->Ln();
			}
		}
	}
	// mandamos el PDF
	$pdf->Output();
}
?>
