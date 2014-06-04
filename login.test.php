<?php

/*
 * Gestion de libros
 *
 * Copyright (c) 2014 Victor manuel Sanchez
 *
   This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>
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
