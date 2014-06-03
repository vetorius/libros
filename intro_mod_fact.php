<?php 

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo intro_mod_fact.php
 *
 * modifica los datos de la factura en la base de datos
 *
 */

include "inc/seguridad.inc.php";
include "inc/config.inc.php";

if ((!isset($_POST['id_alumno']))or(!isset($_POST['id_factura']))) {

	echo 'Variables no definidas';	

} else if (isset($_POST['libros'])) {

	require_once ("inc/mysql.class.php");

	$libros = $_POST['libros'];
	$id_factura = $_POST['id_factura'];
	
	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ('conexion erronea');
// borramos los datos anteriores de la factura
	$sql = "DELETE FROM fact_lib ";
	$sql .= "WHERE id_factura=" . $id_factura;
	$base->consulta($sql) or die ("borrado de factura erronea");
	
// insertamos los libros de la factura
	foreach ($libros as $inserto) {
		$sql = "INSERT INTO fact_lib (id_factura, id_libro)";
		$sql .= " VALUES (" . $id_factura . ", " . $inserto . ")";
		$base->consulta($sql) or die ("insercion de libro $inserto erronea");
	}

// calculamos el total de la factura y actualizamos la fecha
	$sql = "SELECT sum(libros.precio) FROM libros INNER JOIN fact_lib USING (id_libro) ";
	$sql .= "WHERE fact_lib.id_factura=" . $id_factura;
	$base->consulta($sql) or die ("error calculando el total");
	if ($base->numregistros() > 0) {
		$datos=$base->obtenerfila();
		$sql = "UPDATE facturas SET total=".$datos[0];
		$sql .= " WHERE id_factura=" . $id_factura;
		$base->consulta($sql) or die ("error al actualizar total");	
	}	
	
	header("Location: fact_sel.php?id_alumno=" . $_POST['id_alumno']);

} else {

	header("Location: fact_sel.php?id_alumno=" . $_POST['id_alumno']);

}
?>

