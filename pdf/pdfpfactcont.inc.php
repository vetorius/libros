<?php

/*
 * geslib 0.1
 *
 * Copyright (c) 2007 Victor manuel Sanchez
 *
 * archivo pdf.inc.php
 *
 * plantilla pdf con el logo del colegio
 *
 */

require "fpdf.php";

// creamos una clase heredada con el formato de plantilla del colegio

class PDF extends FPDF
{
//Cabecera de página
	function Header()
	{
		//Logo la salle
		$this->Image("logo1.png",10,8,40);
		
		//Logos de calidad
		$this->Image("G2006.png",145,8,30);
//		$this->Image("400+BN.jpg",180,8,15);
	}

//Pie de página
	function Footer()
	{
		//dibuja linea encima del texto
		$this->line(10, 280, 210, 280);
		//Posición: a 1,5 cm del final
		$this->SetY(281);
		$this->SetX(10);
		//Arial italic 8
		$this->SetFont('helvetica','',8);
		$this->Cell(10);
		//Texto de pie de página
		$texto =  "Santa Teresa,23 - 50006 Zaragoza - Tel.: 976 30 60 60       direccion.granvia@lasalle.es";
		$this->Cell(0,8,$texto,0,0,'L');
	}
}


?>
