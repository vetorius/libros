<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2007 Victor Manuel Sanchez
 *
 * archivo ldap.class.php
 *
 * clase para la conexion con un servidor LDAP
 *
 */

class AccesoLdap {
    
    private $dn = "OU=users,DN=lasalle,DN=local";
    private $ad;

	function __construct() {
		
		$this->ad = ldap_connect("ldap://192.168.0.4")
        	or die("Error: no se pudo conectar con el controlador de dominio.");

    	ldap_set_option($this->ad, LDAP_OPT_PROTOCOL_VERSION, 3);
        
	}

	function __destruct() {

	    ldap_close($this->ad);
	}    

	function validar ($user, $pass) {
        
		$bd = @ldap_bind($this->ad, $user."@lasalle.local", $pass);
//			or die("Error: sus credenciales no son correctas.");
		return $bd;
	}

}
?>
