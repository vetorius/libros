<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo busca_alu.php
 *
 * busca a un alumno a partir 
 * del primer apellido
 *
 */

include "inc/seguridad.inc.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Buscar alumno por apellido</title>
<link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>
<?php
if (isset($_GET['apellido'])) {
	echo '<body>';
	include "inc/config.inc.php";
	require_once ("inc/mysql.class.php");
	$apellido = $_GET['apellido'];
	
	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ('conexion erronea');

// consulta para obtener a los alumnos
	$sql = "SELECT id_alumno, nom, ap1, ap2 FROM alumnos";
	$sql .= " WHERE ap1 LIKE '%" . $apellido . "%'";
//	echo $sql;
	$base->consulta($sql) or die ("consulta alumno erronea"); 
	if ($base->numregistros() > 0) {
		echo '<table width="500">';
		echo '<tr><th align="center" bgcolor=#cccccc>Alumnos encontrados<th/><tr/>';
		while ($datos = $base->obtenerfila()) {
			echo '<tr><td>';
			echo '<a href="fact_sel.php?id_alumno='.$datos['id_alumno'];
			echo '">';
			echo $datos['ap1']." ".$datos['ap2'].", ".$datos['nom'];
			echo '</a></td></tr>';
		}
		echo '</table></body></html>';
	} else {
		// no existe la factura
		echo '<h2>No se ha encontrado al alumno.</h2>';
		echo '<a href="busca_alu.php">volver</a></body></html>';
	}
} else {
?>
<body onLoad="javascript:document.getElementById(ape').focus();">
	<form action="busca_alu.php" method="GET">
		<table width="500" cellspacing="2" cellpadding="2" border="0">
		<tr>
		<td colspan="3" align="center" bgcolor=#cccccc>
		Busqueda del alumno por apellido para validar
		</td>
		</tr>
		<tr>
		<td align="right">primer apellido:</td>
		<td><input id="ape" name="apellido" type="text" size="30" maxlength="50"></td>
		<td align="center"><input type="submit" value="aceptar"></td>
		</tr>
		</table>
	</form>
</body>
</html>
<?php 
}
?>

