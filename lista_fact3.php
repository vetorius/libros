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
	if (isset($_GET['cur'])) {
		$curso = $_GET['cur'];
	} else {
		$curso = 0;
	}
	
	$laclase = array(	1 => 'A',
						2 => 'B',
						3 => 'C');
	
	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ('conexion erronea');

// obtiene el total de facturación

	$sql  = "SELECT sum(total) ";
	$sql .= "FROM facturas INNER JOIN alumnos USING (id_alumno) ";
	$sql .= "WHERE ((id_curso=$curso and repite=0) or (id_curso=$curso+1 and repite=1))";
	$base->consulta($sql) or die ("consulta total facturacion erronea");
	$facturacion = $base->obtenerfila();

// consulta para obtener las facturas

	$sql  = "SELECT f.id_factura, f.id_alumno, f.f_emision, f.acepta, f.total, ";
	$sql .= "a.nom, a.ap1, a.ap2, a.id_curso, a.clase_n ";
	$sql .= "FROM facturas f INNER JOIN alumnos a USING (id_alumno) ";
	$sql .= "WHERE ((a.id_curso=$curso and a.repite=0) or (a.id_curso=$curso+1 and a.repite=1)) ";
	$sql .= "ORDER BY a.clase_n, a.ap1, a.ap2";
	$base->consulta($sql) or die ("consulta facturas lista_fact erronea"); 
	echo '<table cellspacing="2" cellpadding="2" border="1">';
	if ($base->numregistros()>0) {
		echo '<tr><td colspan=6 align="center" bgcolor=#cccccc>Listado de facturas</td></tr>';
		echo '<tr><td>id</td><td>clase</td><td>nombre</td><td>Total</td><td>P 1</td><td>P 2</td></tr>';
		while ($datos = $base->obtenerfila()) {
			$todo = $datos['total'];
			$pl1 = round($datos['total']/2,2);
			$pl2 = $datos['total'] - $pl1;
			$nombre = $datos['ap1']." ".$datos['ap2'].", ".$datos['nom'];
			echo '<tr><td width="40">' . sprintf("%04d",$datos[0]) .'</td>';
			echo '<td align="center">'. $laclase[$datos['clase_n']] .'</td>';
			echo '<td width="300">'. $nombre .'</td>';
			echo '<td width="80" align="right">'. sprintf('%01.2f',$todo) .' €</td>';
			echo '<td width="80" align="right">'. sprintf('%01.2f',$pl1) .' €</td>';
			echo '<td width="80" align="right">'. sprintf('%01.2f',$pl2) .' €</td></tr>';
		}
/* 		TOTAL FACTURADO */
		echo '<tr><td colspan=6 align="right" bgcolor=#cccccc>';
		echo 'Total facturado: '.$facturacion[0].'</td></tr>';

		echo '</table>';
	} else {
		echo '<tr><td align="center" bgcolor=#cccccc>No hay facturas</td></tr></table>';
	}

?>

</body>
</html>

