<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo contar_alumnos.php
 *
 * cuenta los alumnos que cursan cada materia de un curso
 *
 */

include "inc/seguridad.inc.php";
include "inc/config.inc.php";

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>n&uacute;mero de alumnos por materia</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>
<body>
<?php
if (isset($_GET['cur'])) { // si exise la variable de GET cur
	// mostramos el numero de alumnos que cursan cada materia para ese curso
	require_once ("inc/mysql.class.php");
	$curso = $_GET['cur'];
	
	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ("conexion erronea");
	$sql  = "SELECT ma.id_materia, ma.materia, count(id_alumno) as total ";
	$sql .= "FROM alu_mat am INNER JOIN materias ma USING(id_materia) ";
	$sql .= "WHERE ma.id_curso=".$curso;
	$sql .= " GROUP BY ma.id_materia";
	// echo $sql."<br  />";
	$base->consulta($sql) or die ("consulta alumnos por materia erronea");
	
	echo "<h3>N&uacute;mero de alumnos que cursan cada materia de " . cualcurso($curso) . "</h3>";

        echo "<table border=1 width='350'>";
        // mostramos los nombres de los campos
        echo "<tr><td><b>Materia</b></td><td>total</td></tr>";
        while ($row = $base->obtenerfila()) {
            echo '<tr><td><a href="lista_materia.php?materia='.$row[0].'" target="_blank">'.$row[1].'</a></td><td>'.$row[2].'</td></tr>';
        }
        echo "</table>";


	
		
} else { // si no exise la variable de GET cur
	// mostramos el formulario
?>
	<form action="contar_alumnos.php" method="GET">
	<table width="300" cellspacing="2" cellpadding="2" border="0">
	<tr>
	<td colspan="2" align="center" bgcolor=#cccccc>
	Elegir curso
	</td>
	</tr>
	<tr>
	<td align="right">curso:</td>
	<td><select name="cur" id="cur">
	  <option value="1" selected>1&ordm; ESO</option>
	  <option value="2">2&ordm; ESO</option>
	  <option value="3">3&ordm; ESO</option>
	  <option value="4">4&ordm; ESO</option>
	  <option value="5">1&ordm; Bachillerato</option>
	  <option value="6">2&ordm; Bachillerato</option>
	</select></td>
	</tr>
	<tr>
	<td colspan="2" align="center"><input type="Submit" value="Contar alumnos"></td>
	</tr>
	</table>
	</form>
<?php
}
?>

</body>
</html>

