<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo borra_pedido.php
 *
 * borra un pedido y mueve sus facturas a pendientes de pedir
 *
 */

include "inc/seguridad.inc.php";
include "inc/config.inc.php";

if (!isset($_GET['pedido'])) {

	echo 'Pedido no definido';	

} else {

	require_once ("inc/mysql.class.php");

	$id_pedido = $_GET['pedido'];
	$tr_error=0;
	$base = new DBmy();
	$base->conectar($sql_base, $sql_host, $sql_user, $sql_pass) or die ('conexion erronea');
//iniciamos una transaccion	
	$base->tr_begin();
// borramos el registro del pedido
	$sql = "DELETE FROM pedidos ";
	$sql .= "WHERE id_pedido=" . $id_pedido;
	$test = $base->consulta($sql);
	if(!$test)
	$tr_error=1;
// actualizamos a 0 el id_pedido de la factura

	$sql = "UPDATE facturas SET id_pedido=0 ";		
	$sql .= "WHERE id_pedido=".$id_pedido;
	$test = $base->consulta($sql);
	if(!$test)
	$tr_error=1;
	
	if ($error) {
		$base->tr_rollback(); // transaccion fallida
		echo "<h3>Fallo en la transaccion</h3>";
	} else {
		$base->tr_commit(); // transaccion exitosa
		echo "<h3>Pedido borrado</h3>";
	}
	
	echo "<a href='pedidos.php' target='_self'>continuar<a/>";
}
?>