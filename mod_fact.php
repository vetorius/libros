<?php 

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo mod_fact.php
 *
 * formulario para modificar una factura
 * 
 */
include "inc/seguridad.inc.php";
include "inc/config.inc.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::: Gestion de libros ::: modificar factura</title>
<link rel="stylesheet" type="text/css" href="css/estilo.css" />
</head>
<body>
<?php
if ((isset($_GET['id_alumno'])) and (isset($_GET['id_factura']))) {
	require_once ("inc/mysql.class.php");

	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ("conexion erronea");
//	buscamos los datos de la factura
	$sql  = "SELECT id_libro ";
	$sql .= "FROM fact_lib WHERE id_factura=" . $_GET['id_factura'];
	$base->consulta($sql) or die ("consulta de datos de factura erronea");
	$libros=$base->obtenerarray(0);
	
//  buscamos los datos de los libros a incluir	
	$sql  = "SELECT li.id_libro, ma.materia, li.titulo, ed.editorial, li.isbn, li.precio ";
	$sql .= "FROM editoriales ed INNER JOIN libros li USING (id_editorial) ";
	$sql .= "INNER JOIN materias ma USING (id_materia) ";
	$sql .= "INNER JOIN alu_mat alma USING (id_materia) ";
	$sql .= "WHERE alma.id_alumno=".$_GET['id_alumno'];
	$sql .= " and li.gratuidad=0 ORDER BY ma.tipo, ma.materia, li.titulo";
	$base->consulta($sql) or die ("consulta de libros erronea");
?>
<form action="intro_mod_fact.php" method="post">
	<input name="id_alumno" type="hidden" value="<?php echo $_GET['id_alumno']; ?>" />
	<input name="id_factura" type="hidden" value="<?php echo $_GET['id_factura']; ?>" />
	<table width="600" cellspacing="2" cellpadding="2" border="0">
	<tr><td align="center" bgcolor=#cccccc>Seleccione los items a comprar</td></tr>

<?php
	$i = 0;
	while ($datos = $base->obtenerfila()) {
		echo '<tr><td><label for="f'.$i.'"><input type="checkbox" name="libros[]" value="';
		echo $datos[0];
		echo '" id="f'.$i.'"';
		if (in_array ($datos[0], $libros))
			echo ' checked';
		echo ' />' . $datos[1] .' - ' . $datos[2] .' - ' . $datos[3];
		echo '</label></td></tr>';
		$i++;
	}
}
?>
	<tr>
	<td align="center">
	<input type="submit" name="Submit" value="Enviar" />
	</td></tr></table>
</form>
</body>
</html>
