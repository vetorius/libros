<?php 

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo pdf_grupograt.php
 *
 * genera un PDF con la lista de libros de 
 *
 * gratuidad para los alumnos de un nivel
 *
 */

include "../inc/seguridad.inc.php";

if (isset($_GET['cur'])) {

	include "../inc/config.inc.php";
	require_once ("pdfa5.inc.php");
	require_once ("../inc/mysql.class.php");
	include "textos.inc.php";
	
	$cur = $_GET['cur'];
	$nextcur = $cur + 1;
	$etapa=" {$nextcur}ESO";
	$curso = array ("1º ESO", "2º ESO", "3º ESO", "4º ESO", "1º Bachillerato", "2º Bachillerato");
	
	// conexion con la base de datos
	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ("conexion alumnos erronea");

	// ajustes previos del documento
 	$pdf=new PDF('P','mm','A5');
	$pdf->SetMargins(10,15);
	$pdf->SetFillColor(220);
 	
	// consulta de alumnos del grupo pedido
	$sql  = "(SELECT id_alumno, nom, ap1, ap2 ";
	$sql .= "FROM alumnos ";
	$sql .= "WHERE id_curso=$cur and repite=0 and baja=0) UNION ";
	$sql .= "(SELECT id_alumno, nom, ap1, ap2 ";
	$sql .= "FROM alumnos ";
	$sql .= "WHERE id_curso=$cur+1 and repite=1 and baja=0) ";
	$sql .= "ORDER BY ap1, ap2, nom";
	
	$base->consulta($sql) or die("consulta alumnos erronea");
	
	if ($base->numregistros()>0) {
		
		$libros = new DBmy();
		$libros->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ("conexion libros erronea");
		while ($datos = $base->obtenerfila()) {
			$pdf->AddPage();

// imprime los datos del alumno
			$pdf->SetFont('helvetica','',10);
			$pdf->SetY(20);
			$pdf->SetX(10);
			$titulo  = "alumno: ".$datos['ap1']." ".$datos['ap2'].", ".$datos['nom'];
			$titulo .= " - Código: " . $datos['id_alumno'];
			$titulo .= "\n   " . $curso[$cur];
			$pdf->MultiCell(130,8,$titulo,1,L);

// imprime el titulo y las instrucciones			
			$pdf->Ln(5);
			$pdf->SetFont('helvetica','',10);

			$pdf->MultiCell(0,7,$titulo_lote_grat,0,L);
			$pdf->SetFont('helvetica','',8);
			$pdf->MultiCell(0,5,$instr_lote_grat,1,J);
			$pdf->Ln(5);


// imprime la tabla de libros
			$sql  = "SELECT ma.materia, li.titulo, ed.editorial, li.isbn, li.precio ";
			$sql .= "FROM editoriales ed INNER JOIN libros li USING (id_editorial) ";
			$sql .= "INNER JOIN materias ma USING (id_materia) ";
			$sql .= "INNER JOIN alu_mat alma USING (id_materia) ";
			$sql .= "WHERE alma.id_alumno=".$datos['id_alumno'];
			$sql .= " and li.gratuidad=1 ORDER BY ma.id_materia, li.titulo";
			
			$pdf->SetFont('helvetica','',7);
			//Anchuras de las columnas
			$w = array (35,52,17,26);
			//Cabeceras
			$header = array ("Materia","Título","Editorial","ISBN");
			$pdf->SetX(10);
			for($i=0;$i<count($header);$i++)
				$pdf->Cell($w[$i],6,$header[$i],1,0,'C');
			$pdf->Ln();

			$libros->consulta($sql) or die('consulta libros erronea');

			while ($fila = $libros->obtenerfila()) {
				$pdf->SetX(10);
 				$pdf->Cell($w[0],6,str_replace($etapa,'',$fila[0]),1,0,'L');
				$pdf->Cell($w[1],6,$fila[1],1,0,'L');
				$pdf->Cell($w[2],6,$fila[2],1,0,'L');
				$pdf->Cell($w[3],6,$fila[3],1,0,'C');
				$pdf->Ln();
			}

// texto de conformidad
			$pdf->SetFont('helvetica','',8);
			$pdf->MultiCell(0,5,$conf_lote_grat,0,J);
			$pdf->Ln(5);

// imprime el cuadro de firma
			if ($nextcur<6) {
			$pdf->SetXY(-75,160);		
			$pdf->Cell(50,7,'Fecha:','TLR');
			$pdf->Ln();
			$pdf->SetX(-75);		
			$pdf->Cell(50,7,'Firma del padre, madre o tutor.','LR');
			$pdf->Ln();
			$pdf->SetX(-75);
			$pdf->Cell(50,15,'','LRB');		
			$pdf->ln(6);
			}

		}
 	}
// mandamos el PDF
	$pdf->Output();
}
?>