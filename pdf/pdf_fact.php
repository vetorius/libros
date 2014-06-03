<?php 

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo pdf_fact.php
 *
 * genera un PDF con la hoja de factura de un alumno
 *
 */

include "../inc/seguridad.inc.php";

if (isset($_GET['id_alumno'])and (isset($_GET['id_factura']))) {

	include "../inc/config.inc.php";
	include "textos.inc.php";
	require("barcode.inc.php");
	require_once ("pdfpfact.inc.php");
	require_once ("../inc/mysql.class.php");
	
	$id_alumno = $_GET['id_alumno'];
	$id_factura = $_GET['id_factura'];
	$curso = array ("1º ESO", "2º ESO", "3º ESO", "4º ESO", "1º Bachillerato", "2º Bachillerato");

	// conexion con la base de datos
	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ("conexion alumnos erronea");

	// ajustes previos del documento
 	$pdf=new PDF();
	$pdf->SetMargins(20,25);
	$pdf->SetAutoPageBreak( True , 5); 
	$pdf->SetFillColor(220);
	$pdf->AddPage();
 	
	// consulta de alumnos del grupo pedido
	$sql  = "SELECT id_alumno, nom, ap1, ap2, id_curso, clase ";
	$sql .= "FROM alumnos ";
	$sql .= "WHERE id_alumno=$id_alumno";
	
	$base->consulta($sql) or die("consulta alumnos erronea");
	
	if ($base->numregistros()>0) {
		
// imprime los datos del alumno
		$datos = $base->obtenerfila();
		$pdf->SetFont('helvetica','',12);
		$pdf->SetY(30);
		$titulo  = "alumno: ".$datos['ap1']." ".$datos['ap2'].", ".$datos['nom'];
		$titulo .= "\nCódigo: " . $datos['id_alumno'];
		$titulo .= " - " . cualcurso($datos['id_curso'] , $datos['clase']);
		$titulo .= "\nFecha: " . date('d - m - Y');
		$pdf->MultiCell(100,8,$titulo,1,L);
// prepara el titulo para la faldilla inferior
		$titulo  = "alumno: ".$datos['ap1']." ".$datos['ap2'].", ".$datos['nom'];
		$titulo .= " - Código: " . $datos['id_alumno'];

// imprime el titulo y las instrucciones			
		$pdf->Ln(5);
		$pdf->SetFont('helvetica','',12);
		$pdf->MultiCell(0,7,$titulo_factura,0,L);
		$pdf->SetFont('helvetica','',9);
		$pdf->MultiCell(0,6,$instr_factura,1,J);
		$pdf->Ln(5);

// imprime la tabla de libros
		$sql  = "SELECT li.isbn, li.titulo, ed.editorial, li.precio ";
		$sql .= "FROM editoriales ed INNER JOIN libros li USING (id_editorial) ";
		$sql .= "INNER JOIN materias ma USING (id_materia) ";
		$sql .= "INNER JOIN fact_lib fact USING (id_libro) ";
		$sql .= "WHERE fact.id_factura=".$id_factura;
		$sql .= " and li.gratuidad=0 ORDER BY ma.tipo, ma.materia, li.titulo";
//		echo $sql . '<br>';
			
		$base->consulta($sql) or die('consulta libros erronea');
		
		$pdf->SetFont('helvetica','',8);

		//Anchuras de las columnas
		$w = array (40,70,30,20);
		//Cabeceras
		$header = array ("ISBN","Título","Editorial","Precio");

		$pdf->SetX(15);
		for($i=0;$i<count($header);$i++)
			$pdf->Cell($w[$i],6,$header[$i],1,0,'C');
		$pdf->Ln();

		while ($fila = $base->obtenerfila()) {
			$pdf->SetX(15);
			$pdf->Cell($w[0],5,str_replace(" {$nextcur}ESO",'',$fila[0]),1,0,'L');
			$pdf->Cell($w[1],5,$fila[1],1,0,'L');
			$pdf->Cell($w[2],5,$fila[2],1,0,'L');
			$pdf->Cell($w[3],5,number_format($fila[3],2,',','.').' - €',1,0,'R');
			$pdf->Ln();
		}
// imprime el total		
		$sql  = "SELECT total ";
		$sql .= "FROM facturas ";
		$sql .= "WHERE id_factura=$id_factura";
		$base->consulta($sql) or die("consulta total factura erronea");
		$datos = $base->obtenerfila();
		$pdf->SetX(15);
		$pdf->Cell($w[0],5,'',0,0,'L');
		$pdf->Cell($w[1],5,'',0,0,'L');
		$pdf->Cell($w[2],5,'Total',1,0,'R',1);
		$pdf->Cell($w[3],5,number_format($datos[0],2,',','.').' - €',1,0,'R',1);
		$pdf->Ln();
		$total_factura = ' -> ' . number_format($datos[0],2,',','.') . ' - €';

// imprime los codigos de barras
		$bar= new BARCODE();
		if($bar==false)
			die($bar->error());
		$barnumber=sprintf("%04d",$id_factura);
		$bar->setSymblogy('CODE39');
		$bar->setHeight(30);
		$bar->setScale(2);
		$bar->setHexColor("#000000","#FFFFFF");

		$return = $bar->genBarCode($barnumber,'png','bar'.$id_factura);
		if($return==false)
			$bar->error(true);
		$pdf->Image('bar'.$id_factura.'.png',140,35,40);
		$pdf->Image('bar'.$id_factura.'.png',10,240,40);
// borramos la imagen generada y el objeto codigo de barras						
		unlink('bar'.$id_factura.'.png') or die('no se puede borrar el archivo');
		unset($bar);

// imprime los datos de la faldilla recortable
		$pdf->SetFont('helvetica','',8);
		$pdf->SetXY(60,240);
		$titulo .= $total_factura;
		$pdf->MultiCell(100,8,$titulo,1,L);

		$pdf->SetFont('helvetica','',9);
		$pdf->SetXY(10,260);
		$pdf->MultiCell(120,8,$conf_factura,0,J);


// imprime el cuadro de firma
			$pdf->SetXY(-75,260);		
			$pdf->Cell(55,8,'Fecha: '. date('d - m - Y'),'TLR');
			$pdf->Ln(5);
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
?>