<?

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo logout.php
 *
 * salida de la aplicacion
 *
 */
 
session_start();
session_destroy();
include "inc/config.inc.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>::: Gestion de libros ::: desconexi&oacute;n correcta</title>
<link rel="stylesheet" type="text/css" href="css/estilo.css" />
<link rel="shortcut icon" href="images/books.ico" />
</head>
<body>
<table border="0" width="100%">
  <tr>
    <td class="tablatitulo">Gesti&oacute;n de libros</td>
  </tr>
  <tr>
    <td class="logout">Gracias por tu acceso<br /><br />
	<a href="index.php">Volver a entrar.</a></td>
  </tr>
</table>
<?php echo print_footer($geslib_ver); ?>
</body>
</html>