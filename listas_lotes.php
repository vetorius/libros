<?php 

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo listas_lotes.php
 *
 * seleccion del grupo para generar 
 *
 * hojas para elaborar lotes
 *
 */

include "inc/seguridad.inc.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>hojas de pedido por clase</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="css/estilo.css">
</head>
<body>
<form name="form1" action="pdf/pdf_grupograt.php" target="_blank" method="GET">
<table width="300" cellspacing="2" cellpadding="2" border="0">
<tr>
<td colspan="2" align="center" bgcolor=#cccccc>
Elegir curso y grupo para generar las listas de libros de gratuidad:
</td>
</tr>
<tr>
<td align="right">curso:</td>
<td><select name="cur" id="cur">
  <option value="0" selected>1&ordm; ESO</option>
  <option value="1">2&ordm; ESO</option>
  <option value="2">3&ordm; ESO</option>
  <option value="3">4&ordm; ESO</option>
</select></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="Submit" value="generar PDF"></td>
</tr>
</table>
</form>
<form name="form2" action="" target="_blank" method="GET">
<table width="300" cellspacing="2" cellpadding="2" border="0">
<tr>
<td colspan="2" align="center" bgcolor=#cccccc>
Elegir curso y grupo para generar las listas de libros comprados:
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
<td align="right">grupo de destino:</td>
<td><select name="gru" id="gru">
  <option value="1" selected>A</option>
  <option value="2">B</option>
  <option value="3">C</option>

</select></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="Submit" value="generar PDF"></td>
</tr>
</table>
</form>
</body>
</html>
