<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo busca_fact.php
 *
 * selecciona las facturas del alumno a partir 
 * del número de factura
 *
 */

include "inc/seguridad.inc.php";

if (isset($_GET['id_factura'])) {
	include "inc/config.inc.php";
	require_once ("inc/mysql.class.php");
	$id_factura = $_GET['id_factura'];
	
	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ('conexion erronea');

// consulta para obtener el nombre del alumno
	$sql = "SELECT id_alumno FROM facturas";
	$sql .= " WHERE id_factura=" . $id_factura;
	$base->consulta($sql) or die ("consulta alumno erronea"); 
	if ($base->numregistros() > 0) {	
		$datos = $base->obtenerfila();
		header("Location: fact_sel.php?id_alumno=" . $datos['id_alumno']);
	} else {
		// no existe la factura
		echo "ERROR: La factura que se ha indicado no existe.";
	}
} else {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Documento sin t&iacute;tulo</title>
<link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>
<body onLoad="javascript:document.getElementById('id_fa').focus();">
	<form action="busca_fact.php" method="GET">
		<table width="400" cellspacing="2" cellpadding="2" border="0">
		<tr>
		<td colspan="3" align="center" bgcolor=#cccccc>
		Busqueda de la factura y alumno para validar
		</td>
		</tr>
		<tr>
		<td align="right">c&oacute;digo de la factura:</td>
		<td><input id="id_fa" name="id_factura" type="text" size="20" maxlength="4"></td>
		<td align="center"><input type="submit" value="aceptar"></td>
		</tr>
		</table>
	</form>
</body>
</html>
<?php 
}
?>

