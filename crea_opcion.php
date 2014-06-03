<?php 

/*
 * Gestion de libros v 0.1
; *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo crea_fact.php
 *
 * formulario de introduccion de pedido para generar factura
 *
 */
include "inc/seguridad.inc.php";
include "inc/config.inc.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::: Gestion de libros ::: crear factura</title>
<link rel="stylesheet" type="text/css" href="css/estilo.css" />
</head>
<body>
<?php

if (isset($_GET['opcion']) and isset($_GET['curso']) and isset($_GET['op'])) {

	$op = $_GET['op'];
	$curso = $_GET['curso'];
	$opcion = $_GET['opcion'];

	require_once ("inc/mysql.class.php");
	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ("conexion erronea");


	if ($op==1) {
	// mostrar la opcion
		$sql  = "SELECT m.materia ";
		$sql .= "FROM opciones op INNER JOIN materias m USING(id_materia)";
		$sql .= " WHERE op.id_curso=".$curso." and id_opcion=".$opcion;
		$sql .= " ORDER BY m.tipo";
		// echo $sql."<br>";
		$base->consulta($sql) or die ("consulta op1 erronea");
		$base->verconsulta(350);
		echo '<a href="opciones.php?cur='.$curso.'">volver</a>';
		
	} else if ($op==2) {
	// crear - modificar la opcion
		$curso_sig = $curso + 1;
		$sql  = "SELECT id_materia, materia, tipo FROM materias ";
		$sql .= "WHERE id_curso=".$curso_sig;
		$sql .= " ORDER BY tipo";
		$base->consulta($sql) or die ("consulta erronea");
?>
		<form action="intro_opcion.php" method="post">
			<input name="curso" type="hidden" value="<?php echo $curso; ?>" />
			<input name="opcion" type="hidden" value="<?php echo $opcion; ?>" />
			<table width="600" cellspacing="2" cellpadding="2" border="0">
			<tr><td align="center" bgcolor=#cccccc>
			Seleccione las materias para la opci&oacute;n <?php echo $opcion; ?></td></tr>
<?php
			$i = 0;
			while ($datos = $base->obtenerfila()) {
				echo '<tr><td><label for="f'.$i.'"><input type="checkbox" name="materias[]" value="';
				echo $datos[0];
				echo '" id="f'.$i.'" checked />';
				echo $datos[1] . '</label></td></tr>';
				$i++;
			}
?>	 
			<tr><td align="center"><input type="submit" name="Submit" value="Enviar" />
			</td></tr></table>
		</form>
<?php	
	} else if ($op==3) {
	// eliminar la opcion
		$sql  = "DELETE FROM opciones ";
		$sql .= "WHERE id_curso=".$curso." and id_opcion=".$opcion;
		$base->consulta($sql) or die ("consulta erronea");
		echo 'Opci&oacute;n eliminada.<br>';
		echo '<a href="opciones.php?cur='.$curso.'">volver</a>';
	}
}


?>
</body>
</html>
