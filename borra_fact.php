<?php 

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo borra_fact.php
 *
 * borra una factura de la base de datos
 *
 */

include "inc/seguridad.inc.php";
include "inc/config.inc.php";

if (!isset($_GET['id_alumno'])) {

	echo 'Variables no definidas';	

} else if (isset($_GET['id_factura'])) {

	require_once ("inc/mysql.class.php");

	$id_factura = $_GET['id_factura'];

	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ('conexion erronea');
// borramos el registro de la factura
	$sql = "DELETE FROM facturas ";
	$sql .= "WHERE id_factura=" . $id_factura;
	$base->consulta($sql) or die ("borrado de factura erronea.");
	
// borramos los libros de la factura
/*
	$sql = "INSERT INTO fact_lib (id_factura, id_libro)";
	$sql .= " VALUES (" . $id_factura . ", " . $inserto . ")";
	$base->consulta($sql) or die ("insercion de libro $inserto erronea");
 */

	header("Location: fact_sel.php?id_alumno=" . $_GET['id_alumno']);

} else {

	header("Location: fact_sel.php?id_alumno=" . $_GET['id_alumno']);

}
?>

