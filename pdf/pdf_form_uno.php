<?php 

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo pdf_form_uno.php
 *
 * genera un PDF con la hoja de pedido de un alumno
 *
 */

include "../inc/seguridad.inc.php";

if (isset($_GET['id_alumno'])) {

	include "../inc/config.inc.php";
	require_once ("pdfp.inc.php");
	require_once ("../inc/mysql.class.php");
	require("barcode.inc.php");
	include "textos.inc.php";
	
	$curso = array ("1� ESO", "2� ESO", "3� ESO", "4� ESO", "1� Bachillerato", "2� Bachillerato");
	$id_alumno = $_GET['id_alumno'];
	
	// conexion con la base de datos
	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ("conexion alumnos erronea");

	// consulta de alumnos del grupo pedido
	$sql  = "SELECT id_alumno, nom, ap1, ap2, clase, id_curso, repite ";
	$sql .= "FROM alumnos ";
	$sql .= "WHERE id_alumno=" . $id_alumno;

	$base->consulta($sql) or die("consulta alumno erronea");
	
	if ($base->numregistros()>0) {
		// ajustes previos del documento
		$datos = $base->obtenerfila();
		
		$pdf=new PDF();
		$pdf->SetMargins(20,25);
		$pdf->SetFillColor(220);
		$pdf->AddPage();
		
		if ($datos['repite']) {
			$cur = $datos['id_curso'];
		} else {
			$cur = $datos['id_curso'] + 1;
		}
		if ($cur>4) {
			$a=$cur-4;
			$etapa=" {$a}BACH";
		} else {
			$etapa=" {$cur}ESO";
		}
		
// imprime los datos del alumno
		$pdf->SetFont('helvetica','',12);
		$pdf->SetY(30);
		$titulo  = "alumno: ".$datos['ap1']." ".$datos['ap2'].", ".$datos['nom'];
		$titulo .= "\nC�digo: " . $datos['id_alumno'];
		$titulo .= "\n" . cualcurso($datos['id_curso'],$datos['clase']);
		$pdf->MultiCell(100,8,$titulo,1,L);

// imprime el titulo y las instrucciones			
		$pdf->Ln(5);
		$pdf->SetFont('helvetica','',12);
		if ($cur>4) {
			$pdf->MultiCell(0,7,$titulo_pedido_bach,0,L);
		} else {
			$pdf->MultiCell(0,7,$titulo_pedido_eso,0,L);
		}
		$pdf->SetFont('helvetica','',9);
		$pdf->MultiCell(0,4,$instr_pedido,1,J);
		$pdf->Ln(5);

// imprime la tabla de libros
		$sql  = "SELECT ma.materia, li.titulo, ed.editorial, li.isbn, li.precio ";
		$sql .= "FROM editoriales ed INNER JOIN libros li USING (id_editorial) ";
		$sql .= "INNER JOIN materias ma USING (id_materia) ";
		$sql .= "INNER JOIN alu_mat alma USING (id_materia) ";
		$sql .= "WHERE alma.id_alumno=".$datos['id_alumno'];
		$sql .= " and li.gratuidad=0 ORDER BY ma.tipo, ma.materia, li.titulo";
		
		$pdf->SetFont('helvetica','',9);
		//Anchuras de las columnas
		$w = array (7,40,72,25,28,10);
		//Cabeceras
		$header = array ("X","Materia","T�tulo","Editorial","ISBN","Precio");
		$pdf->SetX(15);
		for($i=0;$i<count($header);$i++)
			$pdf->Cell($w[$i],7,$header[$i],1,0,'C');
		$pdf->Ln();

		$base->consulta($sql) or die('consulta libros erronea');

		while ($fila = $base->obtenerfila()) {
			$pdf->SetX(15);
			if (($fila[2]=="Uso Interno") or (substr_count ($fila[0],'Material General')>0)): $interno=1; else: $interno=0; endif;
			$pdf->Cell($w[0],6,'',1);
			$pdf->Cell($w[1],6,str_replace($etapa,'',$fila[0]),1,0,'L',$interno);
			$pdf->Cell($w[2],6,$fila[1],1,0,'L',$interno);
			$pdf->Cell($w[3],6,$fila[2],1,0,'L',$interno);
			$pdf->Cell($w[4],6,$fila[3],1,0,'C',$interno);
			$pdf->Cell($w[5],6,number_format($fila[4],2,',','.'),1,0,'R',$interno);
			$pdf->Ln();
		}

// imprime el codigo de barras
		$bar= new BARCODE();
		if($bar==false)
			die($bar->error());
		$barnumber=$id_alumno . chknum($id_alumno);
		$bar->setSymblogy('EAN-13');
		$bar->setHeight(50);
		$bar->setScale(2);
		$bar->setHexColor("#000000","#FFFFFF");
		
		$return = $bar->genBarCode($barnumber,'png',$id_alumno);
		if($return==false)
			$bar->error(true);
		$pdf->Image($id_alumno . '.png',140,35,40);

// borramos la imagen generada y el objeto codigo de barras						
		unlink($id_alumno . '.png') or die('no se puede borrar el archivo');
		unset($bar);
		
// imprime el cuadro de firma
		if ($cur<7) {
		$pdf->SetXY(-75,240);		
		$pdf->Cell(55,8,'Fecha:','TLR');
		$pdf->Ln();
		$pdf->SetX(-75);		
		$pdf->Cell(55,8,'Firma del padre, madre o tutor.','LR');
		$pdf->Ln();
		$pdf->SetX(-75);
		$pdf->Cell(55,15,'','LRB');		
		$pdf->ln(6);
		}
// mandamos el PDF
		$pdf->Output();
 	}
}

?>
