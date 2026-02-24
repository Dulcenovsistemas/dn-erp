-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-02-2026 a las 20:42:10
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
-- Base de datos: `pastel_admin`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1771015778),
('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1771015778;', 1771015778),
('laravel-cache-admin@admin.com|127.0.0.1', 'i:1;', 1771621384),
('laravel-cache-admin@admin.com|127.0.0.1:timer', 'i:1771621384;', 1771621384);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `activo`, `created_at`, `updated_at`) VALUES
(1, 'ACCESORIOS', 1, '2026-01-24 01:32:49', '2026-01-24 01:33:10'),
(2, 'CHEESECAKE', 1, '2026-01-24 01:33:20', '2026-01-24 01:33:20'),
(3, 'PASTELES CARMELITA', 1, '2026-01-24 01:33:31', '2026-01-24 01:33:31'),
(4, 'MACARONS', 1, '2026-01-24 01:33:39', '2026-01-24 01:33:39'),
(5, 'PASTEL HELADO', 1, '2026-01-24 01:33:49', '2026-01-24 01:33:49'),
(6, 'MINIS Y PANQUES', 1, '2026-01-24 01:34:00', '2026-01-24 01:34:00'),
(7, 'MOSTACHÓN', 1, '2026-01-24 01:34:09', '2026-01-24 01:34:09'),
(8, 'PAN DE MUERTO', 1, '2026-01-24 01:34:51', '2026-01-24 01:34:51'),
(9, 'PASTELES VAINILLA', 1, '2026-01-24 01:34:59', '2026-01-24 01:34:59'),
(10, 'PASTELES CHOCOLATE', 1, '2026-01-24 01:35:12', '2026-01-24 01:35:12'),
(11, 'PASTELES TRES LECHES', 1, '2026-01-24 01:35:21', '2026-01-24 01:35:21'),
(12, 'TARTAS INDIVIDUALES', 1, '2026-01-24 01:35:35', '2026-01-24 01:35:35'),
(13, 'ESPECIALIDADES', 1, '2026-01-24 01:35:50', '2026-01-24 01:35:50'),
(14, 'CAFETERIA', 1, '2026-01-28 21:42:09', '2026-01-28 21:42:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_22_181249_create_permission_tables', 1),
(5, '2026_01_22_184611_create_sucursals_table', 1),
(6, '2026_01_22_205552_add_activo_to_users_table', 1),
(7, '2026_01_22_213154_create_sucursal_user_table', 1),
(8, '2026_01_23_172517_create_categorias_table', 1),
(9, '2026_01_23_172749_create_productos_table', 1),
(10, '2026_01_23_183559_create_producto_variantes_table', 1),
(11, '2026_01_23_183813_create_producto_sucursal_table', 1),
(12, '2026_01_27_163938_create_ordenes_venta_table', 1),
(13, '2026_01_27_164145_create_orden_venta_detalles_table', 1),
(14, '2026_01_27_164738_create_orden_venta_mermas_table', 1),
(15, '2026_01_27_164838_create_orden_venta_gastos_table', 1),
(16, '2026_01_27_180221_remove_planta_id_from_ordenes_venta_table', 1),
(17, '2026_02_11_203454_add_observaciones_to_orden_venta_mermas_table', 1),
(18, '2026_02_16_192025_create_orden_venta_pagos_table', 1),
(19, '2026_02_16_212030_add_diferencia_to_orden_venta_pagos_table', 1),
(20, '2026_02_16_220717_create_remisiones_table', 1),
(21, '2026_02_17_172755_create_remision_detalles_table', 1),
(22, '2026_02_18_202808_modify_estado_remisiones_table', 2),
(23, '2026_02_19_170202_create_movimientos_inventario_table', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos_inventario`
--

CREATE TABLE `movimientos_inventario` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `producto_variante_id` bigint(20) UNSIGNED NOT NULL,
  `sucursal_origen_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sucursal_destino_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tipo` enum('transferencia','entrada','salida') NOT NULL,
  `cantidad` int(11) NOT NULL,
  `referencia` varchar(255) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `movimientos_inventario`
--

INSERT INTO `movimientos_inventario` (`id`, `producto_variante_id`, `sucursal_origen_id`, `sucursal_destino_id`, `tipo`, `cantidad`, `referencia`, `observaciones`, `created_at`, `updated_at`) VALUES
(1, 129, NULL, 2, 'entrada', 1, 'NA', 'NA', '2026-02-20 00:17:02', '2026-02-20 00:17:02'),
(2, 35, 5, 2, 'transferencia', 3, 'NA', 'NA', '2026-02-20 02:14:15', '2026-02-20 02:14:15'),
(3, 35, 2, NULL, 'salida', 3, 'NA', 'NA', '2026-02-20 02:15:26', '2026-02-20 02:15:26'),
(4, 35, NULL, 5, 'entrada', 3, 'NA', 'NA', '2026-02-20 02:16:02', '2026-02-20 02:16:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes_venta`
--

CREATE TABLE `ordenes_venta` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `folio` varchar(255) NOT NULL,
  `sucursal_id` bigint(20) UNSIGNED NOT NULL,
  `estado` enum('en_proceso','confirmada','cancelada') NOT NULL DEFAULT 'en_proceso',
  `fecha` datetime NOT NULL,
  `fecha_entrega` date DEFAULT NULL,
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `descuento` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_mermas` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_gastos` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `notas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_venta_detalles`
--

CREATE TABLE `orden_venta_detalles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `orden_venta_id` bigint(20) UNSIGNED NOT NULL,
  `producto_variante_id` bigint(20) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(12,2) NOT NULL,
  `descuento` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL,
  `notas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_venta_gastos`
--

CREATE TABLE `orden_venta_gastos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `orden_venta_id` bigint(20) UNSIGNED NOT NULL,
  `concepto` varchar(255) NOT NULL,
  `monto` decimal(12,2) NOT NULL,
  `comprobante_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_venta_mermas`
--

CREATE TABLE `orden_venta_mermas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `orden_venta_id` bigint(20) UNSIGNED NOT NULL,
  `producto_variante_id` bigint(20) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL,
  `monto` decimal(12,2) NOT NULL,
  `tipo_merma` enum('transporte','sucursal') NOT NULL,
  `origen_sucursal` enum('fabrica','sucursal') DEFAULT NULL,
  `lote` varchar(255) DEFAULT NULL,
  `imagen_path` varchar(255) NOT NULL,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_venta_pagos`
--

CREATE TABLE `orden_venta_pagos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `orden_venta_id` bigint(20) UNSIGNED NOT NULL,
  `metodo` enum('efectivo','tarjeta') NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `diferencia` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `categoria_id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `categoria_id`, `nombre`, `descripcion`, `activo`, `created_at`, `updated_at`) VALUES
