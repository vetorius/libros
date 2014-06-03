<?php

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2007 Victor Manuel Sanchez
 *
 * archivo isbn.inc.php
 *
 * funcion de chequeo de los ISBN

 */

function checkisbn($isbn) {
	$resultado = "";
	$isbn10 = ereg_replace("[^0-9X]","",strtoupper($isbn)); // separamos los numeros del ISBN
	if (strlen($isbn10)==10) { // si tiene 10 digitos es el formato clasico
		//calculamos el digito de control
		$checkdigit = ( 1 * substr($isbn10,0,1) + 2 * substr($isbn10,1,1) + 3 * substr($isbn10,2,1) + 4 * substr($isbn10,3,1) + 5 * substr($isbn10,4,1) + 6 * substr($isbn10,5,1) + 7 * substr($isbn10,6,1) + 8 * substr($isbn10,7,1) + 9 * substr($isbn10,8,1) ) % 11;
		if ( $checkdigit==10 ) {		
			$checkdigit = "X";
		}
        if ( $checkdigit == substr($isbn10,9,1) ) {
			$resultado = "<span style='color: #00ff00'>OK</span> - " .$isbn10 .' - '. $checkdigit;
		} else {
			$resultado = "<span style='color: #ff0000'>check digit error</span> - " .$isbn10 .' - '. $checkdigit;
                }
	} else if (strlen($isbn10)==13) { // si tiene 13 digitos es el formato EAN
		//calculamos el digito de control
		$pares = substr($isbn10,1,1) + substr($isbn10,3,1) + substr($isbn10,5,1) + substr($isbn10,7,1) + substr($isbn10,9,1) + substr($isbn10,11,1);
		$impares = substr($isbn10,0,1) + substr($isbn10,2,1) + substr($isbn10,4,1) + substr($isbn10,6,1) + substr($isbn10,8,1) + substr($isbn10,10,1);
		$total = ($pares * 3) + $impares;
		$checkdigit = 10 - ($total % 10);
		if ( $checkdigit==10 ) {		
			$checkdigit = "0";
		}
        if ( $checkdigit == substr($isbn10,12,1) ) {
			$resultado = "<span style='color: #00ff00'>OK</span> - " .$isbn10 .' - '. $checkdigit;
		} else {
			$resultado = "<span style='color: #ff0000'>check digit error</span> - " .$isbn10 .' - '. $checkdigit;
                }
	} else { // si no tiene ni 10 ni 13 digitos la longitud es incorrecta 
		$resultado = "<span style='color: #0000ff'>ISBN longitud incorrecta</span> - " .$isbn10;
    }
	return $resultado;
}
?>