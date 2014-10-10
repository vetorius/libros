<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2014 Victor Manuel Sanchez
 *
 * archivo emitir_factura.php
 *
 * crea datos de una factura contable
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
if (!isset($_POST['submit'])) {

	if (!isset($_GET['id_factura'])) die('No hay id de factura');
	$idfact = $_GET['id_factura'];

?>
	<form action="fra_contable.php" method="POST">

		<input name="idfact" type="hidden" value="<?php echo $idfact;?>" />
		<table width="450" cellspacing="2" cellpadding="2" border="0">

		<tr><td colspan="2" align="center" bgcolor=#cccccc>
		Datos para la factura</td></tr>
		
		<tr><td align="right">nombre del titular:</td>
		<td><input name="nom" type="text" size="30"></td></tr>
		
		<tr><td align="right">NIF titular:</td>
		<td><input name="nif" type="text" size="30"></td></tr>
		<!--
		<tr><td align="right">segundo apellido:</td>
		<td><input name="ap2" type="text" size="30"></td></tr>
-->
		<tr><td align="right">fecha (AAAA-MM-DD):</td>
		<td><input name="fecha" type="text" size="20" /></td></tr>
		
		<tr><td align="right">n&uacute;mero de factura general:</td>
		<td><input name="fra" type="text" size="20"  /></td></tr>
		
		<tr><td align="right"><input type="reset" value="borrar" /></td>
		<td align="left"><input type="submit" name="submit" value="aceptar" /></td></tr>
		</table>
	</form>
<?php 
} else {
	// inicializo variables
	$valido = 1;
	$error_text = '';

// Eliminado porque se hace autonumerico
//	$id_alumno = $_POST['id_alumno'];

	$nom = $_POST['nom'];
	$nif = $_POST['nif'];
	$id_factura = $_POST['idfact'];
	$fecha = $_POST['fecha'];
	$fra = $_POST['fra'];
	
	//validar los datos
	

	if (!$valido) {

	//mensaje si no es valido algun campo

	} else {
	// insertamos los datos de la factura y redirigimos a imprimir la factura
	
		$base = new DBmy();
		$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ('conexion erronea');
	
	// consulta para insertar los datos de la factura
		
		$sql = "UPDATE facturas ";
		$sql .= "SET titular='$nom', nif_titular='$nif', ";
		$sql .= "fecha_factura='$fecha', numcontable='$fra', emitida=1 ";
		$sql .= "WHERE id_factura=$id_factura";
		$base->consulta($sql) or die ("Actualizaci&oacute;n de factura erronea");
	
		echo '<h3>Datos de la factura insertados correctamente</h3>';
		echo '<a href="pdf/factura_contable.php?id_factura='.$id_factura.'" target="_blank">Continuar</a><br>';		
	}
}
?>
</body>
</html>
