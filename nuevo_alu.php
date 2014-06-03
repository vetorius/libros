<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo nuevo_alu.php
 *
 * inserta un nuevo alumno y genera el proceso completo
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
?>
	<form action="nuevo_alu.php" method="POST">
		<table width="450" cellspacing="2" cellpadding="2" border="0">

		<tr><td colspan="2" align="center" bgcolor=#cccccc>
		Datos del nuevo alumno</td></tr>
		
		<tr><td align="right">nombre del alumno:</td>
		<td><input name="nom" type="text" size="30"></td></tr>
		
		<tr><td align="right">apellidos:</td>
		<td><input name="ap1" type="text" size="30"></td></tr>
		<!--
		<tr><td align="right">segundo apellido:</td>
		<td><input name="ap2" type="text" size="30"></td></tr>
-->
		<tr><td colspan="2" align="center">curso actual: <input name="curso" type="text" size="5" maxlength="1" />&nbsp;-&nbsp;
		opcion: <input name="opcion" type="text" size="5" maxlength="2" /></td></tr>
		
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
	$ap1 = $_POST['ap1'];
//	$ap2 = $_POST['ap2'];
	$curso = $_POST['curso'];
	$opcion = $_POST['opcion'];
	
	//validar los datos
	

	if (!$valido) {

	//mensaje si no es valido algun campo

	} else {
	// insertamos los datos y la opcion del alumno y redirigimos a fact_sel.php
	
		$base = new DBmy();
		$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ('conexion erronea');
	
	// consulta para insertar los datos del alumno
		$clase = 4;
		
		$sql = "INSERT INTO alumnos (nom, ap1, id_curso, clase, opcion)";
		$sql .= " VALUES ('$nom', '$ap1', $curso, $clase, $opcion)";
		$base->consulta($sql) or die ("insercion de alumno erronea"); 
		$id_alumno = $base->ultimoid();

// Borrar asignaciones previas del alumno
		$sql = "DELETE FROM alu_mat WHERE id_alumno=$id_alumno";
		$base->consulta($sql) or die ('Consulta de eliminacion erronea');

// asignacion para el alumno nuevo alumnos nuevos

		$sql = "INSERT INTO alu_mat ";
		$sql .= "SELECT al.id_alumno, op.id_materia, 'A' FROM alumnos al, opciones op ";
		$sql .= "WHERE al.id_curso=op.id_curso and al.opcion=op.id_opcion and id_alumno=$id_alumno";
		$base->consulta($sql) or die ('Asignacion erronea');
	
		echo '<h3>Alumno insertado correctamente.</h3>';
		echo '<a href="fact_sel.php?id_alumno='.$id_alumno.'">Continuar</a><br>';		
	}
}
?>
</body>
</html>
