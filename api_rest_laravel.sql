-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-08-2022 a las 17:06:30
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `api_rest_laravel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Mi día', '2022-07-18 13:31:01', '2022-07-17 13:31:02'),
(2, 'categoria', '2022-07-26 18:06:53', '2022-07-26 18:13:49'),
(3, 'asdad', '2022-08-01 17:36:59', '2022-08-01 17:36:59'),
(4, 'Nueva categoria', '2022-08-01 17:37:32', '2022-08-01 17:37:32'),
(5, 'asdsa', '2022-08-01 17:37:57', '2022-08-01 17:37:57'),
(6, 'asd', '2022-08-01 17:42:48', '2022-08-01 17:42:48'),
(7, 'cat', '2022-08-01 20:14:48', '2022-08-01 20:14:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `category_id` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `category_id`, `title`, `content`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Temprano', 'Mi día', NULL, '2022-07-18 13:32:04', '2022-07-18 13:32:05'),
(2, 1, 1, 'Temprano', 'Mi día', NULL, '2022-07-18 13:32:04', '2022-07-18 13:32:05'),
(4, 8, 1, 'Titulo', '<p>Txt a<u>sdsad</u></p><p><strong>asdsadsd</strong></p>', '1659384720S (1).png', '2022-08-01 20:12:02', '2022-08-01 20:12:02'),
(5, 8, 4, 'Titulo 1', '<p><strong>Contendio</strong></p><p><em>en </em></p><p><u>texto</u></p>', '1659384860S (1).png', '2022-08-01 20:14:22', '2022-08-01 20:14:22'),
(6, 8, 1, 'T2', '<p>text</p>', '1659395098amongusProbosquin404NoFound.gif', '2022-08-01 23:05:01', '2022-08-01 23:05:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `role`, `email`, `password`, `descripcion`, `image`, `created_at`, `updated_at`, `remember_token`) VALUES
(1, 'Cesar', 'Kass', '1', 'cesar.acu@homail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'yo', '1659378158S (1).png', '2022-07-18 13:31:38', '2022-07-18 13:31:39', NULL),
(3, 'Cesar', 'Kass', '2', 'kass@hotmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '<p><u>text 1</u></p>', '1659378158S (1).png', '2022-07-25 22:32:57', '2022-08-01 18:22:40', NULL),
(4, 'Cesar', 'Kass', '2', 'cesar.acu@hotsmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'xx', NULL, '2022-07-28 14:45:54', '2022-07-28 14:45:54', NULL),
(5, 'asd', 'asd', '2', 'alexisriveralara300694@hotmail.com', 'd17f25ecfbcc7857f7bebea469308be0b2580943e96d13a3ad98a13675c4bfc2', 'xx', NULL, '2022-07-28 14:46:45', '2022-07-28 14:46:45', NULL),
(6, 'CesarDos', 'KassDos', '2', 'ce2sar.acu@hotmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'xx', NULL, '2022-07-28 14:56:14', '2022-07-28 14:56:14', NULL),
(7, 'asd', 'qewq', '2', 'alexisrivera2lara300694@hotmail.com', 'ee79976c9380d5e337fc1c095ece8c8f22f91f306ceeb161fa51fecede2c4ba1', 'xx', NULL, '2022-07-28 14:56:49', '2022-07-28 14:56:49', NULL),
(8, 'Nombre', 'Apellido', '2', 'eje@dom.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '<p><em><u>tet</u></em></p>', '1659382079S (1).png', '2022-08-01 19:23:33', '2022-08-01 19:28:03', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pk_posts_user` (`user_id`),
  ADD KEY `pk_categories` (`category_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `pk_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `pk_posts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
