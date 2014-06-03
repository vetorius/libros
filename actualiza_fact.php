<?php 

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo actualiza_fact.php
 *
 * actualiza el total de la factura en la base de datos
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
$facturas = new DBmy();
$facturas->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ('conexion facturas erronea');

$base = new DBmy();
$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ('conexion base erronea');

// seleccionamos todas las facturas
	$sql = "SELECT id_factura FROM facturas";
	$facturas->consulta($sql) or die ("seleccion de factura erronea");

	while ($id_fact = $facturas->obtenerfila()) {

		$id_factura = $id_fact[0];
		
		$sql = "SELECT sum(libros.precio) FROM libros INNER JOIN fact_lib USING (id_libro) ";
		$sql .= "WHERE fact_lib.id_factura=" . $id_factura;
		$base->consulta($sql) or die ("error calculando el total");
		if ($base->numregistros() > 0) {
			$datos=$base->obtenerfila();
			$sql = "UPDATE facturas SET total=".$datos[0];
			$sql .= " WHERE id_factura=" . $id_factura;
			$base->consulta($sql) or die ("error al actualizar total");	
		}
	}
?>
<h3>Facturas actualizadas correctamente.</h3>
</body>
</html>
