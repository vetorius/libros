<?php
/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo seguridad.inc.php
 *
 * codigo inicial en paginas accesibles tras autentificacion
 *
 */

//Inicio la sesion
session_start();

//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO
if ($_SESSION["validado"] != "SI") {
    //si no existe, envio a la página de autentificacion
    header("Location: /libros/index.php");
    //ademas finalizo el script
    exit();
}
?>
