-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 11-05-2007 a las 14:19:24
-- Versión del servidor: 5.0.27
-- Versión de PHP: 5.2.0
-- 
-- Base de datos: `geslib`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `alu_lib`
-- 

CREATE TABLE `alu_lib` (
  `id_alumno` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL,
  PRIMARY KEY  (`id_alumno`,`id_libro`)
) TYPE=InnoDB;

-- 
-- Volcar la base de datos para la tabla `alu_lib`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `alu_mat`
-- 

CREATE TABLE `alu_mat` (
  `id_alumno` int(10) unsigned NOT NULL,
  `id_materia` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id_alumno`,`id_materia`)
) TYPE=InnoDB;

-- 
-- Volcar la base de datos para la tabla `alu_mat`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `alumnos`
-- 

CREATE TABLE `alumnos` (
  `id_alumno` int(10) unsigned NOT NULL auto_increment,
  `id_curso` int(10) unsigned NOT NULL,
  `nom` varchar(30) default NULL,
  `ap1` varchar(20) default NULL,
  `ap2` varchar(20) default NULL,
  `clase` int(10) unsigned default NULL,
  `repite` tinyint(1) NOT NULL default '0',
  `sexo` enum('H','M') NOT NULL,
  `div` tinyint(1) NOT NULL default '0',
  `len` varchar(1) default NULL,
  `mat` varchar(1) default NULL,
  PRIMARY KEY  (`id_alumno`)
) TYPE=InnoDB AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `alumnos`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `cursos`
-- 

CREATE TABLE `cursos` (
  `id_curso` int(10) unsigned NOT NULL auto_increment,
  `curso` varchar(10) default NULL,
  PRIMARY KEY  (`id_curso`)
) TYPE=InnoDB AUTO_INCREMENT=7 ;

-- 
-- Volcar la base de datos para la tabla `cursos`
-- 

INSERT INTO `cursos` (`id_curso`, `curso`) VALUES 
(1, '1º ESO'),
(2, '2º ESO'),
(3, '3º ESO'),
(4, '4º ESO'),
(5, '1º Bach.'),
(6, '2º Bach.');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `departamentos`
-- 

CREATE TABLE `departamentos` (
  `id_departamento` int(10) unsigned NOT NULL auto_increment,
  `departamento` varchar(40) default NULL,
  PRIMARY KEY  (`id_departamento`)
) TYPE=InnoDB AUTO_INCREMENT=16 ;

-- 
-- Volcar la base de datos para la tabla `departamentos`
-- 

INSERT INTO `departamentos` (`id_departamento`, `departamento`) VALUES 
(1, 'Artes Plásticas y Tecnología'),
(2, 'Biología y Geología'),
(3, 'Ciencias Sociales'),
(5, 'Física y Química'),
(6, 'Educación Física y Deportiva'),
(7, 'Filosofía'),
(8, 'Lengua Castellana y Literatura'),
(9, 'Lenguas Extranjeras'),
(10, 'Matemáticas'),
(11, 'Música'),
(12, 'Procesos de Comunicación'),
(13, 'Religión'),
(14, 'Centro escolar'),
(15, 'Lenguas Clásicas');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `editoriales`
-- 

CREATE TABLE `editoriales` (
  `id_editorial` int(10) unsigned NOT NULL auto_increment,
  `editorial` varchar(20) default NULL,
  PRIMARY KEY  (`id_editorial`)
) TYPE=InnoDB AUTO_INCREMENT=14 ;

-- 
-- Volcar la base de datos para la tabla `editoriales`
-- 

INSERT INTO `editoriales` (`id_editorial`, `editorial`) VALUES 
(1, 'Anaya'),
(2, 'SM'),
(3, 'Santillana'),
(4, 'Edelvives'),
(5, 'Bruño'),
(6, 'Oxford'),
(7, 'Edebé'),
(8, 'Penguin English'),
(9, 'Almadraba'),
(10, 'Vicens-Vives'),
(11, 'Uso Interno'),
(12, 'Destino'),
(13, 'Casals SA.');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `libros`
-- 

CREATE TABLE `libros` (
  `id_libro` int(10) unsigned NOT NULL auto_increment,
  `id_editorial` int(10) unsigned NOT NULL,
  `id_materia` int(10) unsigned NOT NULL,
  `titulo` varchar(60) default NULL,
  `isbn` varchar(15) default NULL,
  `precio` decimal(10,2) default NULL,
  `gratuidad` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id_libro`)
) TYPE=InnoDB AUTO_INCREMENT=56 ;