(1, 1, 'CAKE TOPPER', 'Cake topper', 1, '2026-01-24 01:45:49', '2026-01-24 01:45:49'),
(2, 1, 'CAKE TOPPER CHICO', 'Cake topper chico', 1, '2026-01-24 01:46:13', '2026-01-24 01:46:13'),
(3, 1, 'VELA EXPLOSIVA', 'Vela explosiva', 1, '2026-01-24 01:46:44', '2026-01-24 01:46:44'),
(4, 1, 'DESECHABLES 15 PIEZAS', 'Desechables 15 piezas', 0, '2026-01-24 01:47:23', '2026-01-24 01:56:10'),
(5, 1, 'DESECHABLES 25 PIEZAS', 'Desechables 25 piezas', 0, '2026-01-24 01:47:49', '2026-01-24 01:56:07'),
(6, 1, 'DULCE KIT DESECHABLES', 'Dulce kit desechables', 0, '2026-01-24 01:48:11', '2026-01-24 01:55:15'),
(7, 1, 'DULCE KIT DESECHABLES CON VASOS 12 PIEZAS', 'Dulce kit desechables contiene:\r\n12 vasos - 12 platos - 12 tenedores - 12 servilletas', 1, '2026-01-24 01:48:35', '2026-01-24 01:55:07'),
(8, 2, 'CHEESECAKE BAKLAVA', 'CHEESECAKE BAKLAVA', 1, '2026-01-24 01:56:49', '2026-01-24 01:56:49'),
(9, 2, 'CHEESECAKE CALABAZA', 'CHEESECAKE CALABAZA', 1, '2026-01-24 01:57:08', '2026-01-24 01:57:08'),
(10, 2, 'CHEESECAKE LOTUS', 'Pay sabor queso con base de galleta y mantequilla, con una cubierta de pasta lotus y crema.', 1, '2026-01-24 01:58:08', '2026-01-24 01:58:08'),
(11, 2, 'CHEESECAKE ROL DE CANELA', 'CHEESECAKE ROL DE CANELA', 1, '2026-01-24 01:58:34', '2026-01-24 01:58:54'),
(12, 2, 'CHEESECAKE ZANAHORIA', 'Pan sabor zanahoria tipo americano, con pay de queso y nuez, decorado con crema.', 1, '2026-01-24 01:59:15', '2026-01-24 01:59:15'),
(13, 2, 'CHEESECAKE TORTUGA', 'CHEESECAKE TORTUGA', 1, '2026-01-24 01:59:48', '2026-01-24 01:59:48'),
(14, 2, 'CHEESECAKE GUAYABA', 'Base galleta y mantequilla, con combinación de queso crema, guayaba y almendra, decorado con crema y cobertura de ate de guayaba.', 1, '2026-01-24 02:00:16', '2026-01-24 02:00:16'),
(15, 2, 'CHEESECAKE JUANITO', 'Base galleta y mantequilla, con combinación de queso crema, plátano, nuez y cajeta, decorado con crema.', 1, '2026-01-24 02:00:43', '2026-01-24 02:00:43'),
(16, 2, 'CHEESECAKE MANZANELA', 'Base galleta y mantequilla, con combinación de queso crema, manzana, nuez y canela, decorado con crema.', 1, '2026-01-24 02:01:17', '2026-01-24 02:01:17'),
(17, 2, 'CHEESECAKE OREO', 'Base galleta oreo y mantequilla, con combinación de queso crema y galleta oreo, decorado con crema y chocolate semiamargo.', 1, '2026-01-24 02:01:41', '2026-01-24 02:01:41'),
(18, 3, 'FLAN CREME BRULEE', 'Base de flan con cajeta y nuez', 1, '2026-01-24 02:02:51', '2026-01-24 02:02:51'),
(19, 3, 'PASTEL FLAN CAJETA', 'Base de flan Bizcocho de vainilla bañado en tres leches Cubierta de crema blanca Relleno de dulce de leche y crema Decorado con crema sabor cajeta y trozos de nuez.', 1, '2026-01-24 02:03:31', '2026-01-24 02:03:31'),
(20, 3, 'PASTEL FLAN FERRERO', 'Base de flan Bizcocho de chocolate bañado en tres leches Cubierta de crema blanca Relleno de Nutella y crema Decorado con chocolate.', 1, '2026-01-24 02:03:57', '2026-01-24 02:03:57'),
(21, 3, 'PASTEL FLAN FRAMBUESA', 'Base de flan Bizcocho de vainilla bañado en tres leches Cubierta de crema blanca Bañado en salsa de frambuesa Decoraciones con chocolate semi amargo.', 1, '2026-01-24 02:04:27', '2026-01-24 02:04:27'),
(22, 3, 'PASTEL FLAN LOTUS', 'Base de flan Bizcocho de vainilla bañado en tres leches Cubierta de crema blanca Relleno de galleta Lotus y crema Decorado con crema sabor lotus.', 1, '2026-01-24 02:04:51', '2026-01-24 02:04:51'),
(23, 3, 'PASTEL FLAN MARCELL', 'Pan sabor chocolate con base de flan, bañado entres leches sabor crema irlandesa, relleno de nuez y cajeta, decorado con crema sabor moka y crispy de cacao.', 1, '2026-01-24 02:05:19', '2026-01-24 02:05:19'),
(24, 3, 'PASTEL FLAN PICORO', 'Pan sabor nuez con base flan, relleno de cajeta, nuez y plátano, decorado con crema sabor caramelo y una combinación de trozos de galleta sabor nuez.', 1, '2026-01-24 02:05:49', '2026-01-24 02:05:49'),
(25, 4, 'MACARRON SUELTO', 'MACARRON SUELTO SABOR VARIADO', 1, '2026-01-24 02:06:25', '2026-01-24 02:06:25'),
(26, 4, 'MACARRONES CAJA CON 10 PIEZAS', 'MACARRONES CAJA CON 10 PIEZAS SABOR VARIADO', 1, '2026-01-24 02:06:45', '2026-01-24 02:06:45'),
(27, 5, 'PASTEL HELADO COOKIES & CREAM', 'Pan de chocolate con helado sabor cookies and cream, decorado con crema y trozos de galleta.', 1, '2026-01-24 02:07:58', '2026-01-24 02:07:58'),
(28, 5, 'PASTEL HELADO NAPOLITANO', 'Pan de vainilla con helado sabor vainilla, fresa y chocolate, decorado con crema sabor fresa y chocolate.', 1, '2026-01-24 02:08:29', '2026-01-24 02:08:29'),
(29, 5, 'PASTEL HELADO GANSITO', 'Pan de vainilla con helado sabor gansito y trozos de gansito decorado con crema y chocolate con trozos de gansito.', 1, '2026-01-24 02:08:52', '2026-01-24 02:08:52'),
(30, 5, 'PASTEL HELADO NUEZ', 'Pan de vainilla con helado sabor nuez y trozos de nuez, decorado con crema y glaze de caramelo y trozos de nuez.', 1, '2026-01-24 02:09:13', '2026-01-24 02:09:13'),
(31, 5, 'PASTEL HELADO NUTY', 'Pan de chocolate con helado sabor Nuty y trozos de avellana decorado con crema y chocolate con trozos de almendra.', 1, '2026-01-24 02:09:33', '2026-01-24 02:09:33'),
(32, 5, 'PASTEL HELADO PISTACHE', 'Pan de chocolate con helado sabor pistache y trozos de pistache decorado con crema y cubierta de pistache.', 1, '2026-01-24 02:09:52', '2026-01-24 02:09:52'),
(33, 5, 'PASTEL HELADO FRUTOS DEL BOSQUE', 'Pan de vainilla con helado sabor frutos del bosque, decorado con crema y glazé frutos del bosque.', 1, '2026-01-24 02:10:16', '2026-01-24 02:10:16'),
(34, 5, 'PASTEL HELADO QUESO FRESA', 'Pan de vainilla con helado sabor queso fresa y trozos de pay decorado con crema y mermelada de fresa t chocolate blanco.', 1, '2026-01-24 02:10:33', '2026-01-24 02:10:33'),
(35, 5, 'PASTEL HELADO COCO ALMENDRA', 'Pan de vainilla con helado sabor coco almendra con trozos de coco y almendra, decorado con crema y coco rallado.', 1, '2026-01-24 02:10:55', '2026-01-24 02:10:55'),
(36, 13, 'PASTEL DE KILO', 'PASTEL DE KILO', 1, '2026-01-24 02:11:34', '2026-01-24 02:11:34'),
(37, 13, 'PASTEL KETO', 'PASTEL KETO', 1, '2026-01-24 02:11:47', '2026-01-24 02:11:47'),
(38, 13, 'REBANADA DE PASTEL', 'REBANADA DE PASTEL', 1, '2026-01-24 02:12:31', '2026-01-24 02:12:31'),
(39, 13, 'ROLLO CALABAZA', 'ROLLO CALABAZA', 1, '2026-01-24 02:12:40', '2026-01-24 02:12:40'),
(40, 13, 'TARTA ESPAÑOLA LOTUS', 'TARTA ESPAÑOLA', 1, '2026-01-24 02:12:54', '2026-01-24 02:12:54'),
(41, 6, 'PANQUE DE CALABAZA CON QUESO', 'PANQUE DE CALABAZA CON QUESO', 1, '2026-01-24 02:13:07', '2026-01-24 02:14:14'),
(42, 13, 'PASTEL CREPAS CAJETA', 'PASTEL CREPAS CAJETA', 1, '2026-01-24 02:13:30', '2026-01-24 02:13:30'),
(43, 13, 'PASTEL CREPAS NUTY', 'PASTEL CREPAS NUTY', 1, '2026-01-24 02:13:42', '2026-01-24 02:13:42'),
(44, 6, 'PANQUE DE ZANAHORIA', 'PANQUE ZANAHORIA', 1, '2026-01-24 02:14:00', '2026-01-24 02:31:12'),
(45, 6, 'MINI CHAROLA CAJETA', 'MINI CHAROLA CAJETA', 1, '2026-01-24 02:31:51', '2026-01-24 02:31:51'),
(46, 6, 'MINI  PASTEL  CUMPLEAÑOS', 'Pan sabor vainilla con confeti de colores, relleno de pay de queso sabor blueberry, decorado con crema.', 1, '2026-01-24 02:32:38', '2026-01-24 02:32:38'),
(47, 6, 'PASTEL MINI BRUCE', 'Pan sabor chocolate, ligeramente envinado en tres leches, con un relleno y decorado de betún de chocolate semiamargo.', 1, '2026-01-24 02:33:13', '2026-01-24 02:33:13'),
(48, 6, 'PASTEL MINI LOTUS 3 LECHES', 'Pan sabor vainilla, bañado en tres leches, relleno de galleta lotus, decorado con crema sabor caramelo.', 1, '2026-01-24 02:33:48', '2026-01-24 02:33:48'),
(49, 6, 'PASTEL MINI NUTY', 'Pan sabor chocolate, ligeramente envinado en tres leches, relleno con mousse sabor avellana y almendras, decorado con betún de chocolate semiamargo.', 1, '2026-01-24 02:34:23', '2026-01-24 02:34:23'),
(50, 6, 'PASTEL MINI COCO ALMENDRA', 'Pan sabor vainilla, ligeramente envinado en tres leches, relleno de almendras, decorado con crema y coco.', 1, '2026-01-24 02:34:50', '2026-01-24 02:34:50'),
(51, 6, 'PASTEL MINI ZANAHORIA', 'Pan sabor zanahoria, relleno de pay de queso, decorado con crema.', 1, '2026-01-24 02:35:14', '2026-01-24 02:35:14'),
(52, 7, 'MOSTACHON FRESA', 'Preparado con claras de huevo, azúcar, nuez y galletas ritz, relleno de nuestra deliciosa crema y fresa.', 1, '2026-01-24 02:35:50', '2026-01-24 02:35:50'),
(53, 7, 'MOSTACHON MANGO', 'Preparado con claras de huevo, azúcar, nuez y galletas ritz, relleno de nuestra deliciosa crema y mango.', 1, '2026-01-24 02:36:09', '2026-01-24 02:36:09'),
(54, 7, 'MOSTACHON PLATANO', 'Preparado con claras de huevo, azúcar, nuez y galletas ritz, relleno de nuestra deliciosa crema y plátano.', 1, '2026-01-24 02:36:38', '2026-01-24 02:36:38'),
(55, 9, 'PASTEL CARLOTA', 'Pan sabor vainilla, ligeramente envinado en tres leches, relleno y decorado con lechera untable y trozos de galleta sabor limón.', 1, '2026-01-24 02:37:57', '2026-01-24 02:37:57'),
(56, 9, 'PASTEL NARANJA', 'Pan sabor naranja, ligeramente envinado en tres leches, relleno de cheesecake, decorado con crema sabor naranja y coco tostado.', 1, '2026-01-24 02:38:18', '2026-01-24 02:38:18'),
(57, 9, 'PASTEL COCO ALMENDRA', 'Pan sabor vainilla, ligeramente envinado en tres leches, relleno de almendras, decorado con crema y coco.', 1, '2026-01-24 02:38:38', '2026-01-24 02:38:38'),
(58, 9, 'PASTEL FRESAS CON CREMA', 'Pan sabor vainilla, ligeramente envinado en tres leches, relleno de fresas naturales, decorado con crema y yogurt.', 1, '2026-01-24 02:39:03', '2026-01-24 02:39:03'),
(59, 9, 'PASTEL PEPITO', 'Pan sabor vainilla, relleno de cajeta, decorado con crema caramelo y trozos galleta nuez.', 1, '2026-01-24 02:39:39', '2026-01-24 02:39:39'),
(61, 9, 'PASTEL BLUEBERRY', 'Pan sabor blueberry, relleno de pay de queso blueberry, decorado con crema y coulis frutos del bosque.', 1, '2026-01-24 02:40:01', '2026-02-07 01:31:35'),
(62, 9, 'PASTEL CHEESECAKE ZANAHORIA', 'Pan sabor zanahoria, relleno de pay de queso, decorado con crema.', 1, '2026-01-24 02:40:26', '2026-01-24 02:40:26'),
(63, 9, 'PASTEL ROCIO', 'Pan sabor fresa, relleno de pay de queso, decorado con crema sabor fresa y trozos de galletas.', 1, '2026-01-24 02:40:43', '2026-01-24 02:40:43'),
(64, 9, 'PASTEL ITALIANO DE BODAS', 'Pan sabor nuez, ligeramente envinado en tres leches sabor durazno, relleno de durazno y almendras, decorado con betún queso crema, coco tostado y yogurt.', 1, '2026-01-24 02:41:07', '2026-01-24 02:41:07'),
(65, 9, 'PASTEL QUESO FRESA', 'Pan sabor vainilla con pay de queso, relleno de fresas naturales, decorado con crema, coulis de fresa y rizos de chocolate semiamargo.', 1, '2026-01-24 02:41:26', '2026-01-24 02:41:26'),
(66, 9, 'PASTEL CARIÑOSITO', 'Pan sabor vainilla con confeti de colores, relleno de pay de queso sabor blueberry, decorado con crema.', 1, '2026-01-24 02:41:44', '2026-01-24 02:41:44'),
(67, 11, 'PASTEL MOKA 3L', 'Pan esponja sabor café, bañado en tres leches, relleno de nuez y cajeta, decorado con crema sabor moka.', 1, '2026-01-24 02:42:40', '2026-02-07 02:14:46'),
(68, 11, 'PASTEL COOKIES & CREAM 3L', 'Pastel esponja sabor vainilla, bañado en tres leches, relleno galleta oreo®, decorado con crema.', 1, '2026-01-24 02:43:11', '2026-01-24 02:43:11'),
(69, 11, 'PASTEL TIRAMISÚ 3L', 'Pan esponja sabor café, bañado en tres leches, relleno de nuez, decorado con una ligera capa de crema y cocoa.', 1, '2026-01-24 02:43:37', '2026-01-24 02:43:37'),
(70, 11, 'PASTEL MANGO 3L', 'Pan esponja sabor vainilla, bañado en tres leches, relleno de glasé de mango, decorado con una ligera capa de crema y trozos de mango natural.', 1, '2026-01-24 02:43:59', '2026-01-24 02:43:59'),
(71, 11, 'PASTEL BLUEBERRY 3L', 'Pan esponja sabor vainilla, bañado en tres leches, relleno de pay de queso sabor blueberry, decorado con crema y coulis frutos del bosque.', 1, '2026-01-24 02:44:17', '2026-01-24 02:44:17'),
(73, 11, 'PASTEL CREMA IRLANDESA 3L', 'Pan esponja sabor café, bañado en tres leches crema irlandesa, relleno de nuez y cajeta, decorado con una ligera capa de crema y cocoa.', 1, '2026-01-24 02:44:42', '2026-01-24 02:44:42'),
(74, 11, 'PASTEL RENATA 3L', 'Pan esponja sabor vainilla, bañado en tres leches, relleno de fresas naturales, decorado con crema sabor fresa y rizos de chocolate blanco.', 1, '2026-01-24 02:45:03', '2026-01-24 02:45:03'),
(75, 11, 'PASTEL MARMOLEADO', 'Pan esponja sabor vainilla, bañado en tres leches, relleno de Brownie, decorado con crema y chocolate.', 1, '2026-01-24 02:45:21', '2026-01-24 02:45:21'),
(76, 11, 'PASTEL MARACUYA 3L', 'Pan esponja sabor vainilla, bañado en tres leches, relleno con trozos de pay de queso y mango natural, decorado con crema y cobertura de maracuyá-mango.', 1, '2026-01-24 02:45:48', '2026-01-24 02:45:48'),
(77, 11, 'PASTEL ARROZ CON LECHE 3L', 'Pan esponja sabor vainilla, bañado en tres leches, relleno de pay de queso sabor arroz con leche, decorado con crema, chocolate blanco, nuez y canela.', 1, '2026-01-24 02:46:26', '2026-01-24 02:46:26'),
(78, 11, 'PASTEL GUAYABA 3L', 'Pan esponja sabor vainilla, bañado tres leches, relleno de pay de queso y trozos de guayaba, decorado con crema, cobertura de ate de guayaba y rizos de chocolate blanco.', 1, '2026-01-24 02:46:45', '2026-01-24 02:46:45'),
(79, 11, 'PASTEL CRUNCH 3L', 'Pan esponja sabor chocolate, bañado en tres leches, relleno de crema y trozos de chocolate CRUNCH®, decorado con betún de chocolate.', 1, '2026-01-24 02:47:03', '2026-01-24 02:47:03'),
(80, 10, 'PASTEL SELVA NEGRA', 'Pan sabor chocolate, ligeramente envinado en jarabe de azúcar, relleno de cerezas, decorado con crema y rizos de chocolate semiamargo.', 1, '2026-01-24 02:47:47', '2026-01-24 02:47:47'),
(81, 10, 'PASTEL ALEMÁN', 'Pan de chocolate, ligeramente envinado en tres leches, relleno de queso crema, decorado con coco, nuez, cereza y dulce alemán.', 1, '2026-01-24 02:48:07', '2026-01-24 02:48:07'),
(82, 10, 'PASTEL ALEXANDER', 'Pan de chocolate con pay de queso, ligeramente envinado en tres leches crema irlandesa, con un relleno y decorado de betún de chocolate y rizos de chocolate blanco.', 1, '2026-01-24 02:48:22', '2026-01-24 02:48:22'),
(83, 10, 'PASTEL LOVERS', 'Pan de chocolate con pay de queso, ligeramente envinado en tres leches crema irlandesa, con un relleno y decorado de betún de chocolate y rizos de chocolate blanco.', 1, '2026-01-24 02:48:37', '2026-01-24 02:48:37'),
(84, 10, 'PASTEL NUTY', 'Pan sabor chocolate, ligeramente envinado en tres leches, relleno con mousse sabor avellana y almendras, decorado con betún de chocolate semiamargo.', 1, '2026-01-24 02:48:50', '2026-01-24 02:48:50'),
(85, 10, 'PASTEL RED VELVET', 'Pan sabor chocolate rojo con pay de queso, relleno de mermelada de frambuesa, decorado con crema.', 1, '2026-01-24 02:49:05', '2026-01-24 02:49:05'),
(86, 10, 'PASTEL BRUCE', 'Pan sabor chocolate, ligeramente envinado en tres leches, con un relleno y decorado de betún de chocolate semiamargo.', 1, '2026-01-24 02:49:21', '2026-01-24 02:49:21'),
(87, 10, 'PASTEL MI MONKEY', 'Pan sabor chocolate, ligeramente envinado en tres leches, relleno de plátano, nuez y cajeta, decorado con betún de chocolate.', 1, '2026-01-24 02:49:47', '2026-01-24 02:49:47'),
(88, 10, 'PASTEL PISTACHE', 'Pan sabor chocolate, ligeramente envinado en tres leches, relleno con crema sabor pistache, decorado con betún de chocolate.', 1, '2026-01-24 02:50:07', '2026-01-24 02:50:07'),
(89, 12, 'TARTA INDIVIDUAL GLORIA Y QUESO', 'TARTA INDIVIDUAL GLORIA Y QUESO', 1, '2026-01-24 02:52:33', '2026-01-24 02:52:33'),
(90, 12, 'TARTA INDIVIDUAL MANZANA-CANELA', 'TARTA INDIVIDUAL MANZANA-CANELA', 1, '2026-01-24 02:52:46', '2026-01-24 02:52:46'),
(91, 12, 'TARTA INDIVIDUAL NATILLA-NUEZ', 'TARTA INDIVIDUAL NATILLA-NUEZ', 1, '2026-01-24 02:52:57', '2026-01-24 02:52:57'),
(92, 12, 'TARTA INDIVIDUAL NUEZ-MAPLE', 'TARTA INDIVIDUAL NUEZ-MAPLE', 1, '2026-01-24 02:53:22', '2026-01-24 02:53:22'),
(93, 12, 'TARTA INDIVIDUAL QUESO-LIMON', 'TARTA INDIVIDUAL QUESO-LIMON', 1, '2026-01-24 02:53:34', '2026-01-24 02:53:34'),
(95, 13, 'PISTACHÓN', 'pan aromatizado con una mezcla de especias como canela, nuez moscada, jengibre, relleno de delicioso betún de queso crema y mantequilla, y coronado con un irresistible topping de pistache salado.', 1, '2026-02-07 04:05:32', '2026-02-07 04:05:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_sucursal`
--

CREATE TABLE `producto_sucursal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sucursal_id` bigint(20) UNSIGNED NOT NULL,
  `producto_variante_id` bigint(20) UNSIGNED NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto_sucursal`
--

INSERT INTO `producto_sucursal` (`id`, `sucursal_id`, `producto_variante_id`, `precio`, `stock`, `activo`, `created_at`, `updated_at`) VALUES
(1, 5, 16, 1.00, 0, 1, '2026-02-19 00:54:18', '2026-02-19 02:41:01'),
(2, 5, 17, 1.00, 0, 1, '2026-02-19 00:54:18', '2026-02-19 02:41:01'),
(3, 5, 36, 1.00, 0, 1, '2026-02-19 00:54:18', '2026-02-19 02:41:01'),
(4, 5, 18, 1.00, 0, 1, '2026-02-19 00:54:18', '2026-02-19 02:41:01'),
(5, 5, 3, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:01'),
(6, 5, 4, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:01'),
(7, 5, 7, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:01'),
(8, 5, 10, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:01'),
(9, 5, 12, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:01'),
(10, 5, 11, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:01'),
(11, 5, 5, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(12, 5, 6, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(13, 5, 8, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(14, 5, 9, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(15, 5, 13, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(16, 5, 103, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(17, 5, 102, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(18, 5, 101, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(19, 5, 100, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(20, 5, 99, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(21, 5, 98, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(22, 5, 14, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(23, 5, 15, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(24, 5, 92, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(25, 5, 89, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(26, 5, 90, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(27, 5, 88, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(28, 5, 87, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(29, 5, 86, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(30, 5, 91, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(31, 5, 85, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(32, 5, 93, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(33, 5, 104, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(34, 5, 82, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(35, 5, 46, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(36, 5, 43, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(37, 5, 42, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(38, 5, 109, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(39, 5, 107, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(40, 5, 129, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(41, 5, 24, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(42, 5, 25, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(43, 5, 20, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(44, 5, 19, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(45, 5, 71, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(46, 5, 69, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(47, 5, 68, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(48, 5, 70, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(49, 5, 67, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(50, 5, 21, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(51, 5, 22, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(52, 5, 23, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(53, 5, 1, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(54, 5, 2, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(55, 5, 65, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(56, 5, 66, 525.00, 1, 1, '2026-02-19 00:54:18', '2026-02-19 02:56:42'),
(57, 5, 117, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(58, 5, 118, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(59, 5, 96, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(60, 5, 97, 500.00, 1, 1, '2026-02-19 00:54:18', '2026-02-19 02:56:42'),
(61, 5, 61, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(62, 5, 62, 500.00, 2, 1, '2026-02-19 00:54:18', '2026-02-19 02:56:42'),
(63, 5, 34, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(64, 5, 35, 500.00, 3, 1, '2026-02-19 00:54:18', '2026-02-20 02:16:02'),
(65, 5, 119, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(66, 5, 120, 500.00, 2, 1, '2026-02-19 00:54:18', '2026-02-19 02:56:42'),
(67, 5, 51, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(68, 5, 52, 520.00, 2, 1, '2026-02-19 00:54:18', '2026-02-19 02:56:42'),
(69, 5, 83, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(70, 5, 84, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(71, 5, 57, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(72, 5, 58, 500.00, 2, 1, '2026-02-19 00:54:18', '2026-02-19 02:56:42'),
(73, 5, 121, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(74, 5, 122, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(75, 5, 127, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(76, 5, 128, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(77, 5, 115, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(78, 5, 116, 500.00, 2, 1, '2026-02-19 00:54:18', '2026-02-19 02:56:42'),
(79, 5, 47, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(80, 5, 48, 500.00, 1, 1, '2026-02-19 00:54:18', '2026-02-19 02:56:42'),
(81, 5, 78, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(82, 5, 79, 500.00, 1, 1, '2026-02-19 00:54:18', '2026-02-19 02:56:42'),
(83, 5, 125, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(84, 5, 126, 500.00, 1, 1, '2026-02-19 00:54:18', '2026-02-19 02:56:42'),
(85, 5, 111, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(86, 5, 112, 500.00, 1, 1, '2026-02-19 00:54:18', '2026-02-19 02:56:42'),
(87, 5, 53, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(88, 5, 54, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(89, 5, 74, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(90, 5, 75, 500.00, 2, 1, '2026-02-19 00:54:18', '2026-02-19 02:56:42'),
(91, 5, 76, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(92, 5, 77, 500.00, 1, 1, '2026-02-19 00:54:18', '2026-02-19 02:56:42'),
(93, 5, 30, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(94, 5, 31, 500.00, 2, 1, '2026-02-19 00:54:18', '2026-02-19 02:56:42'),
(95, 5, 94, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(96, 5, 95, 500.00, 2, 1, '2026-02-19 00:54:18', '2026-02-19 02:56:42'),
(97, 5, 105, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(98, 5, 106, 500.00, 1, 1, '2026-02-19 00:54:18', '2026-02-19 02:56:42'),
(99, 5, 49, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(100, 5, 50, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(101, 5, 26, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(102, 5, 27, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(103, 5, 28, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(104, 5, 29, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(105, 5, 80, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(106, 5, 81, 500.00, 1, 1, '2026-02-19 00:54:18', '2026-02-19 02:56:42'),
(107, 5, 63, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(108, 5, 64, 525.00, 1, 1, '2026-02-19 00:54:18', '2026-02-19 02:56:42'),
(109, 5, 55, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(110, 5, 56, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(111, 5, 123, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(112, 5, 124, 525.00, 2, 1, '2026-02-19 00:54:18', '2026-02-19 02:56:42'),
(113, 5, 72, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(114, 5, 73, 500.00, 1, 1, '2026-02-19 00:54:18', '2026-02-19 02:56:42'),
(115, 5, 59, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(116, 5, 60, 525.00, 1, 1, '2026-02-19 00:54:18', '2026-02-19 02:56:42'),
(117, 5, 41, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(118, 5, 40, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(119, 5, 39, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(120, 5, 38, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(121, 5, 37, 0.00, 0, 0, '2026-02-19 00:54:18', '2026-02-19 02:41:02'),
(122, 2, 129, 0.00, 1, 1, '2026-02-20 00:17:01', '2026-02-20 00:17:02'),
(123, 2, 35, 500.00, 0, 1, '2026-02-20 02:14:15', '2026-02-20 02:15:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_variantes`
--

CREATE TABLE `producto_variantes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `producto_id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto_variantes`
--

INSERT INTO `producto_variantes` (`id`, `producto_id`, `nombre`, `sku`, `activo`, `created_at`, `updated_at`) VALUES
(1, 55, 'Chico', NULL, 1, '2026-01-24 03:12:23', '2026-01-24 03:12:23'),
(2, 55, 'Grande', NULL, 1, '2026-01-24 03:12:33', '2026-01-24 03:12:33'),
(3, 8, 'TAMAÑO UNICO', NULL, 1, '2026-01-24 03:12:53', '2026-01-24 03:12:53'),
(4, 9, 'TAMAÑO UNICO', NULL, 1, '2026-01-24 03:13:15', '2026-01-24 03:13:15'),
(5, 14, 'TAMAÑO UNICO', NULL, 1, '2026-01-24 03:13:44', '2026-01-24 03:13:44'),
(6, 15, 'TAMAÑO UNICO', NULL, 1, '2026-01-24 03:13:53', '2026-01-24 03:13:53'),
(7, 10, 'TAMAÑO UNICO', NULL, 1, '2026-01-24 03:14:04', '2026-01-24 03:14:04'),
(8, 16, 'TAMAÑO UNICO', NULL, 1, '2026-01-24 03:14:12', '2026-01-24 03:14:12'),
(9, 17, 'TAMAÑO UNICO', NULL, 1, '2026-01-24 03:14:20', '2026-01-24 03:14:20'),
(10, 11, 'TAMAÑO UNICO', NULL, 1, '2026-01-24 03:14:32', '2026-01-24 03:14:32'),
(11, 13, 'TAMAÑO UNICO', NULL, 1, '2026-01-24 03:14:41', '2026-01-24 03:14:41'),
(12, 12, 'TAMAÑO UNICO', NULL, 1, '2026-01-24 03:14:50', '2026-01-24 03:14:50'),
(13, 18, 'TAMAÑO UNICO', NULL, 1, '2026-01-24 03:15:10', '2026-01-24 03:15:10'),
(14, 25, 'PIEZA', NULL, 1, '2026-01-24 03:15:26', '2026-01-24 03:15:26'),
(15, 26, 'CAJA', NULL, 1, '2026-01-24 03:15:49', '2026-01-24 03:15:49'),
(16, 1, 'PIEZA', NULL, 1, '2026-01-24 04:00:53', '2026-01-24 04:00:53'),
(17, 2, 'PIEZA', NULL, 1, '2026-01-24 04:01:02', '2026-01-24 04:01:02'),
(18, 7, 'PAQUETE', NULL, 1, '2026-01-24 04:01:21', '2026-01-24 04:01:21'),
(19, 46, 'TAMAÑO UNICO', NULL, 1, '2026-01-24 04:01:47', '2026-01-24 04:01:47'),
(20, 45, 'TAMAÑO UNICO', NULL, 1, '2026-01-24 04:01:59', '2026-01-24 04:01:59'),
(21, 52, 'TAMAÑO UNICO', NULL, 1, '2026-01-24 04:02:26', '2026-01-24 04:02:26'),
(22, 53, 'TAMAÑO UNICO', NULL, 1, '2026-01-24 04:02:36', '2026-01-24 04:02:36'),
(23, 54, 'TAMAÑO UNICO', NULL, 1, '2026-01-24 04:02:46', '2026-01-24 04:02:46'),
(24, 41, 'TAMAÑO UNICO', NULL, 1, '2026-01-24 04:03:10', '2026-01-24 04:03:10'),
(25, 44, 'TAMAÑO UNICO', NULL, 1, '2026-01-24 04:03:25', '2026-01-24 04:03:25'),
(26, 81, 'CHICO', NULL, 1, '2026-01-24 04:03:45', '2026-01-24 04:03:45'),
(27, 81, 'GRANDE', NULL, 1, '2026-01-24 04:03:52', '2026-01-24 04:03:52'),
(28, 82, 'CHICO', NULL, 1, '2026-01-24 04:04:20', '2026-01-24 04:04:20'),
(29, 82, 'GRANDE', NULL, 1, '2026-01-24 04:04:27', '2026-01-24 04:04:27'),
(30, 77, 'CHICO', NULL, 1, '2026-01-24 04:04:44', '2026-01-24 04:04:44'),
(31, 77, 'GRANDE', NULL, 1, '2026-01-24 04:04:51', '2026-01-24 04:04:51'),
(34, 61, 'CHICO', NULL, 1, '2026-01-24 04:06:17', '2026-01-24 04:06:17'),
(35, 61, 'GRANDE', NULL, 1, '2026-01-24 04:06:22', '2026-01-24 04:06:22'),
(36, 3, 'PIEZA', NULL, 1, '2026-01-26 21:59:52', '2026-01-26 21:59:52'),
(37, 93, 'PIEZA', NULL, 1, '2026-01-26 22:00:06', '2026-01-26 22:00:06'),
(38, 92, 'PIEZA', NULL, 1, '2026-01-26 22:00:21', '2026-01-26 22:00:21'),
(39, 91, 'PIEZA', NULL, 1, '2026-01-26 22:00:37', '2026-01-26 22:00:37'),
(40, 90, 'PIEZA', NULL, 1, '2026-01-26 22:00:53', '2026-01-26 22:00:53'),
(41, 89, 'PIEZA', NULL, 1, '2026-01-26 22:01:06', '2026-01-26 22:01:06'),
(42, 40, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 22:01:28', '2026-01-26 22:01:28'),
(43, 39, 'PIEZA', NULL, 1, '2026-01-26 22:01:55', '2026-01-26 22:01:55'),
(46, 38, 'REBANADA', NULL, 1, '2026-01-26 23:26:06', '2026-01-26 23:26:06'),
(47, 69, 'CHICO', NULL, 1, '2026-01-26 23:27:12', '2026-01-26 23:27:12'),
(48, 69, 'GRANDE', NULL, 1, '2026-01-26 23:28:28', '2026-01-26 23:28:28'),
(49, 80, 'CHICO', NULL, 1, '2026-01-26 23:28:35', '2026-01-26 23:28:35'),
(50, 80, 'GRANDE', NULL, 1, '2026-01-26 23:28:40', '2026-01-26 23:28:40'),
(51, 63, 'CHICO', NULL, 1, '2026-01-26 23:28:48', '2026-01-26 23:28:48'),
(52, 63, 'GRANDE', NULL, 1, '2026-01-26 23:28:53', '2026-01-26 23:28:53'),
(53, 74, 'CHICO', NULL, 1, '2026-01-26 23:34:52', '2026-01-26 23:34:52'),
(54, 74, 'GRANDE', NULL, 1, '2026-01-26 23:34:57', '2026-01-26 23:34:57'),
(55, 85, 'CHICO', NULL, 1, '2026-01-26 23:35:05', '2026-01-26 23:35:05'),
(56, 85, 'GRANDE', NULL, 1, '2026-01-26 23:35:10', '2026-01-26 23:35:10'),
(57, 65, 'CHICO', NULL, 1, '2026-01-26 23:36:21', '2026-01-26 23:36:21'),
(58, 65, 'GRANDE', NULL, 1, '2026-01-26 23:36:29', '2026-01-26 23:36:29'),
(59, 88, 'CHICO', NULL, 1, '2026-01-26 23:36:37', '2026-01-26 23:36:37'),
(60, 88, 'GRANDE', NULL, 1, '2026-01-26 23:36:43', '2026-01-26 23:36:43'),
(61, 59, 'CHICO', NULL, 1, '2026-01-26 23:36:51', '2026-01-26 23:36:51'),
(62, 59, 'GRANDE', NULL, 1, '2026-01-26 23:36:59', '2026-01-26 23:36:59'),
(63, 84, 'CHICO', NULL, 1, '2026-01-26 23:37:11', '2026-01-26 23:37:11'),
(64, 84, 'GRANDE', NULL, 1, '2026-01-26 23:37:17', '2026-01-26 23:37:17'),
(65, 56, 'CHICO', NULL, 1, '2026-01-26 23:38:05', '2026-01-26 23:38:05'),
(66, 56, 'GRANDE', NULL, 1, '2026-01-26 23:38:12', '2026-01-26 23:38:12'),
(67, 51, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 23:38:31', '2026-01-26 23:38:31'),
(68, 49, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 23:38:38', '2026-01-26 23:38:38'),
(69, 48, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 23:38:44', '2026-01-26 23:38:44'),
(70, 50, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 23:39:12', '2026-01-26 23:39:12'),
(71, 47, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 23:39:24', '2026-01-26 23:39:24'),
(72, 87, 'CHICO', NULL, 1, '2026-01-26 23:39:32', '2026-01-26 23:39:32'),
(73, 87, 'GRANDE', NULL, 1, '2026-01-26 23:39:36', '2026-01-26 23:39:36'),
(74, 75, 'CHICO', NULL, 1, '2026-01-26 23:40:09', '2026-01-26 23:40:09'),
(75, 75, 'GRANDE', NULL, 1, '2026-01-26 23:40:14', '2026-01-26 23:40:14'),
(76, 76, 'CHICO', NULL, 1, '2026-01-26 23:40:21', '2026-01-26 23:40:21'),
(77, 76, 'GRANDE', NULL, 1, '2026-01-26 23:40:24', '2026-01-26 23:40:24'),
(78, 70, 'CHICO', NULL, 1, '2026-01-26 23:40:32', '2026-01-26 23:40:32'),
(79, 70, 'GRANDE', NULL, 1, '2026-01-26 23:40:36', '2026-01-26 23:40:36'),
(80, 83, 'CHICO', NULL, 1, '2026-01-26 23:40:46', '2026-01-26 23:40:46'),
(81, 83, 'GRANDE', NULL, 1, '2026-01-26 23:40:53', '2026-01-26 23:40:53'),
(82, 37, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 23:41:20', '2026-01-26 23:41:20'),
(83, 64, 'CHICO', NULL, 1, '2026-01-26 23:41:25', '2026-01-26 23:41:25'),
(84, 64, 'GRANDE', NULL, 1, '2026-01-26 23:41:30', '2026-01-26 23:41:30'),
(85, 34, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 23:41:40', '2026-01-26 23:41:40'),
(86, 32, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 23:41:45', '2026-01-26 23:41:45'),
(87, 31, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 23:41:56', '2026-01-26 23:41:56'),
(88, 30, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 23:43:30', '2026-01-26 23:43:30'),
(89, 28, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 23:44:01', '2026-01-26 23:44:01'),
(90, 29, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 23:44:07', '2026-01-26 23:44:07'),
(91, 33, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 23:44:15', '2026-01-26 23:44:15'),
(92, 27, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 23:44:20', '2026-01-26 23:44:20'),
(93, 35, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 23:44:27', '2026-01-26 23:44:27'),
(94, 78, 'CHICO', NULL, 1, '2026-01-26 23:44:46', '2026-01-26 23:44:46'),
(95, 78, 'GRANDE', NULL, 1, '2026-01-26 23:44:50', '2026-01-26 23:44:50'),
(96, 58, 'CHICO', NULL, 1, '2026-01-26 23:45:23', '2026-01-26 23:45:23'),
(97, 58, 'GRANDE', NULL, 1, '2026-01-26 23:45:27', '2026-01-26 23:45:27'),
(98, 24, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 23:45:35', '2026-01-26 23:45:35'),
(99, 23, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 23:45:41', '2026-01-26 23:45:41'),
(100, 22, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 23:46:36', '2026-01-26 23:46:36'),
(101, 21, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 23:47:05', '2026-01-26 23:47:05'),
(102, 20, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 23:47:10', '2026-01-26 23:47:10'),
(103, 19, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 23:47:16', '2026-01-26 23:47:16'),
(104, 36, 'PIEZA', NULL, 1, '2026-01-26 23:47:40', '2026-01-26 23:47:40'),
(105, 79, 'CHICO', NULL, 1, '2026-01-26 23:48:30', '2026-01-26 23:48:30'),
(106, 79, 'GRANDE', NULL, 1, '2026-01-26 23:48:35', '2026-01-26 23:48:35'),
(107, 43, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 23:49:09', '2026-02-11 22:11:52'),
(108, 43, 'GRANDE', NULL, 0, '2026-01-26 23:49:13', '2026-02-11 22:11:47'),
(109, 42, 'TAMAÑO UNICO', NULL, 1, '2026-01-26 23:49:20', '2026-02-11 22:11:41'),
(110, 42, 'GRANDE', NULL, 0, '2026-01-26 23:49:24', '2026-02-11 22:11:30'),
(111, 73, 'CHICO', NULL, 1, '2026-01-26 23:49:30', '2026-01-26 23:49:30'),
(112, 73, 'GRANDE', NULL, 1, '2026-01-26 23:49:35', '2026-01-26 23:49:35'),
(115, 68, 'CHICO', NULL, 1, '2026-01-26 23:50:12', '2026-01-26 23:50:12'),
(116, 68, 'GRANDE', NULL, 1, '2026-01-26 23:50:18', '2026-01-26 23:50:18'),
(117, 57, 'CHICO', NULL, 1, '2026-01-26 23:50:29', '2026-01-26 23:50:29'),
(118, 57, 'GRANDE', NULL, 1, '2026-01-26 23:50:34', '2026-01-26 23:50:34'),
(119, 62, 'CHICO', NULL, 1, '2026-01-26 23:50:44', '2026-01-26 23:50:44'),
(120, 62, 'GRANDE', NULL, 1, '2026-01-26 23:50:48', '2026-01-26 23:50:48'),
(121, 66, 'CHICO', NULL, 1, '2026-01-26 23:51:05', '2026-01-26 23:51:05'),
(122, 66, 'GRANDE', NULL, 1, '2026-01-26 23:51:09', '2026-01-26 23:51:09'),
(123, 86, 'CHICO', NULL, 1, '2026-01-26 23:51:25', '2026-01-26 23:51:25'),
(124, 86, 'GRANDE', NULL, 1, '2026-01-26 23:51:28', '2026-01-26 23:51:28'),
(125, 71, 'CHICO', NULL, 1, '2026-01-26 23:51:35', '2026-01-26 23:51:35'),
(126, 71, 'GRANDE', NULL, 1, '2026-01-26 23:51:41', '2026-01-26 23:51:41'),
(127, 67, 'CHICO', NULL, 1, '2026-02-07 02:15:19', '2026-02-07 02:15:19'),
(128, 67, 'GRANDE', NULL, 1, '2026-02-07 02:15:25', '2026-02-07 02:15:25'),
(129, 95, 'TAMAÑO UNICO', NULL, 1, '2026-02-07 04:05:49', '2026-02-07 04:05:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `remisiones`
--

CREATE TABLE `remisiones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `folio` varchar(255) NOT NULL,
  `sucursal_id` bigint(20) UNSIGNED NOT NULL,
  `estado` enum('en_proceso','finalizada','cancelada') NOT NULL DEFAULT 'en_proceso',
  `fecha` datetime NOT NULL,
  `fecha_entrega` date DEFAULT NULL,
  `notas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `remisiones`
--

INSERT INTO `remisiones` (`id`, `folio`, `sucursal_id`, `estado`, `fecha`, `fecha_entrega`, `notas`, `created_at`, `updated_at`) VALUES
(8, 'REM-2026-000001', 5, 'finalizada', '2026-02-18 20:45:25', NULL, 'REMISION FAB46099', '2026-02-19 02:45:25', '2026-02-19 02:56:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `remision_detalles`
--

CREATE TABLE `remision_detalles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `remision_id` bigint(20) UNSIGNED NOT NULL,
  `producto_variante_id` bigint(20) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL,
  `notas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `remision_detalles`
--

INSERT INTO `remision_detalles` (`id`, `remision_id`, `producto_variante_id`, `cantidad`, `notas`, `created_at`, `updated_at`) VALUES
(19, 8, 97, 1, NULL, '2026-02-19 02:56:15', '2026-02-19 02:56:15'),
(20, 8, 62, 2, NULL, '2026-02-19 02:56:15', '2026-02-19 02:56:15'),
(21, 8, 35, 3, NULL, '2026-02-19 02:56:15', '2026-02-19 02:56:15'),
(22, 8, 58, 2, NULL, '2026-02-19 02:56:15', '2026-02-19 02:56:15'),
(23, 8, 120, 2, NULL, '2026-02-19 02:56:15', '2026-02-19 02:56:15'),
(24, 8, 52, 2, NULL, '2026-02-19 02:56:15', '2026-02-19 02:56:15'),
(25, 8, 66, 1, NULL, '2026-02-19 02:56:15', '2026-02-19 02:56:15'),
(26, 8, 60, 1, NULL, '2026-02-19 02:56:15', '2026-02-19 02:56:15'),
(27, 8, 64, 1, NULL, '2026-02-19 02:56:15', '2026-02-19 02:56:15'),
(28, 8, 124, 2, NULL, '2026-02-19 02:56:15', '2026-02-19 02:56:15'),
(29, 8, 81, 1, NULL, '2026-02-19 02:56:15', '2026-02-19 02:56:15'),
(30, 8, 73, 1, NULL, '2026-02-19 02:56:15', '2026-02-19 02:56:15'),
(31, 8, 116, 2, NULL, '2026-02-19 02:56:15', '2026-02-19 02:56:15'),
(32, 8, 48, 1, NULL, '2026-02-19 02:56:15', '2026-02-19 02:56:15'),
(33, 8, 79, 1, NULL, '2026-02-19 02:56:15', '2026-02-19 02:56:15'),
(34, 8, 95, 2, NULL, '2026-02-19 02:56:15', '2026-02-19 02:56:15'),
(35, 8, 112, 1, NULL, '2026-02-19 02:56:15', '2026-02-19 02:56:15'),
(36, 8, 126, 1, NULL, '2026-02-19 02:56:15', '2026-02-19 02:56:15'),
(37, 8, 75, 2, NULL, '2026-02-19 02:56:15', '2026-02-19 02:56:15'),
(38, 8, 77, 1, NULL, '2026-02-19 02:56:15', '2026-02-19 02:56:15'),
(39, 8, 31, 2, NULL, '2026-02-19 02:56:15', '2026-02-19 02:56:15'),
(40, 8, 106, 1, NULL, '2026-02-19 02:56:15', '2026-02-19 02:56:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2026-01-23 00:16:08', '2026-01-23 00:16:08'),
(2, 'supervisor', 'web', '2026-01-23 00:16:08', '2026-01-23 00:16:08'),
(3, 'ventas', 'web', '2026-01-23 00:16:08', '2026-01-23 00:16:08'),
(4, 'almacen', 'web', '2026-01-23 00:16:08', '2026-01-23 00:16:08'),
(5, 'mantenimiento', 'web', '2026-01-23 00:16:08', '2026-01-23 00:16:08'),
(6, 'fabrica', 'web', '2026-01-23 00:16:08', '2026-01-23 00:16:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('9zKk1REfzqcH4cU2bjZyNTyzKilccuPP1TZXTiE4', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid1FzbXhGQVZ1bllNb0hLazk0SjRLTUxQRWxYWUVQVFVlMDkxMk5JTCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1771619569),
('c3P86pJRo1IHCVs209ypvcqcjOX9thio7x987i2H', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM1ozMTVyT1R4U1F6R0NoTGMzYVRyWHZXMlhzMVlzaTF5YkNVYnU5VSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1771866124),
('RQ5aJykhUul0VQKbpwSGYS7GCBXEEe6o2r2nXKOb', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUUh6cWN6T3FOR2JNVUtxelNubDRlVkQ0TDhJZ013Q3pFaVBDclQ1dyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi91c3Vhcmlvcy9jcmVhdGUiO3M6NToicm91dGUiO3M6MjE6ImFkbWluLnVzdWFyaW9zLmNyZWF0ZSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1771623209);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursals`
--

CREATE TABLE `sucursals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `ciudad` varchar(255) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sucursals`
--

INSERT INTO `sucursals` (`id`, `nombre`, `direccion`, `ciudad`, `activo`, `created_at`, `updated_at`) VALUES
(2, 'DULCE NOVIEMBRE SUC CTM', 'Calz. Américas # 2710 Esq. presa de la amistad, plaza 27diez , Cuauhtémoc Chih.', 'Cuauhtémoc', 1, '2026-01-23 02:16:38', '2026-01-23 02:16:38'),
(3, 'DULCE NOVIEMBRE SUC TRES VÍAS', 'AV. Mirador 1600, Campestre III etapa, Campestre Lomas Frente a Alsuper Tres Vias.', 'Chihuahua', 1, '2026-01-23 02:17:15', '2026-01-23 02:17:15'),
(4, 'DULCE NOVIEMBRE SUC POLITÉCNICO', 'Sucursal Politécnico, Av politécnico nacional s/n y quintas del sol, 31214 junto a Gelo´s Market', 'Chihuahua', 1, '2026-01-23 02:17:35', '2026-01-23 02:17:35'),
(5, 'DULCE NOVIEMBRE SUC CAFÉ (PASTELERIA)', 'Av. Vicente Guerrero y C. 11a, Col. Centro', 'Cuauhtémoc', 1, '2026-01-23 02:43:32', '2026-02-14 01:43:15'),
(6, 'DULCE NOVIEMBRE SUC RIO GRANDE', 'Atrás de Rio Grande Mall, enseguida del restaurant Villa del Mar, sobre la Av Vicente Guerrero 4178', 'Juárez', 1, '2026-01-23 02:43:55', '2026-01-23 02:43:55'),
(8, 'BENNY PASTELERIA', 'Av. Américas Col. CTM', 'Cuauhtémoc', 1, '2026-01-23 21:31:08', '2026-01-23 21:31:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal_user`
--

CREATE TABLE `sucursal_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sucursal_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sucursal_user`
--

INSERT INTO `sucursal_user` (`id`, `user_id`, `sucursal_id`, `created_at`, `updated_at`) VALUES
(1, 2, 8, NULL, NULL),
(2, 2, 5, NULL, NULL),
(3, 2, 2, NULL, NULL),
(4, 2, 4, NULL, NULL),
(5, 2, 6, NULL, NULL),
(6, 2, 3, NULL, NULL),
(7, 3, 8, NULL, NULL),
(8, 3, 5, NULL, NULL),
(9, 3, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `activo`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2026-02-18 23:23:57', '$2y$12$OAx2R1nqbpViuVZcXG43aeOr4DiEAwybR6o9E.pkCtpT40t6ujMKq', 0, '6wEh1vl5nm', '2026-02-18 23:23:58', '2026-02-20 02:44:28'),
(2, 'Administrador', 'admin@pasteladmin.com', NULL, '$2y$12$lgSur81y.74mFFU.iQklI.BECYTU.77oBHCs8wB9FFKTW6yNCo84G', 1, NULL, '2026-02-18 23:28:11', '2026-02-18 23:31:48'),
(3, 'Susana Amador', 'matriz@pasteladmin.com', NULL, '$2y$12$YHfE8IyRzroUY8c83.uom.XBOAixxdNoGaUPrxV32kEvzi06OqqwC', 1, NULL, '2026-02-21 02:27:10', '2026-02-21 02:27:32');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `movimientos_inventario`
--
ALTER TABLE `movimientos_inventario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movimientos_inventario_producto_variante_id_foreign` (`producto_variante_id`),
  ADD KEY `movimientos_inventario_sucursal_origen_id_foreign` (`sucursal_origen_id`),
  ADD KEY `movimientos_inventario_sucursal_destino_id_foreign` (`sucursal_destino_id`);

--
-- Indices de la tabla `ordenes_venta`
--
ALTER TABLE `ordenes_venta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ordenes_venta_folio_unique` (`folio`),
  ADD KEY `ordenes_venta_sucursal_id_foreign` (`sucursal_id`);

--
-- Indices de la tabla `orden_venta_detalles`
--
ALTER TABLE `orden_venta_detalles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orden_venta_detalles_orden_venta_id_foreign` (`orden_venta_id`),
  ADD KEY `orden_venta_detalles_producto_variante_id_foreign` (`producto_variante_id`);

--
-- Indices de la tabla `orden_venta_gastos`
--
ALTER TABLE `orden_venta_gastos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orden_venta_gastos_orden_venta_id_foreign` (`orden_venta_id`);

--
-- Indices de la tabla `orden_venta_mermas`
--
ALTER TABLE `orden_venta_mermas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orden_venta_mermas_orden_venta_id_foreign` (`orden_venta_id`),
  ADD KEY `orden_venta_mermas_producto_variante_id_foreign` (`producto_variante_id`);

--
-- Indices de la tabla `orden_venta_pagos`
--
ALTER TABLE `orden_venta_pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orden_venta_pagos_orden_venta_id_foreign` (`orden_venta_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productos_categoria_id_foreign` (`categoria_id`);

--
-- Indices de la tabla `producto_sucursal`
--
ALTER TABLE `producto_sucursal`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `producto_sucursal_sucursal_id_producto_variante_id_unique` (`sucursal_id`,`producto_variante_id`),
  ADD KEY `producto_sucursal_producto_variante_id_foreign` (`producto_variante_id`);

--
-- Indices de la tabla `producto_variantes`
--
ALTER TABLE `producto_variantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `producto_variantes_producto_id_nombre_unique` (`producto_id`,`nombre`);

--
-- Indices de la tabla `remisiones`
--
ALTER TABLE `remisiones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `remisiones_folio_unique` (`folio`),
  ADD KEY `remisiones_sucursal_id_foreign` (`sucursal_id`);

--
-- Indices de la tabla `remision_detalles`
--
ALTER TABLE `remision_detalles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `remision_detalles_remision_id_foreign` (`remision_id`),
  ADD KEY `remision_detalles_producto_variante_id_foreign` (`producto_variante_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `sucursals`
--
ALTER TABLE `sucursals`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sucursal_user`
--
ALTER TABLE `sucursal_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sucursal_user_user_id_sucursal_id_unique` (`user_id`,`sucursal_id`),
  ADD KEY `sucursal_user_sucursal_id_foreign` (`sucursal_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `movimientos_inventario`
--
ALTER TABLE `movimientos_inventario`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ordenes_venta`
--
ALTER TABLE `ordenes_venta`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `orden_venta_detalles`
--
ALTER TABLE `orden_venta_detalles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=633;

--
-- AUTO_INCREMENT de la tabla `orden_venta_gastos`
--
ALTER TABLE `orden_venta_gastos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `orden_venta_mermas`
--
ALTER TABLE `orden_venta_mermas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `orden_venta_pagos`
--
ALTER TABLE `orden_venta_pagos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT de la tabla `producto_sucursal`
--
ALTER TABLE `producto_sucursal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT de la tabla `producto_variantes`
--
ALTER TABLE `producto_variantes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT de la tabla `remisiones`
--
ALTER TABLE `remisiones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `remision_detalles`
--
ALTER TABLE `remision_detalles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `sucursals`
--
ALTER TABLE `sucursals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `sucursal_user`
--
ALTER TABLE `sucursal_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `movimientos_inventario`
--
ALTER TABLE `movimientos_inventario`
  ADD CONSTRAINT `movimientos_inventario_producto_variante_id_foreign` FOREIGN KEY (`producto_variante_id`) REFERENCES `producto_variantes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movimientos_inventario_sucursal_destino_id_foreign` FOREIGN KEY (`sucursal_destino_id`) REFERENCES `sucursals` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `movimientos_inventario_sucursal_origen_id_foreign` FOREIGN KEY (`sucursal_origen_id`) REFERENCES `sucursals` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `ordenes_venta`
--
ALTER TABLE `ordenes_venta`
  ADD CONSTRAINT `ordenes_venta_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursals` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `orden_venta_detalles`
--
ALTER TABLE `orden_venta_detalles`
  ADD CONSTRAINT `orden_venta_detalles_orden_venta_id_foreign` FOREIGN KEY (`orden_venta_id`) REFERENCES `ordenes_venta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orden_venta_detalles_producto_variante_id_foreign` FOREIGN KEY (`producto_variante_id`) REFERENCES `producto_variantes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `orden_venta_gastos`
--
ALTER TABLE `orden_venta_gastos`
  ADD CONSTRAINT `orden_venta_gastos_orden_venta_id_foreign` FOREIGN KEY (`orden_venta_id`) REFERENCES `ordenes_venta` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `orden_venta_mermas`
--
ALTER TABLE `orden_venta_mermas`
  ADD CONSTRAINT `orden_venta_mermas_orden_venta_id_foreign` FOREIGN KEY (`orden_venta_id`) REFERENCES `ordenes_venta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orden_venta_mermas_producto_variante_id_foreign` FOREIGN KEY (`producto_variante_id`) REFERENCES `producto_variantes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `orden_venta_pagos`
--
ALTER TABLE `orden_venta_pagos`
  ADD CONSTRAINT `orden_venta_pagos_orden_venta_id_foreign` FOREIGN KEY (`orden_venta_id`) REFERENCES `ordenes_venta` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `producto_sucursal`
--
ALTER TABLE `producto_sucursal`
  ADD CONSTRAINT `producto_sucursal_producto_variante_id_foreign` FOREIGN KEY (`producto_variante_id`) REFERENCES `producto_variantes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `producto_sucursal_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursals` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `producto_variantes`
--
ALTER TABLE `producto_variantes`
  ADD CONSTRAINT `producto_variantes_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `remisiones`
--
ALTER TABLE `remisiones`
  ADD CONSTRAINT `remisiones_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursals` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `remision_detalles`
--
ALTER TABLE `remision_detalles`
  ADD CONSTRAINT `remision_detalles_producto_variante_id_foreign` FOREIGN KEY (`producto_variante_id`) REFERENCES `producto_variantes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `remision_detalles_remision_id_foreign` FOREIGN KEY (`remision_id`) REFERENCES `remisiones` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sucursal_user`
--
ALTER TABLE `sucursal_user`
  ADD CONSTRAINT `sucursal_user_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sucursal_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
