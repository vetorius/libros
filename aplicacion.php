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
 
include "inc/seguridad.inc.php";
include "inc/config.inc.php";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>::: Gestion de libros ::: principal</title>
<link rel="stylesheet" type="text/css" href="css/estilo.css" />
<link rel="shortcut icon" href="images/books.ico" />
</head>
<body>
<table border="0" width="100%" cellspacing="2">
  <tr>
    <td colspan="2" class="tablatitulo">Gesti&oacute;n de libros</td>
  </tr>
    <tr>
    <td class="mainmenu" width="120"> <?php echo print_menu(); ?></td>
	<td><iframe width="100%" height="550" frameborder="0" name="contenido"></iframe></td>
  </tr>
</table>
<?php echo print_footer($geslib_ver); ?>
</body>
</html>
