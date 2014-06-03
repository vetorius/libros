<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo asignacion.php
 *
 * rejilla para actualizar las opciones
 *
 * de los alumnos de un grupo
 *
 */
 
include ("inc/seguridad.inc.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>asignar opciones a los alumnos</title>

<?php
	include ("inc/config.inc.php");
	include ("inc/phpmydatagrid.class.php");
	
	$objGrid = new datagrid;
	
	$objGrid -> friendlyHTML();

	$objGrid -> language('es');

	$objGrid -> closeTags(true);  
	
	$objGrid -> form('alumno', true);
	
	$objGrid -> methodForm("get"); 
	
	$objGrid -> linkparam("cur=".$_GET["cur"]."&gru=".$_GET["gru"]);	 
	
	$objGrid -> decimalDigits(2);
	
	$objGrid -> decimalPoint(",");
	
	$objGrid -> conectadb($sql_host, $sql_user, $sql_pass, $sql_base);
	
	$objGrid -> tabla ("alumnos");

	$objGrid -> buttons(true,true,true,true);
	
	$objGrid -> keyfield("id_alumno");

	$objGrid -> salt("Some Code4Stronger(Protection)");

	$objGrid -> TituloGrid("Selecci&oacute;n de optativas " . cualcurso($_GET['cur'],$_GET['gru']));

	$objGrid -> datarows(100);
	
	$objGrid -> paginationmode('links');

	$objGrid -> orderby("ap1", "ASC");

	$objGrid -> noorderarrows();
	
	$objGrid -> FormatColumn("id_alumno", "Codigo", 15, 15, 1, "50", "center");
	$objGrid -> FormatColumn("clase_n", "Clase N", 3, 2, 0, "40", "center", "integer");
	$objGrid -> FormatColumn("ap1", "Apellidos", 30, 30, 0, "200", "left");
	$objGrid -> FormatColumn("nom", "nombre", 30, 30, 0, "130", "left");
	$objGrid -> FormatColumn("repite", "Rep.", 2, 2, 0, "40", "center", "check:No:Yes");
	$objGrid -> FormatColumn("baja", "Baja", 2, 2, 0, "40", "center", "check:No:Yes");
	$objGrid -> FormatColumn("diver", "Div.", 2, 2, 0, "40", "center", "check:No:Yes");
	$objGrid -> FormatColumn("opcion", "Opc.", 3, 2, 0, "40", "center", "integer");

	$objGrid -> where ("id_curso=". $_GET['cur'] . " and clase=" . $_GET['gru']);

	$objGrid -> setHeader();
?>
</head>

<body>
<?php 
	/* AJAX inline edition comes in two flawors */
	/*	silent: To save record, just enter or double click */
	/*	default: To save record, must click icon */
	/* try yourself and see which one likes more (My preferred is silent) */
	$objGrid -> ajax("silent");

	$objGrid -> grid();
	
	$objGrid -> desconectar();
?>
</body>
</html>