-- 
-- Volcar la base de datos para la tabla `libros`
-- 

INSERT INTO `libros` (`id_libro`, `id_editorial`, `id_materia`, `titulo`, `isbn`, `precio`, `gratuidad`) VALUES 
(1, 11, 54, 'Agenda Escolar', ' ', 12.00, 0),
(2, 11, 55, 'Agenda Escolar', '', 12.00, 0),
(3, 11, 56, 'Agenda Escolar', '', 12.00, 0),
(4, 11, 57, 'Agenda Escolar', '', 10.00, 1),
(6, 11, 58, 'Agenda Escolar', '', 12.00, 0),
(7, 11, 59, 'Agenda Escolar', '', 12.00, 0),
(9, 11, 40, 'Lengua Castellana 4ESO. Cuaderno Uso Interno', ' ', 10.50, 1),
(10, 5, 40, 'Leyendas', '84-216-1475-4', 7.25, 1),
(11, 1, 40, 'Bodas de Sangre', '', 6.95, 1),
(12, 5, 85, 'Ética 4º ESO', '84-216-5074-2', 19.90, 1),
(13, 3, 46, 'Acction XXI 4', '84-294-9063-9', 23.70, 1),
(14, 11, 57, 'Fotocopias y Material Escolar', ' ', 20.00, 1),
(15, 11, 54, 'Fotocopias y material escolar.', ' ', 20.00, 0),
(16, 4, 40, 'Nueva Ortografía Actica II. Proyecto 2.2', '', 10.40, 1),
(17, 11, 40, 'Sinataxis General Española. (Mismo 3ºESO)', ' ', 11.00, 1),
(18, 6, 40, 'Lengua Castellana y Literatura', '84-8104-609-4', 17.95, 1),
(19, 8, 23, 'Boost your vocabulary 4. Chirs Baker', '0-582-45165-5', 11.65, 1),
(20, 6, 23, 'Select Readings. Pre-Intermediate.', '0-194377000-8', 26.25, 1),
(21, 11, 23, 'Apuntes de Inglés 4º ESO. (Uso Interno).', ' ', 11.50, 1),
(22, 11, 12, 'Matemáticas A. Apuntes de Uso Interno', ' ', 10.50, 1),
(23, 4, 67, 'Física y Química 4ºESO', '84-263-4933-1', 21.55, 1),
(24, 1, 40, 'Antología Poética. Antonio Machado.', '84-207-2660-5', 6.96, 1),
(25, 3, 46, 'Action XXI (4). Cuaderno de Ejercicios', '84-294-9064--7', 15.10, 1),
(26, 1, 66, 'Historia 4ESO', '84-667-2011-1', 29.60, 1),
(27, 2, 34, 'Religión Católica. Proyecto Betania 4ºESO.', '84-288-1787-1', 14.96, 1),
(28, 7, 86, 'Cultura Clásica 4.', '84-236-6468-6', 20.90, 1),
(29, 11, 86, 'Cultura Clásica 4. Apuntes de Uso Interno.', ' ', 9.00, 1),
(30, 11, 87, 'Procesos de Comunicación.', '', 11.00, 1),
(31, 11, 68, 'Física y Química. Cuaderno de Uso Interno.', ' ', 10.50, 1),
(32, 6, 71, 'Biología y Geología 4ESO', '84-8140-534-9', 22.50, 1),
(33, 1, 13, 'Matemáticas B. Nuestro Mundo.', '84-6671997-7', 25.90, 1),
(34, 9, 5, 'Tecnología 4ESO. EXEDRA', '84-8308-494-5', 21.30, 1),
(35, 6, 38, 'Lengua Castellana y Literatura 2ESO', '84-8104-457-1', 22.90, 1),
(36, 1, 38, 'Cuaderno de Ortografía. ', '84-667-1918-0', 7.00, 0),
(37, 12, 38, 'Requiem por un campesino español. ', '84-233-0914-2', 5.95, 0),
(38, 5, 38, 'Likundú', '84-216-3621-9', 7.25, 0),
(39, 10, 38, 'La Dama del Alba', '84-316-3721-8', 7.20, 1),
(40, 1, 38, 'Lengua 2ESO. Materiales de Uso Interno.', ' ', 11.50, 0),
(41, 1, 21, 'Oxford Exchange. Studient´s Book.', '84-8104-470-9', 24.00, 0),
(42, 8, 21, 'Boost your vocabulary 2.', '0-582-46878-9', 11.65, 0),
(43, 4, 10, 'Matemáticas 2ESO.', '84-263-4926-9', 23.45, 1),
(44, 1, 64, 'Geografía e Historia 2ESO', '84-667-1876-1', 25.60, 0),
(45, 6, 19, 'Ciencias de la Naturaleza. Exedra', '84-8104-470-9', 22.90, 1),
(46, 6, 19, 'Formulación y Nomenclatura Química Inorgánica.', '84-673-0957-1', 5.70, 0),
(47, 6, 3, 'Tecnología 2ESO. Exedra.', '84-8104-691-4', 21.70, 0),
(48, 2, 32, 'Religión Católica 2ESO. Proyecto Betania.', '84-348-8784-3', 17.60, 0),
(49, 13, 50, 'Música 2ESO.  (El mismo de 1ºESO)', '84-218-2559-3', 21.80, 1),
(50, 11, 10, 'Matemáticas 2ESO. Cuaderno de Uso Interno.', ' ', 12.00, 0),
(51, 11, 88, 'Procesos de Comunicación', ' ', 11.00, 1),
(52, 11, 55, 'Fotocopias y materiales', '', 20.00, 0),
(53, 3, 44, 'Actión XXI 2. Cuaderno de Trabajo.', '84-294-9052-3', 15.10, 0),
(54, 3, 44, 'Actión XXI 2. Libro.', '84-294-8298-9', 23.70, 0),
(55, 4, 89, 'Física y Química 4ºESO', '84-263-4933-1', 21.55, 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `materias`
-- 

CREATE TABLE `materias` (
  `id_materia` int(10) unsigned NOT NULL auto_increment,
  `id_curso` int(10) unsigned NOT NULL,
  `id_departamento` int(10) unsigned NOT NULL,
  `materia` varchar(40) default NULL,
  `tipo` int(10) unsigned default NULL,
  PRIMARY KEY  (`id_materia`)
) TYPE=InnoDB AUTO_INCREMENT=91 ;

-- 
-- Volcar la base de datos para la tabla `materias`
-- 

INSERT INTO `materias` (`id_materia`, `id_curso`, `id_departamento`, `materia`, `tipo`) VALUES 
(1, 1, 1, 'Educación Plástica y Visual 1ESO', 0),
(2, 1, 1, 'Tecnología 1ESO', 0),
(3, 2, 1, 'Tecnología 2ESO', 0),
(4, 3, 1, 'Tecnología 3', 0),
(5, 4, 1, 'Tecnología 4ESO', 1),
(6, 2, 1, 'Educación Plástica y Visual 2ESO', 0),
(7, 3, 1, 'Educación Plástica y Visual 3', 0),
(8, 4, 1, 'Educación Plástica y Visual 4ESO', 1),
(9, 1, 10, 'Matemáticas 1ESO', 0),
(10, 2, 10, 'Matemáticas 2ESO', 0),
(11, 3, 10, 'Matemáticas 3ESO', 0),
(12, 4, 10, 'MatemáticasA 4ESO', 1),
(13, 4, 10, 'MatemáticasB 4ESO', 1),
(14, 5, 10, 'Matemáticas I (1ºBach)', 1),
(15, 6, 10, 'Matemáticas II (2ºBach)', 1),
(16, 5, 10, 'Matemáticas CC. SS. I (1ºBach)', 1),
(17, 6, 10, 'Matemáticas CC. SS. II (2ºBach)', 1),
(18, 1, 2, 'Ciencias Naturales 1ESO', 0),
(19, 2, 2, 'Ciencias Naturales 2ESO', 0),
(20, 1, 9, 'Inglés 1ESO', 0),
(21, 2, 9, 'Inglés 2ESO', 0),
(22, 3, 9, 'Inglés 3ESO', 0),
(23, 4, 9, 'Inglés 4ESO', 0),
(24, 5, 9, 'Inglés (1ºBach)', 0),
(25, 6, 9, 'Inglés 2ºBach', 0),
(26, 1, 6, 'Educación Física 1ESO', 0),
(27, 2, 6, 'Educación Física 2ESO', 0),
(28, 3, 6, 'Educación Física 3ESO', 0),
(29, 4, 6, 'Educación Física 4ESO', 0),
(30, 5, 6, 'Educación Física (1ºBach)', 0),
(31, 1, 13, 'Religión 1ESO', 0),
(32, 2, 13, 'Educación Religiosa 2ESO', 1),
(33, 3, 13, 'Educación Religiosa 3ESO', 1),
(34, 4, 13, 'Religión 4ESO', 1),
(35, 5, 13, 'Religión (1ºBach)', 0),
(36, 6, 13, 'Educación Religiosa 2ºBach', 0),
(37, 1, 8, 'Lengua y Literatura 1ESO', 0),
(38, 2, 8, 'Lengua y Literatura 2ESO', 0),
(39, 3, 8, 'Lengua y Literatura 3ESO', 0),
(40, 4, 8, 'Lengua y Literatura 4ESO', 0),
(41, 3, 5, 'Física y Química 3ESO', 0),
(42, 3, 2, 'Biología y Geología 3ESO', 0),
(43, 1, 9, 'Francés 1ESO', 1),
(44, 2, 9, 'Francés 2ESO', 1),
(45, 3, 9, 'Francés 3ESO', 1),
(46, 4, 9, 'Francés 4ESO', 1),
(47, 5, 8, 'Lengua y Literatura Castellana (1º Bach)', 0),
(48, 6, 8, 'Lengua y Literatura Castellana (2º Bach)', 0),
(49, 1, 11, 'Música 1ESO', 0),
(50, 2, 11, 'Música 2ESO', 0),
(51, 3, 11, 'Música 3ESO', 0),
(52, 4, 11, 'Música 4ESO', 1),
(54, 1, 14, 'Material General (1ESO)', 0),
(55, 2, 14, ' Material General', 0),
(56, 3, 14, 'Material General ', 0),
(57, 4, 14, 'Material General', 1),
(58, 5, 14, 'Material General', 0),
(59, 6, 14, 'Material General', 0),
(60, 5, 2, 'Biología y Geología (1º Bach)', 1),
(61, 6, 2, 'Biología (2º Bach)', 1),
(62, 5, 8, 'Latín I (1º Bach)', 1),
(63, 1, 3, 'Ciencias Sociales 1ESO', 0),
(64, 2, 3, 'Ciencias Sociales 2ESO', 0),
(65, 3, 3, 'Geografía 3ESO', 0),
(66, 4, 3, 'Historia 4ESO', 0),
(67, 4, 5, 'Física y Química A 4ESO', 1),
(68, 4, 5, 'Física y Química B 4ESO', 1),
(69, 5, 5, 'Física y Química (1º Bach)', 1),
(70, 6, 5, 'Física (2º Bach)', 1),
(71, 4, 2, 'Biología y Geología 4ESO', 1),
(72, 5, 10, 'Economía (1º Bach)', 1),
(74, 6, 3, 'Historia del Arte', 1),
(75, 6, 3, 'Historia', 0),
(76, 5, 7, 'Filosofía I (1º Bach)', 0),
(77, 6, 7, 'Filosofía II', 0),
(78, 6, 10, 'Economía y Organización de Empresas', 1),
(79, 6, 15, 'Latín II', 1),
(80, 5, 1, 'Dibujo Técnico I (1º Bach)', 1),
(81, 6, 1, 'Dibujo Técnico II (2º Bach)', 1),
(82, 5, 1, 'Tecnología de la Información', 1),
(83, 5, 3, 'Historia del Mundo Contemporáneo', 1),
(84, 6, 3, 'Geografía', 1),
(85, 4, 7, 'Ética 4ESO', 0),
(86, 4, 15, 'Cultura Clásica', 1),
(87, 4, 12, 'Procesos de Comunicación 4ESO', 1),
(88, 2, 12, 'Procesos de Comunicación 2ESO', 1),
(89, 4, 5, 'Ámbito Científico-Tecnológico 4ESO', 3),
(90, 3, 5, 'Ámbito Científico-Tecnológico', 3);
