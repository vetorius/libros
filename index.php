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

include "inc/config.inc.php";
?>
<html>
<head>
<meta charset="utf-8">
<title>::: Gestion de libros ::: entrada</title>
<link rel="stylesheet" type="text/css" href="css/estilo.css" />
<link rel="shortcut icon" href="images/books.ico" />
</head>
<body onload="javascript:document.getElementById('user').focus();">
<div align="center">
<table border="0" width="100%">
  <tr>
    <td class="tablatitulo">Gesti&oacute;n de libros</td>
  </tr>
</table>
<form action="login.test.php" method="post">
<table width="300" cellspacing="2" cellpadding="2" border="0">
<tr>

<?php
if ($_GET["errorusuario"]==1){
?>
	<td colspan="2" align="center" bgcolor="red"><span style="color:ffffff"><b>Falta alg&uacute;n dato.</b></span></td>
<?php } elseif ($_GET["errorusuario"]==2){
?>
	<td colspan="2" align="center" bgcolor="red"><span style="color:ffffff"><b>Datos incorrectos.</b></span></td>
<?php } else {?>
	<td colspan="2" align="center" bgcolor="#cccccc">Acceso al sistema con el<br/>usuario y la clave de Windows.</td>
<?php }?>

</tr>
<tr>
<td align="right">Usuario:</td>
<td><input id="user" type="text" name="usuario" size="12" maxlength="50" /></td>
</tr>
<tr>
<td align="right">Contrase&ntilde;a:</td>
<td><input type="password" name="contrasena" size="12" maxlength="50" /></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" value="ENTRAR" /></td>
</tr>
</table>
</form>
</div>
<?php echo print_footer($geslib_ver); ?>
</body>
</html> 
