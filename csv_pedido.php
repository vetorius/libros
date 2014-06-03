<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo pdf_pedido.php
 *
 * Genera un PDF con el pedido de libros por proveedor
 *
 */

include "inc/seguridad.inc.php";

require_once ("inc/mysql.class.php");
include "inc/config.inc.php";

if (isset($_GET['pedido'])) {
	
	$pedido=$_GET['pedido'];
	
	// conexiones con la base de datos
	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ("conexion libros erronea");

	$sql  = "SELECT ed.id_proveedor, ed.editorial, li.isbn, li.titulo, count(*) ";
	$sql .= "FROM facturas fa INNER JOIN fact_lib using(id_factura) ";
	$sql .= "INNER JOIN libros li using(id_libro) ";
	$sql .= "INNER JOIN editoriales ed using(id_editorial) INNER JOIN materias ma using(id_materia) ";
	$sql .= "WHERE fa.id_pedido=" . $pedido;
	$sql .= " GROUP BY id_libro ORDER BY ed.id_proveedor, ed.editorial, li.isbn, id_materia";
		
	$base->consulta($sql) or die("consulta erronea");
		
	if ($base->numregistros()>0) {
	    // generamos el archivo csv
	    header("Cache-Control: public");
	    
	    header('Content-Type: text/csv; charset=utf-8');
	    // definimos el tipo MIME y la codificación
	    
	    header('Content-Disposition: attachment; filename=pedido_' . $pedido . '.csv');
	    // Forzamos que el archivo se descargue con un nombre definido
	    echo "proveedor;editorial;isbn;titulo;numero\n";
		while ($fila = $base->obtenerfila()) {
		    echo $fila[0].";".$fila[1].";".$fila[2].";".$fila[3].";".$fila[4]."\n";
		}
	}
}
?>
