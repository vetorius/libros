<?php 

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo valida_fact.php
 *
 * valida una factura de la base de datos
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
	$sql = "UPDATE facturas SET acepta = CASE WHEN acepta=1 THEN 0 ELSE 1 END ";
	$sql .= "WHERE id_factura=" . $id_factura;
	$base->consulta($sql) or die ("validacion de factura erronea.");
	
	if (isset($_GET['lista'])) {
		header('Location: lista_fact.php?val='.$_GET['lista']);	
	} else {
		header('Location: fact_sel.php?id_alumno=' . $_GET['id_alumno']);
	}

} else {

	if (isset($_GET['lista'])) {
		header('Location: lista_fact.php?val='.$_GET['lista']);	
	} else {
		header("Location: fact_sel.php?id_alumno=" . $_GET['id_alumno']);
	}
}
?>

