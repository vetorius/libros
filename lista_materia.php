<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2013 Victor Manuel Sanchez
 *
 * archivo lista_materia.php
 *
 * lista con los alumnos por materias
 *
 */

include "inc/seguridad.inc.php";
include "inc/config.inc.php";
require_once ("inc/mysql.class.php");

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>alumnos por materias</title>
</head>
<body>
<?php
if (isset($_GET['materia'])) {
	$materia = $_GET['materia'];
} else {
	$materia = 1;
}
$laclase = array(	1 => 'A',
			2 => 'B',
			3 => 'C');

$base = new DBmy();
$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ('conexion erronea');

// consulta para obtener el nombre de la materia

$sql = "SELECT materia FROM materias WHERE id_materia=" . $materia;

$base->consulta($sql) or die ("consulta para  obtener el nombre de la materia erronea");
if ($base->numregistros()>0) {
	// pintamos la cabecera del informe
    $nombremateria=$base->obtenerfila();
    echo '<h2>Alumnos para la materia ' . $nombremateria[0] . '</h2>';

	// consulta para obtener los alumnos

    $sql  = "SELECT a.id_alumno, ";
    $sql .= "a.nom, a.ap1, a.ap2, a.clase_n ";
    $sql .= "FROM alumnos a inner join alu_mat m using(id_alumno) ";
    $sql .= "WHERE m.id_materia=".$materia;
    $sql .= " ORDER BY a.clase_n, a.ap1, a.ap2";

    $contar = 0;
    $base->consulta($sql) or die ("consulta facturas lista_fact erronea");
    echo '<table cellspacing="2" cellpadding="2" border="1">';
    if ($base->numregistros()>0) {
        echo '<tr><td colspan=6 align="center" bgcolor=#cccccc>facturas para ' . cualcurso($curso,$grupo) . '</td></tr>';
	echo '<tr><td>num</td><td>id</td><td>nombre</td><td>clase</td></tr>';
	while ($datos = $base->obtenerfila()) {
		$contar++;
		$nombre = $datos['ap1']." ".$datos['ap2'].", ".$datos['nom'];
		echo '<tr><td width="30">'. sprintf("%02d",$contar) .'</td>';
		echo '<td width="40">' . sprintf("%04d",$datos['id_alumno']) .'</td>';
		echo '<td width="300"><a href="fact_sel.php?id_alumno='. $datos['id_alumno'].'">'. $nombre .'</a></td>';
		echo '<td>' . $laclase[$datos['clase_n']] . '</td></tr>';
	}
	echo '</table>';
    } else {
	echo '<tr><td align="center" bgcolor=#cccccc>No hay alumnos para esta materia</td></tr></table>';
    }
} else {
    echo 'Materia incorrecta...';
}
?>
</body>
</html>
