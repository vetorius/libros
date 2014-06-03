<?php 

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo dpto.php
 *
 * muestra una lista de departamentos 
 *
 * con enlaces al PDF con sus libros
 *
 */

include "inc/seguridad.inc.php";
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

	require_once ("inc/mysql.class.php");
	include "inc/config.inc.php";

	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ("conexion erronea");
	$sql = "SELECT id_departamento, departamento FROM departamentos";
	$base->consulta($sql) or die ("consulta erronea");
	
	
	echo "Pulse el enlace de su departamento para ver un listado de los libros en PDF";
	
	// mostrarmos los registros
	echo "<ul>\n";
	while ($row = $base->obtenerfila()) {
		echo "<li>";
		echo "<a href='pdf/pdf_dpto.php?num=".$row['id_departamento'];
		echo "&dep=".$row['departamento']."' target='_blank'>".$row['departamento']."</a>";
		echo "</li>\n";
	}
	echo "</ul>\n";
?>
</body>
</html>