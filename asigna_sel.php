<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo asigna_sel.php
 *
 * Selector de grupo para acceder a asignación.php
 *
 */
 
include "inc/seguridad.inc.php";
include "inc/config.inc.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>hojas de pedido por clase</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>
<body>
<form action="asignacion.php" target="_blank" method="GET">
<table width="300" cellspacing="2" cellpadding="2" border="0">
<tr>
<td colspan="2" align="center" bgcolor=#cccccc>
Elegir curso y grupo
</td>
</tr>
<tr>
<td align="right">curso:</td>
<td><select name="cur" id="cur">
  <option value="0" selected>6&ordm; Primaria</option>
  <option value="1">1&ordm; ESO</option>
  <option value="2">2&ordm; ESO</option>
  <option value="3">3&ordm; ESO</option>
  <option value="4">4&ordm; ESO</option>
  <option value="5">1&ordm; Bachillerato</option>
</select></td>
</tr>
<tr>
<td align="right">grupo:</td>
<td><select name="gru" id="gru">
  <option value="1" selected>A</option>
  <option value="2">B</option>
  <option value="3">C</option>
  <option value="4">nuevos</option>
</select></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="Submit" value="asignar optativas"></td>
</tr>
</table>
</form>


</body>
</html>

