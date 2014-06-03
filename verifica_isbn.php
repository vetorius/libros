<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo verifica_isbn.php
 *
 * lista de validacion del ISBN te todos los libros
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
	include "inc/isbn.inc.php";
	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ("conexion erronea");
	$sql = "SELECT id_libro, titulo, isbn FROM libros WHERE id_editorial<>11";
	$base->consulta($sql) or die ("consulta erronea");
	
		echo "Listado de verificacion de ISBN";
	
	// mostrarmos los registros
	echo "<ul>\n";
	while ($row = $base->obtenerfila()) {
		echo "<li>";
		echo $row['id_libro'] . ' - ';
		echo $row['titulo'] . ' - ' . $row['isbn'] . ' - ' . checkisbn($row['isbn']);
//		echo $row['titulo'] . ' - ' . print_r(ISBN::validate($row['isbn']));
		echo "</tr>\n";
	}
	echo "</ul>\n";
?>
</body>
</html>