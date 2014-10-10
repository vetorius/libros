<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo fact_sel.php
 *
 * selecciona el alumno para crear una factura
 *
 */

include "inc/seguridad.inc.php";
include "inc/config.inc.php";
require_once ("inc/mysql.class.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Selecci&oacute;n alumnos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>

<?php 
if (!isset($_GET['id_alumno'])) {
?>
	<body onLoad="javascript:document.getElementById('id_al').focus();">
	<form action="fact_sel.php" method="GET">
		<table width="400" cellspacing="2" cellpadding="2" border="0">
		<tr>
		<td colspan="3" align="center" bgcolor=#cccccc>
		Seleccionar al alumno
		</td>
		</tr>
		<tr>
		<td align="right">c&oacute;digo del alumno:</td>
		<td><input id="id_al" name="id_alumno" type="text" size="20" maxlength="12" ></td>
		<td align="center"><input type="submit" value="aceptar"></td>
		</tr>
		</table>
	</form>
<?php 
} else {
	echo '<body>';
	$id_alumno = $_GET['id_alumno'];
	
	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ('conexion erronea');

// consulta para obtener el nombre del alumno
	$sql = "SELECT nom, ap1, ap2 FROM alumnos";
	$sql .= " WHERE id_alumno=" . $id_alumno;
	$base->consulta($sql) or die ("consulta alumno erronea"); 
	if ($base->numregistros() > 0) {	
		$datos = $base->obtenerfila();
		$alumno = $datos['ap1'] . " " . $datos['ap2'] . ", " . $datos['nom'];

	// consulta para obtener las facturas del alumno
		$sql = "SELECT id_factura, f_emision, id_pedido, total, emitida FROM facturas";
		$sql .= " WHERE id_alumno=" . $id_alumno;
		$base->consulta($sql) or die ("consulta facturas erronea"); 
		echo '<table width="600" cellspacing="2" cellpadding="2" border="0">';
		if ($base->numregistros()>0) {
			echo '<tr><td colspan=5 align="center" bgcolor=#cccccc>Facturas para '.$alumno.'</td></tr>';
			while ($datos = $base->obtenerfila()) {
				if ($datos['4']) { $emit = " - emitida"; } else { $emit = ""; }
				echo '<tr><td width="300">' . sprintf("%04d",$datos[0]) .' - ';
				echo $datos[1] . ' - ' . $datos[3] . ' &#0128;';
				echo ' - ' . $datos[2] . $emit;
				echo '</td>';
				echo '<td><a href="fra_contable.php?';
				echo 'id_factura='.$datos[0].'">Fra. real</a></td>';
				echo '<td><a href="mod_fact.php?id_alumno='.$id_alumno;
				echo '&id_factura='.$datos[0].'">modificar</a></td>';
				echo '<td><a href="pdf/pdf_fact.php?id_alumno='.$id_alumno;
				echo '&id_factura='.$datos[0].'" target="_blank">imprimir</a></td>';
				echo '<td><a href="borra_fact.php?id_alumno='.$id_alumno;
				echo '&id_factura='.$datos[0].'">borrar</a></td></tr>';
			}
			echo '</table>';
		} else {
			echo '<tr><td align="center" bgcolor=#cccccc>No hay facturas para '.$alumno.'</td></tr></table>';
		}
		echo '<br><br>';
		echo '<a href="pdf/pdf_form_uno.php?id_alumno='.$id_alumno;
		echo '" target="_blank">Imprimir hoja de pedido</a><br>';
		echo '<a href="crea_fact.php?id_alumno='.$id_alumno.'">Crear nueva factura</a><br>';
		echo '<a href="fact_sel.php">Volver</a><br>';
	} else {
		?>
		<table width="400" cellspacing="2" cellpadding="2" border="0">
		<tr>
		<td align="center" bgcolor=#cccccc>El alumno no existe</td></tr>
		<tr><td><a href="fact_sel.php">volver</a></td></tr>
		</table>	
		<?php
	}
}
?>

</body>
</html>

