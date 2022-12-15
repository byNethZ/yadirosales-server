-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 07-11-2022 a las 16:03:12
-- Versión del servidor: 8.0.31-0ubuntu0.22.04.1
-- Versión de PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `yadi_rosales`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `properties`
--

CREATE TABLE `properties` (
  `id` bigint UNSIGNED NOT NULL,
  `list_number` int DEFAULT NULL,
  `approved` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `public` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modify_timestamp` datetime DEFAULT NULL,
  `picture_count` int DEFAULT NULL,
  `subtype` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_number` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` char(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_suffix` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `county` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sq_total` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year_built` int DEFAULT NULL,
  `lot_size` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acres` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rooms` int DEFAULT NULL,
  `bedrooms` int DEFAULT NULL,
  `baths` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `baths_full` int DEFAULT NULL,
  `baths_mid` int DEFAULT NULL,
  `taxes` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subdivision` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `taxmap` char(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `legal_desc` char(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deed_page` char(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deed_book` char(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `elementary_school` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middle_school` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `high_school` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hoa_fee` char(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `directions` text COLLATE utf8mb4_unicode_ci,
  `auction` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_warranty` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `builders_warranty` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `public_remarks` text COLLATE utf8mb4_unicode_ci,
  `monthly_rent` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `units` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fireplace_list` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pets_allowed` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `garage_parking` text COLLATE utf8mb4_unicode_ci,
  `owner` char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gf_appliances` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `basement` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bed_bath` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `brick_stone` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gf_community_features` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cooling` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dining` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `documents` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gf_equipment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gf_exterior` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `exterior_features` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `financing_available` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gf_fireplace` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `floors` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gf_foundation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gf_furnished` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gf_garage` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gf_green_features` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `heating` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `interior` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `lease_terms` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gf_lot_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gf_new_construction` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `owner_pays` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pool` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `possession` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `roofing` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gf_rooms` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `showing` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gf_special_needs` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `style` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tenant_pays` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type_sale` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `utilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `water_sewer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `windows` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `existing_financing` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `unit_one_features` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `unit_two_features` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `unit_three_features` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `unit_four_features` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `clear_percent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `adjacent_use` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `docs_file` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `flood_zone` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `improvements` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `options` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `road` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `shape` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `structures` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `listing_member_shortid` char(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `colisting_member_shortid` char(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `selling_member_shortid` char(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coselling_member_shortid` char(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `listing_member_name` char(122) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `colisting_member_name` char(122) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `selling_member_name` char(122) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coselling_member_name` char(122) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `listing_office_name` char(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `selling_office_name` char(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `colisting_office_name` char(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coselling_office_name` char(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `properties`
--

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `properties`
--
ALTER TABLE `properties`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
