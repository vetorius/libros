<?php 

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo intro_fact.php
 *
 * inserta los datos de la factura en la base de datos
 *
 */

include "inc/seguridad.inc.php";
include "inc/config.inc.php";

if ((!isset($_POST['curso'])) or (!isset($_POST['opcion']))) {

	echo 'Variables no definidas';	

} else if (isset($_POST['materias'])) {

	require_once ("inc/mysql.class.php");

	$materias = $_POST['materias'];
	$curso = $_POST['curso'];
	$opcion = $_POST['opcion'];

	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ('conexion erronea');

// eliminamos la posible opcion 
	$sql  = "DELETE FROM opciones ";
	$sql .= "WHERE id_curso=".$curso." and id_opcion=".$opcion;
	$base->consulta($sql) or die ("consulta erronea");
	
// insertamos las materias de la opcion
	foreach ($materias as $inserto) {
		$sql = "INSERT INTO opciones (id_opcion, id_curso, id_materia)";
		$sql .= " VALUES (" . $opcion . ", " . $curso . ", " . $inserto . ")";
		$base->consulta($sql) or die ("insercion de materia $inserto erronea");
	}

	header("Location: opciones.php?cur=" . $curso);

} else {

	header("Location: opciones.php?cur=" . $curso);

}
?>

