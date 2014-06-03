<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo lista_alu_fact.php
 *
 * lista con las facturas emitidas
 *
 */

include "inc/seguridad.inc.php";
include "inc/config.inc.php";
require_once ("inc/mysql.class.php");

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Facturas por clase</title>
</head>
<body>
<?php
if (isset($_GET['cur'])) {
	$curso = $_GET['cur'];
} else {
	$curso = 0;
}
if (isset($_GET['gru'])) {
	$grupo = $_GET['gru'];
} else {
	$grupo = 1;
}
$laclase = array(	1 => 'A',
					2 => 'B',
					3 => 'C');

$base = new DBmy();
$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ('conexion erronea');

// consulta para obtener las facturas

$sql  = "SELECT a.id_alumno, f.id_factura, ";
$sql .= "a.nom, a.ap1, a.ap2, a.id_curso ";
$sql .= "FROM alumnos a left join facturas f using(id_alumno)";
$sql .= "WHERE (a.id_curso=$curso and a.clase=$grupo) ";
$sql .= "ORDER BY a.ap1, a.ap2";
$contar = 0;
$base->consulta($sql) or die ("consulta facturas lista_fact erronea");
echo '<table cellspacing="2" cellpadding="2" border="1">';
if ($base->numregistros()>0) {
	echo '<tr><td colspan=6 align="center" bgcolor=#cccccc>facturas para ' . cualcurso($curso,$grupo) . '</td></tr>';
	echo '<tr><td>num</td><td>id</td><td>nombre</td><td>factura</td></tr>';
	while ($datos = $base->obtenerfila()) {
		$contar++;
		$nombre = $datos['ap1']." ".$datos['ap2'].", ".$datos['nom'];
		echo '<tr><td width="30">'. sprintf("%02d",$contar) .'</td>';
		echo '<td width="40">' . sprintf("%04d",$datos['id_alumno']) .'</td>';
		echo '<td width="300"><a href="fact_sel.php?id_alumno='. $datos['id_alumno'].'">'. $nombre .'</a></td>';
		echo '<td width="80" align="right">'. sprintf('%04d',$datos['id_factura']) .' </td></tr>';
	}
	echo '</table>';
} else {
	echo '<tr><td align="center" bgcolor=#cccccc>No hay facturas</td></tr></table>';
}
?>
</body>
</html>
