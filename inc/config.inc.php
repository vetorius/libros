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

// Variables diversas
$geslib_ver = "14.06.1";
$curso_actual = "2013-2014";
$fecha_devolucion = "26 de septiembre de 2013";

// acceso a la base de datos
$sql_host = "localhost";	// Host, nombre del servidor o IP del servidor Mysql.
$sql_user = "geslib";			// Usuario de Mysql
$sql_pass = "geslib";		// contraseï¿½a de Mysql
$sql_base = "geslib";		// Base de datos que se usarï¿½.


/**
 * Funciï¿½n que devuelve 1 si el usuario dado por su nombre
 * es administrador y cero si no lo es
 *
 * @param string $usuario
 * @return integer
 */
function es_admin($usuario){

    switch ($usuario) {
        case 'vmsanchez':
			return 1;
			break;
        case 'mcubero':
			return 1;
			break;
		default:
			return 0;
			break;
	}	
}

/**
 * devueve una cadena con el menu izquierdo
 *
 * @return string
 */
function print_menu() {

	$menu = '';	
// menu comun	
	$menu .= '<a href="intro/index.php" target="contenido">Introducir libros</a><br />';
	$menu .= '<a href="dpto.php" target="contenido">Listas por dpto</a><br />';
	$menu .= '<a href="asigna_sel.php" target="contenido">Marcar optativas</a><br />';
	$menu .= '<a href="asigna_mat.php" target="contenido">Cargar materias</a><br />';
	$menu .= '<a href="hojas_pedido.php" target="contenido">Hojas pedido</a><br />';
	$menu .= '<a href="fact_sel.php" target="contenido">Introducir pedido</a><br />';
//	$menu .= '<a href="busca_fact.php" target="contenido">Validar factura</a><br />';
//	$menu .= '<a href="lista_fact.php?val=0" target="contenido">Facturas pendientes</a><br />';
	$menu .= '<a href="revisar_fact.php" target="contenido">Revisar pedidos</a><br />';
	$menu .= '<a href="facturacion.php" target="contenido">Facturaci&oacute;n</a><br />';
	$menu .= '<a href="nuevo_alu.php" target="contenido">alumno nuevo</a><br />';
	$menu .= '<a href="busca_alu.php" target="contenido">buscar alumno</a><br />';
	$menu .= '&nbsp;<br />';
//	$menu .= '<a href="listas_lotes.php" target="contenido">listas lotes</a><br />';
	$menu .= '<a href="actualiza_fact.php" target="contenido">calcula facturas</a><br />';
	$menu .= '<a href="contar_alumnos.php" target="contenido">alumnos por materias</a><br />';
	$menu .= '&nbsp;<br />';
	$menu .= '<a href="listas_sel.php" target="contenido">Listas de libros</a><br />';
	$menu .= '<a href="verifica_isbn.php" target="contenido">test ISBN</a><br />';
	$menu .= '<a href="opciones.php" target="contenido">Definir optativas</a><br />';
	$menu .= '<a href="printlog.php" target="contenido">Ver accesos</a><br />';
//	$menu .= '<a href="printlog.php?del=1" target="contenido">Borrar log</a><br />';
//	$menu .= '<a href="noimp.php" target="contenido">Administraci&oacute;n</a><br />';
	$menu .= '&nbsp;<br />';
	$menu .= '<a href="pedidos.php" target="contenido">gestionar pedidos</a><br />';
	$menu .= '&nbsp;<br />';
	$menu .= '<a href="logout.php">cerrar sesion</a>';
	return  $menu;
}

/**
 * Devuelve una cadena con el pie de pagina
 *
 * @param string $version
 * @return string
 */
function print_footer($version) {


	$footer = '<div class="footer">Gesti&oacute;n de libros version '.$version.'<br />';
	$footer .= 'Departamento de Inform&aacute;tica y Nuevas Tecnolog&iacute;as</div>';
	
	return $footer;
}

/**
 * Devuelve una cadena con el texto completo de un curso y grupo
 * dados. Si no se le da el grupo sï¿½lo imprime el curso.
 *
 * @param integer $cur
 * @param integer $gru
 * @return string
 */
function cualcurso($cur,$gru=5) {

	$grupos = array ('A', 'B', 'C', 'nuevos', '');
    switch ($cur) {
		case 0:
			return '6º Primaria';
			break;
        case 1:
			return '1º ESO ' . $grupos[$gru-1];
			break;
		case 2:
			return '2º ESO ' . $grupos[$gru-1];
			break;
		case 3:
			return '3º ESO ' . $grupos[$gru-1];
			break;
		case 4:
			return '4º ESO ' . $grupos[$gru-1];
			break;
		case 5:
			return '1º Bachillerato ' . $grupos[$gru-1];
			break;
		case 6:
			return '2º Bachillerato ' . $grupos[$gru-1];
			break;
	}
}

function cualfecha($fecha) {

	return $fecha;

}

function chknum($ean) {
    $sum = 0;
    foreach (str_split(strrev($ean)) as $pos => $val) {
      $sum += $val * (3 - 2 * ($pos % 2));
    }
	$digit = 10 - ($sum % 10);
	if ($digit==10) $digit=0;
	return $digit;
}

?>
