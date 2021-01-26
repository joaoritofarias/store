-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2020 at 08:18 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--
CREATE DATABASE IF NOT EXISTS `store` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `store`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `parent_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `parent_id`) VALUES
(1, 'Sofás', 0),
(2, 'Sofás de tecido', 1),
(3, 'Sofás modulares', 1),
(4, 'Camas', 0),
(5, 'Camas de casal', 4),
(6, 'Camas individuais', 4);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `payment_date`) VALUES
(1, 2, '2020-10-16 20:11:53', NULL),
(2, 2, '2020-10-16 20:25:57', NULL),
(3, 2, '2020-10-16 20:28:13', NULL),
(4, 4, '2020-10-26 21:03:44', NULL),
(5, 4, '2020-10-26 21:13:59', NULL),
(6, 4, '2020-10-26 21:16:50', NULL),
(7, 4, '2020-10-28 20:34:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders_products`
--

CREATE TABLE `orders_products` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` smallint(5) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders_products`
--

INSERT INTO `orders_products` (`order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 4, 1, '749.00'),
(1, 6, 1, '99.00'),
(2, 4, 1, '749.00'),
(2, 6, 1, '99.00'),
(3, 4, 1, '749.00'),
(3, 6, 1, '99.00'),
(4, 1, 4, '329.00'),
(5, 1, 4, '329.00'),
(6, 8, 1, '29.99'),
(7, 5, 4, '219.00'),
(7, 8, 1, '29.99');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(128) NOT NULL,
  `stock` int(11) NOT NULL,
  `category_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `image`, `stock`, `category_id`) VALUES
(1, 'KIVIK', '<p>Sofá 3 lugares, Orrsta cinz clr</p>\r\n<p>Aninhe-se no conforto da espuma memory. O material adapta-se aos contornos do seu corpo e convida-o para longas horas de descanso, descontração e sestas. Não se preocupe com as manchas, a capa é lavável.</p>', '329.00', 'kivik-sofa-3-lugares-orrsta-cinz-clr__0719396_PE732045_S5.JPG', 32, 2),
(2, 'ESKILSTUNA', '<p>Sofá 3 lugares, c/chaise longue/Hillared antracite</p>\r\n<p>A chaise longue pode ser colocada à esquerda ou à direita do sofá; mude-a quando quiser.</p>\r\n<p>Guarde, por exemplo, roupa de cama no espaço de arrumação da secção de canto.</p>', '699.00', 'eskilstuna-sofa-3-lugares-c-chaise-longue-hillared-antracite__0794771_PE765710_S5.JPG', 0, 2),
(3, 'SÖDERHAMN', '<p>Secção 3 lugares, Viarp bege/castanho</p>\r\n<p>A gama de sofás SÖDERHAMN tem assentos fundos, baixos e fofos, com almofadas soltas de encosto para um melhor apoio.</p>\r\n<p>O tecido elástico da base e a espuma de elevada elasticidade nas almofadas do assento proporcionam grande conforto.</p>', '469.00', 'soederhamn-seccao-3-lugares-viarp-bege-castanho__0802813_PE768605_S5.JPG', 10, 3),
(4, 'LANDSKRONA', '<p>Sofá 3 lugares, c/chaise longue/Gunnared verde claro/madeira</p>\r\n<p>Almofadas do assento com enchimento em espuma de grande resistência e forro em fibra poliéster, que proporcionam um elevado conforto.</p><p>Braços facilmente adaptáveis a uma chaise-longue.</p>', '749.00', 'landskrona-sofa-3-lugares-c-chaise-longue-gunnared-verde-claro-madeira__0602395_PE680328_S5.JPG', 3, 3),
(5, 'MALM', '<p>Estrutura de cama, branco/Lönset140x200 cm</p>\r\n<p>As laterais da cama permitem regular a altura do estrado para colchões de diferentes espessuras.</p>\r\n<p>28 ripas de lâminas coladas de madeira de bétula, divididas em 5 zonas de conforto, que se adaptam ao peso do corpo e aumentam a suavidade do colchão.</p>', '219.00', 'malm-estrutura-de-cama-branco-loenset__0860700_PE662041_S5.JPG', 16, 5),
(6, 'SLATTUM', '<p>Estrutura de cama acolchoada, Knisa cinz clr140x200 cm</p>', '99.00', 'slattum-estrutura-de-cama-acolchoada-knisa-cinz-clr__0768244_PE754388_S5.JPG', 31, 5),
(7, 'UTÅKER', '<p>Cama empilhável, pinho80x200 cm</p>\r\n<p>As camas empilhadas são estáveis uma vez que a cama de cima tem pequenos pés em plástico que encaixam em orifícios na cama de baixo.</p>', '139.00', 'utaker-cama-empilhavel-pinho__0800111_PH165821_S5.JPG', 14, 6),
(8, 'NEIDEN', '<p>Estrutura de cama, pinho90x200 cm</p>\r\n<p>Se tratar a superfície de madeira maciça com óleo, cera ou verniz, esta vai durar mais tempo e é mais fácil de manter.</p>\r\n<p>O estrado de ripas, o colchão e a roupa de cama são vendidos em separado.</p>', '29.99', 'neiden-estrutura-de-cama-pinho__0749132_PE745501_S5.JPG', 47, 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(252) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(64) NOT NULL,
  `postal_code` varchar(32) NOT NULL,
  `country` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `phone`, `address`, `city`, `postal_code`, `country`) VALUES
(2, 'Ivo', 'justivo@gmail.com', '$2y$10$qg7WyqE9uXA/9n8YFNhELOXPrvuLMAOgkAMRZG72tLLCcEJxd/qX6', '9283912839', 'Rua Algures', 'Acolá', '1233-233', 'Portugal'),
(3, 'Ivo', 'justivo@cenas.com', '$2y$10$zVSjXxAMKMnDA8wR4TnJzeLAdFf.Ix/CqMIyXVnFu1spKa6NHLsaO', '9879879', 'oiuiojlkj', 'ou09uio9i', 'o8987', 'Portugal'),
(4, 'Ivo', 'justivo@coiso.com', '$2y$10$pigMHyExXBKHAwyHtudU1Oe8HbFnKk4XD964rf7gRh2KNeWIwD.xC', '8987989', 'ijkih', 'iuo988', 'o98989', 'Portugal'),
(6, 'Ivo', 'justivo@username.com', '$2y$10$WZQvOSLvX0g8eIR.fPviPOWyq8dl7U/bk3cW3HLOD2OthY5ytf2/G', 'iasiduiku', 'o9uoiujiluj', 'o9uo9iu', 'o9i8908', 'Portugal'),
(7, 'Ivo', 'justivo@coisas.com', '$2y$10$PFCAWdDfyjnRf8wQguEEt.waYRgzt9t35P3FffYWJM9WJ.mNEEhjC', 'jilioikjo', 'ijoii', 'opiopiol', '28913', 'Portugal');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders_products`
--
ALTER TABLE `orders_products`
  ADD PRIMARY KEY (`order_id`,`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
