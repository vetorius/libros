<?php 

/*
 * Gestion de libros v 0.1
 *
 * Copyright (c) 2005 Victor Manuel Sanchez
 *
 * archivo textos.inc.php
 *
 * variables con los textos a incluir en algunos PDF
 *
 */

// texto de titulo para la hoja de pedido
$titulo_pedido_eso = "Ficha de solicitud de libros y materiales para el curso " . $curso_actual;
$titulo_pedido_bach = "Ficha de solicitud de libros y materiales para el curso " . $curso_actual;

// texto de instrucciones para la hoja de pedido
$instr_pedido = "Se�ala con una cruz los libros y materiales que quieres comprar en el Colegio para el curso pr�ximo.\nRecuerda que:\n   - Los materiales sombreados, solo puedes adquirirlos en el Colegio.\n   - El apartado \"Material complementario\" incluye el carnet escolar, el uso de sallenet, fotocopias y material de laboratorios y otras salas.\n   - Este formulario hay que entregarlo en secretar�a hasta el d�a 24 de junio.\n   - El importe total se pasar� por banco una vez entregados los libros en septiembre y podr� pagarse en dos plazos (septiembre y noviembre).\n   - Estos precios son v�lidos salvo error tipogr�fico.\n\nEste pedido est� condicionado a la promoci�n del alumno al curso siguiente.";

// texto de titulo para la factura
$titulo_factura = "Factura de libros y materiales para el curso ".$curso_actual;

// texto de instrucciones para la factura

$instr_factura = "OBSERVACIONES\n- El coste de los libros se pasar� por banco en uno o dos plazos los d�as 18-9-2013 y 18-11-2013.\n- Para efectuar el pago en dos plazos, cada uno por la mitad del importe, debe entregarse al tutor el resguardo inferior debidamente firmado el d�a 17 de septiembre, si se entrega m�s tarde se pasar� un �nico recibo el 18-9-2013.\n";
$instr_factura .= "- No se admitir�n devoluciones despu�s del " . $fecha_devolucion . ".\n";
$instr_factura .= "- Cualquier libro que tenga un defecto de fabricaci�n se repondr� en Administraci�n, en cualquier momento del curso. \n- Estos precios son v�lidos salvo error tipogr�fico.";

// texto de conformidad con el pedido de libros

$conf_factura = "_____________________________________________ , como padre, madre o tutor de este alumno, he recibido los materiales que figuran en la factura y acepto pagar el cargo que en ella se indica en (__) uno / (__) dos plazos.\n Indicar con una X la forma de pago elegida.";


// textos para la lista de los lotes de gratuidad

$titulo_lote_grat = "Relaci�n de libros incluidos en el programa de gratuidad";

$instr_lote_grat = "Estos libros son propiedad del Colegio La Salle Franciscanas Gran V�a. Se prestan al alumno para su uso durante el curso con el compromiso de devolverlos en un estado adecuado, que permita su utilizaci�n durante el tiempo que marca el programa de gratuidad del la DGA. Son libros en los que no se puede escribir ni subrayar. La devoluci�n se efectuar� en la fecha prevista en el calendario escolar. En caso de que al finalizar el curso se detecte alguna incidencia, se le notificar� por escrito para que lo pueda reponer o pagar en Administraci�n.";

$conf_lote_grat = "Se me entrega en pr�stamos el lote de libros incluido en el programa de gratuidad indic�ndome las condiciones de uso y de devoluci�n.";

?>
