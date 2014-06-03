<?php 

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo pedidos.php
 *
 * gestiona los pedidos de libros
 *
 */

include "inc/seguridad.inc.php";
include "inc/config.inc.php";
require_once ("inc/mysql.class.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>gestion de pedidos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="css/estilo.css" />
</head>
<body>
<?php
	if (isset($_GET['submit']))
	{
// crear nuevo pedido
		$fecha = $_GET['fecha'];
		$descripcion = $_GET['descr'];
		$crear = new DBmy();
		$crear->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ('conexion crear factura erronea');
// comprobamos que hay nuevos libros para generar pedido		
		$sql = "SELECT count(*) FROM facturas ";
		$sql .= " WHERE id_pedido=0";
		$crear->consulta($sql) or die ("error buscando facturas nuevas");
		$nuevas=$crear->obtenerfila();
		if ($nuevas[0]>0) {
		// creamos el registro del nuevo pedido
			$sql = "INSERT INTO pedidos (f_pedido, descripcion)";
			$sql .= " VALUES ('$fecha', '$descripcion')";
			$crear->consulta($sql) or die('consulta de creacion de pedido erronea');
		// capturamos el ID del registro creado
			$nuevo_pedido = $crear->ultimoid();
		// actualizamos las facturas con id_pedido cero
			$sql = " UPDATE facturas SET id_pedido=".$nuevo_pedido;		
			$sql .= " WHERE id_pedido=0";
			$crear->consulta($sql) or die('consulta de actualizacion de facturas');	
		} else {
		// no hay facturas para un nuevo pedido
			echo '<table width="600" cellspacing="2" cellpadding="2" border="0">';
			echo '<tr><td colspan="2" align="center" bgcolor=#cccccc>';
			echo 'No hay facturas para un nuevo pedido';
			echo '</td></tr></table>';
			
		}
	}
// mostrar los pedidos

	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ('conexion erronea');

	$sql  = "SELECT id_pedido, f_pedido, descripcion FROM pedidos ORDER BY f_pedido";
	$base->consulta($sql) or die ("consulta total pedidos erronea");

	echo '<table width="700" cellspacing="2" cellpadding="2" border="0">';
	if ($base->numregistros()>0) {
		echo '<tr><td colspan=54 align="center" bgcolor=#cccccc>Listado de pedidos</td></tr>';
		while ($datos = $base->obtenerfila()) {
			echo '<tr><td width="350">' . sprintf("%02d",$datos[0]) .' - '. $datos[1] .' - ';
			echo $datos[2];
			echo '</td>';
			echo '<td><a href="csv_pedido.php?pedido='.$datos[0];
			echo '">descargar</a></td>';
			echo '<td><a href="pdf/pdf_pedido.php?pedido='.$datos[0];
			echo '" target="_blank">imprimir</a></td>';
			echo '<td><a href="borra_pedido.php?pedido='.$datos[0].'">eliminar</a></td>';
			echo '<td><a href="pdf/pdf_facturas.php?pedido='.$datos[0];
			echo '" target="_blank">imprimir facturas</a></td></tr>';
		}
		echo '</table>';
	} else {
		echo '<tr><td align="center" bgcolor=#cccccc>No hay pedidos</td></tr></table>';
	}
	
	$sql = "SELECT count(*) FROM facturas WHERE id_pedido=0";
	$base->consulta($sql) or die ("consulta facturas nuevas erronea");
	if ($base->numregistros()>0) {
		$total = $base->obtenerfila();
		$facturas_nuevas = $total[0];
	}
	
?>

<form action="pedidos.php" method="get">
<table width="700" cellspacing="2" cellpadding="2" border="0">
<tr>
<td colspan="2" align="center" bgcolor=#cccccc>
Crear un nuevo pedido con las facturas nuevas
</td>
</tr>
<tr><td align="right">fecha (aaaa-mm-dd):</td>
<td><input type="text" name="fecha" size="12" maxlength="50" /></td></tr>
<tr><td align="right">descripci&oacute;n:</td>
<td><input type="text" name="descr" size="40" maxlength="50" /></td></tr>
<tr>
<td colspan="2" align="center"><input type="submit" name="submit" value="Crear pedido" /></td>
</tr>
<tr>
<td colspan="2" align="center"><a href="pdf/pdf_facturas.php?pedido=0" target="_blank">Hay <?php echo $facturas_nuevas; ?> facturas nuevas sin pedido asignado.</a></td>
</tr>
</table>
</form>
</body>
</html>
