<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo facturacion.php
 *
 * acceso a la facturación por cursos
 *
 */

include "inc/seguridad.inc.php";
include "inc/config.inc.php";

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Facturaci&oacute;n</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>
<body>
	<form action="lista_fact3.php" method="GET" target="_blank">
	<table width="300" cellspacing="2" cellpadding="2" border="0">
	<tr>
	<td colspan="2" align="center" bgcolor=#cccccc>
	Elegir curso
	</td>
	</tr>
	<tr>
	<td align="right">curso:</td>
	<td><select name="cur" id="cur">
	  <option value="0" selected>1&ordm; ESO</option>
	  <option value="1">2&ordm; ESO</option>
	  <option value="2">3&ordm; ESO</option>
	  <option value="3">4&ordm; ESO</option>
	  <option value="4">1&ordm; Bachillerato</option>
	  <option value="5">2&ordm; Bachillerato</option>
	</select></td>
	</tr>
	<tr>
	<td colspan="2" align="center"><input type="Submit" value="Mostrar facturación"></td>
	</tr>
	</table>
	</form>

</body>
</html>

