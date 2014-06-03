<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo asigna_mat.php
 *
 * actualiza la tabla alu_mat con las opciones de cada alumno
 *
 */
 
include "inc/seguridad.inc.php";
include "inc/config.inc.php";
require_once ("inc/mysql.class.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::: Gestion de libros ::: principal</title>
<link rel="stylesheet" type="text/css" href="css/estilo.css" />
</head>
<body>
<?php
// accedemos a la base de datos
	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ("conexion alumnos erronea");

// Borrar asignaciones automáticas previas
	$sql = "DELETE FROM alu_mat WHERE tipo_asig='A'";
	$base->consulta($sql) or die ('Consulta de eliminacion erronea');

// asignacion de materias a los alumnos no repetidores

	$sql = "INSERT INTO alu_mat ";
	$sql .= "SELECT al.id_alumno, op.id_materia, 'A' FROM alumnos al, opciones op ";
	$sql .= "WHERE al.id_curso=op.id_curso and al.opcion=op.id_opcion and al.repite=0 and al.baja=0";
	$base->consulta($sql) or die ('Asignacion erronea');

// asignacion a los alumnos repetidores
	$sql = "INSERT INTO alu_mat ";
	$sql .= "SELECT al.id_alumno, op.id_materia, 'A' FROM alumnos al, opciones op ";
	$sql .= "WHERE al.id_curso-1=op.id_curso and al.opcion=op.id_opcion and al.repite=1 and al.baja=0";
	$base->consulta($sql) or die ('Asignacion erronea');
?>
<h3>Materias asignadas correctamente a los alumnos.</h3>
</body>
</html>
