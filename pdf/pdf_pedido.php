<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo pdf_pedido.php
 *
 * Genera un PDF con el pedido de libros por proveedor
 *
 */

include "../inc/seguridad.inc.php";

require_once ("pdfl.inc.php");
require_once ("../inc/mysql.class.php");
include "../inc/config.inc.php";

if (isset($_GET['pedido'])) {
	
	$pedido=$_GET['pedido'];
	
	$w = array (30,60,85,40,20);
	
	// conexiones con la base de datos
	$edi = new DBmy();
	$edi->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ("conexion editoriales erronea");
	
	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ("conexion libros erronea");
	
	
	
	// hacemos una consulta por proveedores
	
	$sql = "SELECT id_proveedor, proveedor FROM proveedores";
	$edi->consulta($sql) or die("consulta proveedores erronea");
	
	if ($edi->numregistros()>0) {
		// ajustes previos del documento
		$pdf=new PDF('L');
		$pdf->SetMargins(30,30);
	
		while ($datos = $edi->obtenerfila()) {
		// consulta para la editorial 
		
		$sql  = "SELECT ed.editorial, ma.materia, li.titulo, li.isbn, count(*) ";
		$sql .= "FROM facturas fa INNER JOIN fact_lib using(id_factura) ";
		$sql .= "INNER JOIN libros li using(id_libro) ";
		$sql .= "INNER JOIN editoriales ed using(id_editorial) INNER JOIN materias ma using(id_materia) ";
		$sql .= "WHERE fa.id_pedido=" . $pedido . " and ed.id_proveedor=" . $datos['id_proveedor'];
		$sql .= " GROUP BY id_libro ORDER BY ed.editorial, li.isbn, id_materia";
		
		$base->consulta($sql) or die("consulta erronea");
		
		if ($base->numregistros()>0) {
			$pdf->AddPage();
			// muestra el t�tulo
			$pdf->SetFont('helvetica','',12);
			$pdf->SetY(20);
			$titulo = "Pedido de libros para ".$datos['proveedor'];
			$titulo .= " - Pedido " . sprintf("%02d",$pedido);
			$pdf->MultiCell(0,8,$titulo,0,C);
			$pdf->Ln(5);
		
			// muestra cada libro
			$pdf->SetFont('helvetica','',9);
			$header = array ("Editorial","Materia","T�tulo","ISBN","Cantidad");
			for($j=0;$j<count($header);$j++)
				$pdf->Cell($w[$j],7,$header[$j],1,0,'C');
			$pdf->Ln();
			while ($fila = $base->obtenerfila()) {
		
				$pdf->Cell($w[0],5,$fila[0],1);
				$pdf->Cell($w[1],5,$fila[1],1);
				$pdf->Cell($w[2],5,$fila[2],1);
				$pdf->Cell($w[3],5,$fila[3],1,0,'C');
				$pdf->Cell($w[4],5,$fila[4],1,0,'R');
				$pdf->Ln();
				}
			}
		}
		// mandamos el PDF
		$pdf->Output();
	}
}
?>
