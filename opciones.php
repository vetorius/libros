<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo opciones.php
 *
 * Gestiona las opciones por curso
 *
 */

include "inc/seguridad.inc.php";
include "inc/config.inc.php";
require_once ("inc/mysql.class.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>hojas de pedido por clase</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>
<body>
<?php 
if (!isset($_GET['cur'])) {
?>
	<form action="opciones.php" method="GET">
		<table width="400" cellspacing="2" cellpadding="2" border="0">
		<tr>
		<td colspan="3" align="center" bgcolor=#cccccc>
		Gestión de la optatividad por cursos
		</td>
		</tr>
		<tr>
		<td align="right">curso:</td>
		<td><select name="cur" id="cur">
		  <option value="0" selected>1&ordm; ESO</option>
		  <option value="1">2&ordm; ESO</option>
		  <option value="2">3&ordm; ESO</option>
		  <option value="3">4&ordm; ESO</option>
		  <option value="4">1&ordm; Bachillerato</option>
		  <option value="5">2&ordm; Bachillerato</option>
		</select></td>
		<td align="center"><input type="submit" value="aceptar"></td>
		</tr>
		</table>
	</form>
<?php 
} else {
	$curso = $_GET['cur'];
	
	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ('conexion erronea');

	// consulta para obtener las opciones del curso marcado
	$sql = "SELECT DISTINCT id_opcion FROM opciones";
	$sql .= " WHERE id_curso=" . $curso;
	$base->consulta($sql) or die ("consulta opciones erronea"); 
	echo '<table width="500" cellspacing="2" cellpadding="2" border="0">';
	if ($base->numregistros()>0) {
		echo '<tr><td colspan=4 align="center" bgcolor=#cccccc>Opciones para '.cualcurso($curso+1).'</td></tr>';
		while ($datos = $base->obtenerfila()) {
			echo '<tr><td width="300">' . $datos['id_opcion'];
			echo '</td>';
			echo '<td><a href="crea_opcion.php?opcion='.$datos['id_opcion'].'&curso='.$curso;
			echo '&op=1">mostrar</a></td>';
			echo '<td><a href="crea_opcion.php?opcion='.$datos['id_opcion'].'&curso='.$curso;
			echo '&op=2">modificar</a></td>';
			echo '<td><a href="crea_opcion.php?opcion='.$datos['id_opcion'].'&curso='.$curso;
			echo '&op=3">eliminar</a></td>';
		}
		echo '</table>';
	} else {
		echo '<tr><td align="center" bgcolor=#cccccc>No se han definido opciones para '.cualcurso($curso+1).'</td></tr></table>';
	}
	echo '<br><br>';
	echo '<form action="crea_opcion.php" method="GET">';
	echo '<input name="curso" type="hidden" value="'.$curso.'" />';
	echo '<input name="op" type="hidden" value="2" />';
	echo '<input name="opcion" type="text" size="5" maxlength="2" />';
	echo '<input type="submit" value="crear nueva">';
}
?>

</body>
</html>

