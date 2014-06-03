<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo login.ldap.php
 *
 * verifica al usuario contra un
 *
 * servidor LDAP
 *
 */
 
require_once("inc/ldap.class.php");
setlocale(LC_ALL,"es_ES.UTF-8");
	//Comprobamos que se accede desde index.php
if (isset($_POST["usuario"]) and isset($_POST["contrasena"])){
	//Capturamos las variables del formulario
	$user = $_POST["usuario"];
    $pass = $_POST["contrasena"];

	$autenticacion = new AccesoLdap();
	
    //comprueba que no estan vacios los campos
	if (($user =="") or ($pass =="")) {
	
	    header("Location: index.php?errorusuario=1");
	} else {
		//vemos si el usuario y contraseña es válido
		$resultado = $autenticacion->validar($user, $pass);
		// abrir fichero de entrada en el log
		if (!$log_file = fopen('access.log','a')) {
			echo "No se puede abrir el archivo access.log";
			exit;
		}


// redirección a la pagina principal de la aplicacion

		if ($resultado){
		    //usuario y contraseña válidos
		    //defino una sesion y guardo datos
		    session_start();
		    $_SESSION["validado"] = "SI";
		    $_SESSION["usuario"] = $user;
			$contenido = date('d M Y - H:i:s') . ' - ' . $_SERVER['REMOTE_ADDR'] . ' - ' . $user . " - correcto\n";
			//escribo la entrada del log
			if (fwrite($log_file, $contenido) === FALSE) {
				echo "No se puede escribir al archivo access.log";
				exit;
			}
			fclose($log_file);
			// vamos a la pagina principal de la aplicacion			
		    header ("Location: aplicacion.php");
		}else {
		    //si no existe lo escribo en el log y vuelvo otra vez a la portada
			 $contenido = date('d M Y - H:i:s') . ' - ' . $_SERVER['REMOTE_ADDR'] . ' - ' . $user . " - ERROR\n";
			if (fwrite($log_file, $contenido) === FALSE) {
				echo "No se puede escribir al archivo access.log";
				exit;
			}
			fclose($log_file);			
		    header("Location: index.php?errorusuario=2");
		}
	}
} else {
	header("Location: index.php");
}
?> 
