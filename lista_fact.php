<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo lista_fact.php
 *
 * lista con las facturas emitidas
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
	if (isset($_GET['val']))
	{
		$val = $_GET['val'];
		$textval = '?val=' . $val; 
	} else {
		$val = 0;
		$textval = '';
	}

	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ('conexion erronea');

// obtiene el total de facturación

	$sql  = "SELECT sum(total) ";
	$sql .= "FROM facturas ";
//	$sql .= "WHERE acepta<>0";
	$base->consulta($sql) or die ("consulta total facturacion erronea");
	$facturacion = $base->obtenerfila();

// consulta para obtener las facturas

	$sql  = "SELECT f.id_factura, f.id_alumno, f.f_emision, f.acepta, f.total, ";
	$sql .= "a.nom, a.ap1, a.ap2, a.id_curso ";
	$sql .= "FROM facturas f INNER JOIN alumnos a USING (id_alumno) ";
	$sql .= "WHERE f.acepta=$val ";
	$sql .= "ORDER BY f.id_factura";
	$base->consulta($sql) or die ("consulta facturas lista_fact erronea"); 
	echo '<table width="600" cellspacing="2" cellpadding="2" border="0">';
	if ($base->numregistros()>0) {
		echo '<tr><td colspan=4 align="center" bgcolor=#cccccc>Listado de facturas</td></tr>';
		while ($datos = $base->obtenerfila()) {
			$nombre = $datos['ap1']." ".$datos['ap2'].", ".$datos['nom']." (".$datos['id_curso'].") ";
			echo '<tr><td width="350">' . sprintf("%04d",$datos[0]) .' - ';
			echo $nombre . ' - ' . $datos[4] . ' €';
			if ($datos[3]) {echo ' - Aceptada';}
			echo '</td>';
			echo '<td><a href="valida_fact.php?id_alumno='.$datos[1];
			echo '&id_factura='.$datos[0].'&lista='.$val.'">validar</a></td>';
			echo '<td><a href="pdf/pdf_fact.php?id_alumno='.$datos[1];
			echo '&id_factura='.$datos[0].'" target="_blank">imprimir</a></td>';
			echo '<td><a href="fact_sel.php?id_alumno='.$datos[1];
			echo '">ir a alumno</a></td></tr>';
		}
/* 		TOTAL FACTURADO */
		echo '<tr><td colspan=4 align="right" bgcolor=#cccccc>';
		echo 'Total facturado: '.$facturacion[0].'</td></tr>';

		echo '</table>';
	} else {
		echo '<tr><td align="center" bgcolor=#cccccc>No hay facturas</td></tr></table>';
	}

?>

</body>
</html>

