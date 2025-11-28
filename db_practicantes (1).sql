-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3308
-- Tiempo de generación: 21-07-2025 a las 06:49:09
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_practicantes`
--

--
-- Volcado de datos para la tabla `facultades`
--

INSERT INTO `facultades` (`id`, `name`, `created_at`, `updated_at`, `state`) VALUES
(1, 'Bromatología y Nutrición', NULL, NULL, 1),
(2, 'Ciencias', NULL, NULL, 1),
(3, 'Ciencias Económicas, Contables y Financieras', NULL, NULL, 1),
(4, 'Ciencias Empresariales', NULL, NULL, 1),
(5, 'Ciencias Sociales', NULL, NULL, 1),
(6, 'Educación', NULL, NULL, 1),
(7, 'Ingeniería Agraria, Industrias Alimentarias y Ambiental', NULL, NULL, 1),
(8, 'Ingeniería Industrial, Sistemas e Informática', NULL, NULL, 1),
(9, 'Ingeniería Pesquera', NULL, NULL, 1),
(10, 'Ingeniería Química y Metalúrgica', NULL, NULL, 1),
(11, 'Medicina Humana', NULL, NULL, 1),
(12, 'Derecho y Ciencias Políticas', NULL, NULL, 1);

--
-- Volcado de datos para la tabla `escuelas`
--

INSERT INTO `escuelas` (`id`, `name`, `facultad_id`, `created_at`, `updated_at`, `state`) VALUES
(1, 'Bromatología y Nutrición', 1, NULL, NULL, 1),
(2, 'Biología', 2, NULL, NULL, 1),
(3, 'Física', 2, NULL, NULL, 1),
(4, 'Matemáticas', 2, NULL, NULL, 1),
(5, 'Economía y Finanzas', 3, NULL, NULL, 1),
(6, 'Contabilidad y Finanzas', 3, NULL, NULL, 1),
(7, 'Administración y Gestión', 4, NULL, NULL, 1),
(8, 'Marketing', 4, NULL, NULL, 1),
(9, 'Trabajo Social', 5, NULL, NULL, 1),
(10, 'Ciencias de la Comunicación', 5, NULL, NULL, 1),
(11, 'Turismo', 5, NULL, NULL, 1),
(12, 'Educación Básica', 6, NULL, NULL, 1),
(13, 'Educación Tecnológica', 6, NULL, NULL, 1),
(14, 'Ingeniería Agronómica', 7, NULL, NULL, 1),
(15, 'Industrias Alimentarias', 7, NULL, NULL, 1),
(16, 'Ingeniería Ambiental', 7, NULL, NULL, 1),
(17, 'Ingeniería Industrial', 8, NULL, NULL, 1),
(18, 'Ingeniería de Sistemas', 8, NULL, NULL, 1),
(19, 'Ingeniería Informática', 8, NULL, NULL, 1),
(20, 'Ingeniería Electrónica', 8, NULL, NULL, 1),
(21, 'Ingeniería Pesquera', 9, NULL, NULL, 1),
(22, 'Ingeniería Acuícola', 9, NULL, NULL, 1),
(23, 'Ingeniería Química', 10, NULL, NULL, 1),
(24, 'Ingeniería Metalúrgica', 10, NULL, NULL, 1),
(25, 'Medicina Humana', 11, NULL, NULL, 1),
(26, 'Enfermería', 11, NULL, NULL, 1),
(27, 'Derecho', 12, NULL, NULL, 1),
(28, 'Ciencias Políticas', 12, NULL, NULL, 1);

--
-- Volcado de datos para la tabla `semestres`
--

INSERT INTO `semestres` (`id`, `codigo`, `ciclo`, `created_at`, `updated_at`, `state`) VALUES
(1, '2025-1', 'Decimo Ciclo', '2025-07-08 06:21:18', NULL, 1);

--
-- Volcado de datos para la tabla `secciones`
--

INSERT INTO `seccion_academica` (`id`, `id_semestre`, `id_facultad`, `id_escuela`, `seccion`, `created_at`, `updated_at`, `state`) VALUES
(1, 1, 1, 1, 'A', NULL, NULL, 1);

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id`, `name`, `descripcion`, `created_at`, `updated_at`, `state`) VALUES
(1, 'Módulo I', NULL, '2025-07-08 06:21:18', NULL, 1),
(2, 'Módulo II', NULL, '2025-07-08 06:21:18', NULL, 1),
(3, 'Módulo III', NULL, '2025-07-08 06:21:18', NULL, 1),
(4, 'Módulo IV', NULL, '2025-07-08 06:21:18', NULL, 1);

--
-- Volcado de datos para la tabla `type_users`
--

INSERT INTO `type_users` (`id`, `name`, `created_at`, `updated_at`, `state`) VALUES
(1, 'Admin', '2025-07-08 03:11:09', '2025-07-07 22:11:09', 1),
(2, 'Sub Admin', '2025-07-08 03:11:09', '2025-07-07 22:11:09', 1),
(3, 'Docente Titular', '2025-07-08 03:11:09', '2025-07-07 22:11:09', 1),
(4, 'Docente Supervisor', '2025-07-08 03:11:09', '2025-07-07 22:11:09', 1),
(5, 'Estudiante', '2025-07-08 03:11:09', '2025-07-07 22:11:09', 1);

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `password_changed_at`, `remember_token`, `created_at`, `updated_at`, `state`) VALUES
(1, 'david', 'admin@gmail.com', NULL, '$2y$10$/90LDShchmPZ9htY4.ibkuatXRLKaeLifhECPrF.Jx.moBxqQW7j6', NULL, NULL, NULL, NULL, 1);

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `codigo`, `dni`, `nombres`, `apellidos`, `celular`, `sexo`, `ruta_foto`, `correo_inst`, `departamento`, `provincia`, `distrito`, `usuario_id`, `state`) VALUES
(1, 'ADMIN00001', NULL, 'David', 'Admin', NULL, NULL, 'storage/fotos/foto_1_1751942611.png', 'admin@gmail.com', 'Lima Provincias', NULL, NULL, 1, 1);

--
-- Volcado de datos para la tabla `asignacion_persona`
--

INSERT INTO `asignacion_persona` (`id`, `id_persona`, `id_rol`, `id_semestre`, `id_facultad`, `id_sa`, `created_at`, `updated_at`, `state`) VALUES
(1, 1, 1, 1, NULL, NULL, '2025-07-08 06:21:18', NULL, 1);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
