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
//Cabecera de p�gina
	function Header()
	{
		//Logo la salle
		$this->Image("logo1.png",7,6,25);
		
		//Logos de calidad
//		$this->Image("G2006.png",145,8,30);
//		$this->Image("400+BN.jpg",180,8,15);
	}

//Pie de p�gina
/* 	function Footer()
	{
		//dibuja linea encima del texto
		$this->line(25, 282, 210, 282);
		//Posici�n: a 1,5 cm del final
		$this->SetY(-16);
		//Arial italic 8
		$this->SetFont('Arial','',8);
		$this->Cell(10);
		//Texto de pie de p�gina
		$texto =  "Santa Teresa, 23   50006 Zaragoza     tel. 976306060     fax 976306062     ";
		$texto .= "direccion.granvia@lasalle.es      ";
		$texto .= "www.lasalle.es/granvia_zaragoza";
		$this->Cell(0,8,$texto,0,0,'L');
	}
 */}


?>