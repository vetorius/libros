<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo login.test.php
 *
 * validacion automatica para desarrollo sin servidor LDAP
 *
 */
 
if (isset($_POST["usuario"])) {
 	$user = $_POST["usuario"];
}
session_start();
$_SESSION["validado"] = "SI";
$_SESSION["usuario"] = $user;

// entrada en el log

$contenido = date('d M Y - H:i:s') . ' - ' . $user . " - correcto\n";

if (!$log_file = fopen('access.log','a')) {
	echo "No se puede abrir el archivo access.log";
	exit;
}
if (fwrite($log_file, $contenido) === FALSE) {
	echo "No se puede escribir al archivo access.log";
	exit;
}
fclose($log_file);

// redirección a la pagina principal de la aplicacion

header ("Location: aplicacion.php");
?>
