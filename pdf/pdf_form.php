<?php 

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo pdf_form.php
 *
 * genera un PDF con las hojas de pedido de un grupo
 *
 */

include "../inc/seguridad.inc.php";

if (isset($_GET['cur'])and (isset($_GET['gru']))) {

	include "../inc/config.inc.php";
	require_once ("pdfp.inc.php");
	require_once ("../inc/mysql.class.php");
	require("barcode.inc.php");
	include "textos.inc.php";
	
	$cur = $_GET['cur'];
	$nextcur = $cur + 1;
	if ($nextcur>4) {
		$a = $nextcur -4;
		$etapa=" {$a}BACH";
	} else {
		$etapa=" {$nextcur}ESO";
	}
	$gru = $_GET['gru'];
	$curso = array ("1º ESO", "2º ESO", "3º ESO", "4º ESO", "1º Bachillerato", "2º Bachillerato");
	
	// conexion con la base de datos
	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ("conexion alumnos erronea");

	// ajustes previos del documento
 	$pdf=new PDF();
	$pdf->SetMargins(20,25);
	$pdf->SetFillColor(220);
 	
	// consulta de alumnos del grupo pedido
	$sql  = "SELECT id_alumno, nom, ap1, ap2 ";
	$sql .= "FROM alumnos ";
	$sql .= "WHERE id_curso=$cur and clase=$gru and repite=0 and baja=0 ";
	$sql .= "ORDER BY ap1, ap2, nom";
	
	$base->consulta($sql) or die("consulta alumnos erronea");
	
	if ($base->numregistros()>0) {
		
		$libros = new DBmy();
		$libros->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ("conexion libros erronea");
		while ($datos = $base->obtenerfila()) {
			$pdf->AddPage();

// imprime los datos del alumno
			$pdf->SetFont('helvetica','',12);
			$pdf->SetY(30);
			$titulo  = "alumno: ".$datos['ap1']." ".$datos['ap2'].", ".$datos['nom'];
			$titulo .= "\nCódigo: " . $datos['id_alumno'];
			$titulo .= "\n" . cualcurso($cur,$gru);
			$pdf->MultiCell(100,8,$titulo,1,L);

// imprime el titulo y las instrucciones			
			$pdf->Ln(5);
			$pdf->SetFont('helvetica','',12);

			if ($nextcur>4) {
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
			$header = array ("X","Materia","Título","Editorial","ISBN","Precio");
			$pdf->SetX(15);
			for($i=0;$i<count($header);$i++)
				$pdf->Cell($w[$i],7,$header[$i],1,0,'C');
			$pdf->Ln();

			$libros->consulta($sql) or die('consulta libros erronea');

			while ($fila = $libros->obtenerfila()) {
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
			$barnumber=$datos['id_alumno'] . chknum($datos['id_alumno']);
			$bar->setSymblogy('EAN-13');
			$bar->setHeight(50);
			$bar->setScale(2);
			$bar->setHexColor("#000000","#FFFFFF");
			
			$return = $bar->genBarCode($barnumber,'png',$datos['id_alumno']);
			if($return==false)
				$bar->error(true);
			$pdf->Image($datos['id_alumno'].'.png',140,35,40);

// borramos la imagen generada y el objeto codigo de barras						
			unlink($datos['id_alumno'].'.png') or die('no se puede borrar el archivo');
			unset($bar);
			
// imprime el cuadro de firma
			if ($nextcur<7) {
			$pdf->SetXY(-75,245);		
			$pdf->Cell(55,8,'Fecha:','TLR');
			$pdf->Ln();
			$pdf->SetX(-75);		
			$pdf->Cell(55,8,'Firma del padre, madre o tutor.','LR');
			$pdf->Ln();
			$pdf->SetX(-75);
			$pdf->Cell(55,15,'','LRB');		
			$pdf->ln(6);
			}

		}
 	}
// mandamos el PDF
	$pdf->Output();
}
?>
